<?php

namespace App\Http\Controllers\Docker;

use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use phpseclib3\Net\SSH2;
use Symfony\Component\Yaml\Yaml;


class ServicesController extends Controller
{
    private $runningExecutions = [];
    private $dockerApiUrl;

    public function __construct()
    {
        $this->dockerApiUrl = 'http://192.168.11.131:2375/v1.43';
    }

//     public function listServices()
//     {
//         try {
// //             Fetch services from Docker API

// $response = Http::get("{$this->dockerApiUrl}/containers/json", [
//   'all' => true,
//   'filters' => json_encode([
//                 'label' => ['com.docker.compose.project=free5gc-compose'], // Filter by project label
//             ]),
// ]);

//             if ($response->ok()) {
//                 $servicesJson = $response->json();


//                 $processedServices = array_map(function ($service) {
//                     return [
//                         'id' => $service['Id'] ?? 'N/A',
//                         'name' => $service['Names'][0] ?? 'N/A',
//                         'status' => $service['Status'] ?? 'Unknown',
//                         'state' => $service['State'] ?? 'Unknown',
//                         'ip' => $service["NetworkSettings"]["Networks"]["free5gc-compose_privnet"]['IPAddress'] ?? 'N/A',
//                     ];
//                 }, $servicesJson);


//                 return view('docker.services', ["services" => $processedServices]);
//             }

//             return response()->json(['error' => 'Failed to fetch services'], 500);

//         } catch (\Exception $e) {
//             return response()->json(['error' => $e->getMessage()], 500);
//         }
//     }

public function listServices()
{
    try {
        // Fetch services from Docker API
        $response = Http::get("{$this->dockerApiUrl}/containers/json", [
            'all' => true,
            'filters' => json_encode([
                'label' => ['com.docker.compose.project=free5gc-compose'], // Filter by project label
            ]),
        ]);

        if ($response->ok()) {
            $servicesJson = $response->json();

            // Define the required services in the desired order
            $requiredServices = ['amf', 'smf', 'upf', 'udr', 'chf', 'pcf', 'nrf', 'ausf', 'nssf'];

            // Filter and map services
            $processedServices = [];
            foreach ($requiredServices as $serviceName) {
                foreach ($servicesJson as $service) {
                    if (strpos($service['Names'][0] ?? '', $serviceName) !== false) {
                        $processedServices[] = [
                            'id' => $service['Id'] ?? 'N/A',
                            'name' => $serviceName, // Ensure name matches required order
                            'status' => $service['Status'] ?? 'Unknown',
                            'state' => $service['State'] ?? 'Unknown',
                            'ip' => $service["NetworkSettings"]["Networks"]["free5gc-compose_privnet"]['IPAddress'] ?? 'N/A',
                        ];
                        break; // Move to next required service
                    }
                }
            }

            return view('docker.services', ["services" => $processedServices]);
        }

        return response()->json(['error' => 'Failed to fetch services'], 500);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function getConfigFromVM()
    {
        try {
            $ssh = new SSH2('192.168.11.131');
       if (!$ssh->login('imran', 'imran')) {
           return response()->json(['success' => false, 'message' => 'Login failed'], 401);
       }

       // Path to the YAML file on the VM
       $filePath = '/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml';
        $content = $ssh->exec("cat $filePath");
            $yamlContent = Yaml::parse($content);
            // dd($yamlContent);
            // Optional: Parse YAML if needed
            return view('docker.config', ['yamlContent' => $yamlContent]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function AMFConfigs()
    {
        try {
           $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml';
            $content = $sshService->getFileContent($filePath);

            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"AMF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function SMFConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/smfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"SMF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function UDMConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/udmcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"UDM Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function UDRConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/udrcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"UDR Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function AUSFConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/ausfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"AUSF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function PCFConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/pcfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"PCF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function CHFConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/chfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"CHF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function EHRConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/ehrcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"EHR Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function NRFconfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/nrfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"NRF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function UPFConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/config/upfcfg.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"UPF Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function systemConfigs()
    {
        try {
            $sshService = new SSHService();
            $filePath = '/home/imran/free5gc/free5gc-compose/docker-compose.yaml';
            $content = $sshService->getFileContent($filePath);


            $yamlContent = Yaml::parse($content);

            return view('docker.system_config', ['yamlContent' => $yamlContent, "page"=>"System Configuration"]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
            // Validate the input
            $request->validate([
                'command' => 'required|string',
            ]);

            // Prepare the command execution request
            $response = Http::post("{$this->dockerApiUrl}/containers/{$containerId}/exec", [
                'AttachStdin' => false,
                'AttachStdout' => true,
                'AttachStderr' => true,
                'Tty' => false,
                'Cmd' => ['bash', '-c', $request->input('command')], // Use bash to execute the command
            ]);

            if ($response->successful()) {
                $execId = $response->json()['Id'];
// Store the execId for later use
                $this->runningExecutions[$containerId] = $execId;

                // Start the exec instance and stream the response
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
                            // Filter out unwanted content (e.g., HTML, JavaScript)
                            if (!str_contains($chunk, '<html>') && !str_contains($chunk, '<script>')) {
                                echo $chunk;
                                ob_flush();
                                flush();
                            }
                        }
                    }

                    // Remove the execId from running executions once the stream ends
                    unset($this->runningExecutions[$containerId]);

                }, 200, [
                    'Content-Type' => 'text/plain',
                ]);

            }else{
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

                // Kill the exec instance
                $response = Http::post("{$this->dockerApiUrl}/exec/{$execId}/kill");

                if ($response->successful()) {
                    // Remove the execId from running executions
                    unset($this->runningExecutions[$containerId]);
                    return response()->json(['message' => 'Command stopped successfully.'], 200);
                }
            }

            return response()->json(['error' => 'No running command found.'], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function startFullSetup()
    {
        $host = '192.168.11.131';
        $user = 'imran';
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
        $host = '192.168.11.131';
        $user = 'imran';
        $command = "cd /home/imran/free5gc/free5gc-compose/ && docker-compose down";
    
        try {
            // Execute SSH command properly with escaped double quotes
            $output = shell_exec("ssh -o StrictHostKeyChecking=no {$user}@{$host} \"{$command}\" 2>&1");
    
            return redirect()->route('services.list')->with('success', 'Docker stopped! Output:<br>' . nl2br($output));
        } catch (\Exception $e) {
            return redirect()->route('services.list')->with('error', 'Failed: ' . $e->getMessage());
        }
    }
    

}
