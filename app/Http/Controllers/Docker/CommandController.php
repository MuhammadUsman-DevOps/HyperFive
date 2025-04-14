<?php
namespace App\Http\Controllers\Docker;
use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use phpseclib3\Net\SSH2;
use Symfony\Component\Yaml\Yaml;
class CommandController extends Controller
{
    private $runningExecutions = [];
    private $dockerApiUrl;
    public function __construct()
    {
        $this->dockerApiUrl = config('services.docker.api_url');
    }
    public function viewLogs($containerId)
    {
        try {
            $response = Http::get("{$this->dockerApiUrl}/containers/{$containerId}/logs", [
                'stdout' => true, // Include standard output logs
                'stderr' => true, // Include standard error logs
                'timestamps' => true, // Include timestamps
            ]);
            if ($response->successful()) {
                $logs = $response->body();
                return view('docker.logs', [
                    'logs' => $logs,
                    'containerId' => $containerId,
                ]);
            }
            return redirect()->route('services.list')->with('error', 'Failed to fetch logs.');
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', $e->getMessage());
        }
    }
    public function commandExecutionPage($containerId)
    {
        return view('docker.command_execution', [
            'containerId' => $containerId,
        ]);
    }
    public function executeCommand($containerId, Request $request)
    {
        try {
            $request->validate([
                'command' => 'required|string',
            ]);
            $response = Http::post("{$this->dockerApiUrl}/containers/{$containerId}/exec", [
                'AttachStdin' => false,
                'AttachStdout' => true,
                'AttachStderr' => true,
                'Tty' => false,
                'Cmd' => ['bash', '-c', $request->input('command')], // Use bash to execute the command
            ]);
            if ($response->successful()) {
                $execId = $response->json()['Id'];
                $this->runningExecutions[$containerId] = $execId;
                return response()->stream(function () use ($execId, $containerId) {
                    $streamResponse = Http::withOptions([
                        'stream' => true, // Enable streaming
                    ])->post("{$this->dockerApiUrl}/exec/{$execId}/start", [
                        'Detach' => false,
                        'Tty' => false,
                    ]);
                    if ($streamResponse->successful()) {
                        $stream = $streamResponse->toPsrResponse()->getBody();
                        while (!$stream->eof()) {
                            $chunk = $stream->read(1024);
                            if (!str_contains($chunk, '<html>') && !str_contains($chunk, '<script>')) {
                                echo $chunk;
                                ob_flush();
                                flush();
                            }
                        }
                    }
                    unset($this->runningExecutions[$containerId]);
                }, 200, [
                    'Content-Type' => 'text/plain',
                ]);
            } else {
                return response()->json(['error' => 'Failed to execute command.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function stopCommand($containerId)
    {
        try {
            if (isset($this->runningExecutions[$containerId])) {
                $execId = $this->runningExecutions[$containerId];
                $response = Http::post("{$this->dockerApiUrl}/exec/{$execId}/kill");
                if ($response->successful()) {
                    unset($this->runningExecutions[$containerId]);
                    return response()->json(['message' => 'Command stopped successfully.'], 200);
                }
            }
            return response()->json(['error' => 'No running command found.'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
