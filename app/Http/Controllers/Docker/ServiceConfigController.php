<?php
namespace App\Http\Controllers\Docker;
use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use phpseclib3\Net\SSH2;
use Symfony\Component\Yaml\Yaml;
class ServiceConfigController extends Controller
{
    public function __construct()
    {
    }
    public function getConfigFromVM()
    {
        try {
            $sshHost = config('services.docker.app_host');
            $sshUsername = config('services.docker.user_name');
            $sshPassword = config('services.docker.user_password');
            $ssh = new SSH2($sshHost);
            if (!$ssh->login($sshUsername, $sshPassword)) {
                return response()->json(['success' => false, 'message' => 'Login failed'], 401);
            }
            $filePath = '/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml';
            $content = $ssh->exec("cat $filePath");
            $yamlContent = Yaml::parse($content);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "AMF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "SMF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "UDM Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "UDR Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "AUSF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "PCF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "CHF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "EHR Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "NRF Configuration"]);
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
            return view('docker.config', ['yamlContent' => $yamlContent, "page" => "UPF Configuration"]);
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
            return view('docker.system_config', ['yamlContent' => $yamlContent, "page" => "System Configuration"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
