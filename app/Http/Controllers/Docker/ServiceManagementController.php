<?php
namespace App\Http\Controllers\Docker;
use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use phpseclib3\Net\SSH2;
use Symfony\Component\Yaml\Yaml;
use App\Constants\Constant;
class ServiceManagementController extends Controller
{
    private $dockerApiUrl;
    public function __construct()
    {
        $this->dockerApiUrl = config('services.docker.api_url');
    }
    public function listServices()
    {
        try {
            // $response = Http::get("{$this->dockerApiUrl}/containers/json", [
            //     'all' => true,
            //     'filters' => json_encode([
            //         'label' => ['com.docker.compose.project=free5gc-compose'], // Filter by project label
            //     ]),
            // ]);
            // if ($response->ok()) {
            //     $servicesJson = $response->json();
            //     $requiredServices = Constant::REQUIRED_SERVICES;
            //     $processedServices = [];
            //     foreach ($requiredServices as $serviceName) {
            //         foreach ($servicesJson as $service) {
            //             if (strpos($service['Names'][0] ?? '', $serviceName) !== false) {
            //                 $processedServices[] = [
            //                     'id' => $service['Id'] ?? 'N/A',
            //                     'name' => $serviceName, // Ensure name matches required order
            //                     'status' => $service['Status'] ?? 'Unknown',
            //                     'state' => $service['State'] ?? 'Unknown',
            //                     'ip' => $service["NetworkSettings"]["Networks"]["free5gc-compose_privnet"]['IPAddress'] ?? 'N/A',
            //                 ];
            //                 break; // Move to next required service
            //             }
            //         }
            //     }
            // }
            $processedServices = [
                [
                    'id' => 'abcdef1234567890',
                    'name' => 'service1',
                    'status' => 'Running',
                    'state' => 'Up 10 minutes',
                    'ip' => '192.168.1.10',
                ],
                [
                    'id' => 'abcdef1234567891',
                    'name' => 'service2',
                    'status' => 'exited',
                    'state' => 'exited',
                    'ip' => '192.168.1.11',
                ],
                [
                    'id' => 'abcdef1234567892',
                    'name' => 'service3',
                    'status' => 'running',
                    'state' => 'Up 5 minutes',
                    'ip' => '192.168.1.12',
                ],
                [
                    'id' => 'abcdef1234567893',
                    'name' => 'service4',
                    'status' => 'running',
                    'state' => 'running',
                    'ip' => '192.168.1.13',
                ],
                // Add more sample services if needed
            ];
            return view('docker.services', ["services" => $processedServices]);

            
            return response()->json(['error' => 'Failed to fetch services'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function startFullSetup()
    {
        $host = config('services.docker.app_host');
        $user = config('services.docker.user_name');
        $command = 'cd /home/imran/free5gc/free5gc-compose/ && docker-compose up -d';
        try {
            // Execute SSH command and capture output
            $output = shell_exec("ssh -o StrictHostKeyChecking=no {$user}@{$host} \"{$command}\" 2>&1");
            return redirect()->route('services.list')->with('success', 'Docker started! Output:<br>' . nl2br($output));
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', 'Failed: ' . $e->getMessage());
        }
    }
    public function stopFullSetup()
    {
        $host = config('services.docker.app_host');
        $user = config('services.docker.user_name');
        $command = "cd /home/imran/free5gc/free5gc-compose/ && docker-compose down";
        try {
            $output = shell_exec("ssh -o StrictHostKeyChecking=no {$user}@{$host} \"{$command}\" 2>&1");
            return redirect()->route('services.list')->with('success', 'Docker stopped! Output:<br>' . nl2br($output));
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', 'Failed: ' . $e->getMessage());
        }
    }
    public function startService($containerId)
    {
        try {
            $response = Http::post("{$this->dockerApiUrl}/containers/{$containerId}/start");
            if ($response->successful()) {
                return redirect()->route('services.list')->with('success', 'Service started successfully!');
            }
            return redirect()->route('services.list')->with('error', 'Failed to start service.');
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', $e->getMessage());
        }
    }
    public function stopService($containerId)
    {
        try {
            $response = Http::post("{$this->dockerApiUrl}/containers/{$containerId}/stop");
            if ($response->successful()) {
                return redirect()->route('services.list')->with('success', 'Service stopped successfully!');
            }
            return redirect()->route('services.list')->with('error', 'Failed to stop service.');
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', $e->getMessage());
        }
    }
    public function restartService($containerId)
    {
        try {
            $response = Http::post("{$this->dockerApiUrl}/containers/{$containerId}/restart");
            if ($response->successful()) {
                return redirect()->route('services.list')->with('success', 'Service restarted successfully!');
            }
            return redirect()->route('services.list')->with('error', 'Failed to restart service.');
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', $e->getMessage());
        }
    }
}
