<?php

namespace App\Http\Controllers\Docker;

use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    public function listServices()
    {
        try {
//             Fetch services from Docker API

$response = Http::get("{$this->dockerApiUrl}/containers/json", [
  'all' => true,
  'filters' => json_encode([
                'label' => ['com.docker.compose.project=free5gc-compose'], // Filter by project label
            ]),
]);

            if ($response->ok()) {
                $servicesJson = $response->json();


                $processedServices = array_map(function ($service) {
                    return [
                        'id' => $service['Id'] ?? 'N/A',
                        'name' => $service['Names'][0] ?? 'N/A',
                        'status' => $service['Status'] ?? 'Unknown',
                        'state' => $service['State'] ?? 'Unknown',
                        'ip' => $service["NetworkSettings"]["Networks"]["free5gc-compose_privnet"]['IPAddress'] ?? 'N/A',
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
//        if (!$ssh->login('imran', 'imran')) {
//            return response()->json(['success' => false, 'message' => 'Login failed'], 401);
//        }
//
//        // Path to the YAML file on the VM
//        $filePath = '/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml';
//        $content = $ssh->exec("cat $filePath");
//          // dd($content);s
//
            $content = "info:

  version: 1.0.9

  description: AMF initial local configuration


configuration:

  amfName: AMF # the name of this AMF

  ngapIpList:  # the IP list of N2 interfaces on this AMF

    - amf.free5gc.org

  ngapPort: 38412 # the SCTP port listened by NGAP

  sbi: # Service-based interface information

    scheme: http # the protocol for sbi (http or https)

    registerIPv4: 0.0.0.0 # IP used to register to NRF

    bindingIPv4: 0.0.0.0  # IP used to bind the service

    port: 8000 # port used to bind the service

    tls: # the local path of TLS key

      pem: cert/amf.pem # AMF TLS Certificate

      key: cert/amf.key # AMF TLS Private key

  serviceNameList: # the SBI services provided by this AMF, refer to TS 29.518

    - namf-comm # Namf_Communication service

    - namf-evts # Namf_EventExposure service

    - namf-mt   # Namf_MT service

    - namf-loc  # Namf_Location service

    - namf-oam  # OAM service

  servedGuamiList: # Guami (Globally Unique AMF ID) list supported by this AMF

    # <GUAMI> = <MCC><MNC><AMF ID>

    - plmnId: # Public Land Mobile Network ID, <PLMN ID> = <MCC><MNC>

        mcc: 208 # Mobile Country Code (3 digits string, digit: 0~9)

        mnc: 93 # Mobile Network Code (2 or 3 digits string, digit: 0~9)

      amfId: cafe00 # AMF identifier (3 bytes hex string, range: 000000~FFFFFF)

  supportTaiList:  # the TAI (Tracking Area Identifier) list supported by this AMF

    - plmnId: # Public Land Mobile Network ID, <PLMN ID> = <MCC><MNC>

        mcc: 208 # Mobile Country Code (3 digits string, digit: 0~9)

        mnc: 93 # Mobile Network Code (2 or 3 digits string, digit: 0~9)

      tac: 000001 # Tracking Area Code (3 bytes hex string, range: 000000~FFFFFF)

  plmnSupportList: # the PLMNs (Public land mobile network) list supported by this AMF

    - plmnId: # Public Land Mobile Network ID, <PLMN ID> = <MCC><MNC>

        mcc: 208 # Mobile Country Code (3 digits string, digit: 0~9)

        mnc: 93 # Mobile Network Code (2 or 3 digits string, digit: 0~9)

      snssaiList: # the S-NSSAI (Single Network Slice Selection Assistance Information) list supported by this AMF

        - sst: 1 # Slice/Service Type (uinteger, range: 0~255)

          sd: 010203 # Slice Differentiator (3 bytes hex string, range: 000000~FFFFFF)

        - sst: 1 # Slice/Service Type (uinteger, range: 0~255)

          sd: 112233 # Slice Differentiator (3 bytes hex string, range: 000000~FFFFFF)

  supportDnnList:  # the DNN (Data Network Name) list supported by this AMF

    - internet

  nrfUri: http://nrf.free5gc.org:8000 # a valid URI of NRF

  nrfCertPem: cert/nrf.pem

  security:  # NAS security parameters

    integrityOrder: # the priority of integrity algorithms

      - NIA2

      # - NIA0

    cipheringOrder: # the priority of ciphering algorithms

      - NEA0

      # - NEA2

  networkName:  # the name of this core network

    full: free5GC

    short: free

  ngapIE: # Optional NGAP IEs

    mobilityRestrictionList: # Mobility Restriction List IE, refer to TS 38.413

      enable: true # append this IE in related message or not

    maskedIMEISV: # Masked IMEISV IE, refer to TS 38.413

      enable: true # append this IE in related message or not

    redirectionVoiceFallback: # Redirection Voice Fallback IE, refer to TS 38.413

      enable: false # append this IE in related message or not

  nasIE: # Optional NAS IEs

    networkFeatureSupport5GS: # 5gs Network Feature Support IE, refer to TS 24.501

      enable: true # append this IE in Registration accept or not

      length: 1 # IE content length (uinteger, range: 1~3)

      imsVoPS: 0 # IMS voice over PS session indicator (uinteger, range: 0~1)

      emc: 0 # Emergency service support indicator for 3GPP access (uinteger, range: 0~3)

      emf: 0 # Emergency service fallback indicator for 3GPP access (uinteger, range: 0~3)

      iwkN26: 0 # Interworking without N26 interface indicator (uinteger, range: 0~1)

      mpsi: 0 # MPS indicator (uinteger, range: 0~1)

      emcN3: 0 # Emergency service support indicator for Non-3GPP access (uinteger, range: 0~1)

      mcsi: 0 # MCS indicator (uinteger, range: 0~1)

  t3502Value: 720  # timer value (seconds) at UE side

  t3512Value: 3600 # timer value (seconds) at UE side

  non3gppDeregTimerValue: 3240 # timer value (seconds) at UE side

  # retransmission timer for paging message

  t3513:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Deregistration Request message

  t3522:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Registration Accept message

  t3550:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Configuration Update Command message

  t3555:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Authentication Request/Security Mode Command message

  t3560:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Notification message

  t3565:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  # retransmission timer for NAS Identity Request message

  t3570:

    enable: true     # true or false

    expireTime: 6s   # default is 6 seconds

    maxRetryTimes: 4 # the max number of retransmission

  locality: area1 # Name of the location where a set of AMF, SMF, PCF and UPFs are located

  sctp: # set the sctp server setting <optinal>, once this field is set, please also add maxInputStream, maxOsStream, maxAttempts, maxInitTimeOut

    listenIP: 192.168.11.132

    numOstreams: 3 # the maximum out streams of each sctp connection

    maxInstreams: 5 # the maximum in streams of each sctp connection

    maxAttempts: 2 # the maximum attempts of each sctp connection

    maxInitTimeout: 2 # the maximum init timeout of each sctp connection

  defaultUECtxReq: false # the default value of UE Context Request to decide when triggering Initial Context Setup procedure


logger: # log output setting

  enable: true # true or false

  level: info # how detailed to output, value: trace, debug, info, warn, error, fatal, panic

  reportCaller: false # enable the caller report or not, value: true or false
";
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

            return view('docker.config', ['yamlContent' => $yamlContent, "page"=>"System Configuration"]);

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
                            if (!str_contains($chunk, '<!DOCTYPE html>') && !str_contains($chunk, '<script>')) {
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
            }

            return response()->json(['error' => 'Failed to execute command.'], 400);

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
}
