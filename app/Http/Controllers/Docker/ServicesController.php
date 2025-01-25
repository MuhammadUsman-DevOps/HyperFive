<?php

namespace App\Http\Controllers\Docker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use phpseclib3\Net\SSH2;
use Symfony\Component\Yaml\Yaml;


class ServicesController extends Controller
{
    private $dockerApiUrl;

    public function __construct()
    {
        $this->dockerApiUrl = 'http://192.168.11.129:2375/v1.43';
    }

    public function listServices()
    {
       try {
//             Fetch services from Docker API
           $response = Http::get("{$this->dockerApiUrl}/containers/json");
          
           if ($response->ok()) {
               $servicesJson = $response->json();

        
            $processedServices = array_map(function ($service) {
                return [
                    'id' => $service['Id'] ?? 'N/A',
                    'name' => $service['Names'][0] ?? 'N/A',
                    'status' => $service['Status'] ?? 'Unknown',
                    'state' => $service['State'] ?? 'Unknown',
                    'ip'=>$service["NetworkSettings"]["Networks"]["free5gc-compose_privnet"]['IPAddress'] ?? 'N/A',
                ];
            }, $servicesJson);


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
        $ssh = new SSH2('192.168.11.129');
        if (!$ssh->login('imran', 'imran')) {
            return response()->json(['success' => false, 'message' => 'Login failed'], 401);
        }

        // Path to the YAML file on the VM
        $filePath = '/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml';
        $content = $ssh->exec("cat $filePath");
          // dd($content);s
        $yamlContent = Yaml::parse($content);
        // dd($yamlContent);
        // Optional: Parse YAML if needed
        return view('docker.config', ['yamlContent' => $yamlContent]);

      } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
