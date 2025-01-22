<?php

namespace App\Http\Controllers\Docker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

//            $servicesJson = '[
//                            {
//                                "Id": "df32334edd4bdfce2cb7f0bda9433c17fbaf027e93144b4732040e339c03cd52",
//                                "Names": [
//                                  "/n3iwue"
//                                ],
//                            "Image": "free5gc/n3iwue:latest",
//                            "ImageID": "sha256:ef866e61a1a136fd89aef79f7707d05bab3e5b6507d691aabf44a7c7687a124f",
//
//                            "Created": 1734197684,
//                            "Ports": [],
//                            "Labels": {
//                              "com.docker.compose.config-hash": "578ab83f601bf5aa1fe5d104cbf5afb9c1b7a5353615e0ed595253d9f81da494",
//                              "com.docker.compose.container-number": "1",
//                              "com.docker.compose.depends_on": "free5gc-n3iwf:service_started",
//                              "com.docker.compose.image": "sha256:ef866e61a1a136fd89aef79f7707d05bab3e5b6507d691aabf44a7c7687a124f",
//                              "com.docker.compose.oneoff": "False",
//                              "com.docker.compose.project": "free5gc-compose",
//                              "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//                              "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//                              "com.docker.compose.service": "n3iwue",
//                              "com.docker.compose.version": "2.6.1"
//                            },
//                            "State": "running",
//                            "Status": "Up 18 seconds",
//                            "HostConfig": {
//                              "NetworkMode": "free5gc-compose_privnet"
//                            },
//                            "NetworkSettings": {
//                              "Networks": {
//                                "free5gc-compose_privnet": {
//                                  "IPAMConfig": {
//                                    "IPv4Address": "10.100.200.203"
//                                  },
//                                  "Links": null,
//                                  "Aliases": null,
//                                  "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//                                  "EndpointID": "0579dd00390c719c66238cf99756e0a6d7450c86c835b7a91be82c692e12e247",
//                                  "Gateway": "10.100.200.1",
//                                  "IPAddress": "10.100.200.203",
//                                  "IPPrefixLen": 24,
//                                  "IPv6Gateway": "",
//                                  "GlobalIPv6Address": "",
//                                  "GlobalIPv6PrefixLen": 0,
//                                  "MacAddress": "02:42:0a:64:c8:cb",
//                                  "DriverOpts": null
//                                }
//                              }
//                            },
//                            "Mounts": [
//                              {
//                                "Type": "bind",
//                                "Source": "/home/imran/free5gc/free5gc-compose/config/n3uecfg.yaml",
//                                "Destination": "/n3iwue/config/n3ue.yaml",
//                                "Mode": "rw",
//                                "RW": true,
//                                "Propagation": "rprivate"
//                              },
//                              {
//                                "Type": "volume",
//                                "Name": "493cdea17b7d606d85ca2457156cff2019dbfa829f1e3eb084d6eeeeb94437ce",
//                                "Source": "/var/lib/docker/volumes/493cdea17b7d606d85ca2457156cff2019dbfa829f1e3eb084d6eeeeb94437ce/_data",
//                                "Destination": "/n3iwue/config",
//                                "Driver": "local",
//                                "Mode": "z",
//                                "RW": true,
//                                "Propagation": ""
//                              }
//                            ]
//                          },
//  {
//    "Id": "1715c95a309f85470f9bf76a6a16333ab2a3285683ae9d91e29092432f17f3d3",
//    "Names": [
//      "/ueransim"
//    ],
//    "Image": "free5gc/ueransim:latest",
//    "ImageID": "sha256:ae939f4ef46a3a5fffa0cf81be8896b5bfceef32535d843259234614b4647e5e",
//    "Command": "./nr-gnb -c ./config/gnbcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [],
//    "Labels": {
//      "com.docker.compose.config-hash": "440c47b53cf0d1da8b42e14625c149d186b8d8e6cf81a923b653db11bc7af567",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-amf:service_started,free5gc-upf:service_started",
//      "com.docker.compose.image": "sha256:ae939f4ef46a3a5fffa0cf81be8896b5bfceef32535d843259234614b4647e5e",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "ueransim",
//      "com.docker.compose.version": "2.6.1"
//    },
//    "State": "running",
//    "Status": "Up 20 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "f279c1e3de34daa5600b208a7d1a2d683db06f4a2df18ae1e3049898beff0a8b",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.12",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:0c",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "volume",
//        "Name": "49fe7a52ded0b2da8144eb3b7d5946fe437de65c140c93af3970f7353cdb6c97",
//        "Source": "/var/lib/docker/volumes/49fe7a52ded0b2da8144eb3b7d5946fe437de65c140c93af3970f7353cdb6c97/_data",
//        "Destination": "/ueransim/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/gnbcfg.yaml",
//        "Destination": "/ueransim/config/gnbcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/uecfg.yaml",
//        "Destination": "/ueransim/config/uecfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "b40f0751496a38131a94edee06488a03978fae16d67a46504e04fa70fbae4a6f",
//    "Names": [
//      "/n3iwf"
//    ],
//    "Image": "free5gc/n3iwf:v3.4.3",
//    "ImageID": "sha256:920b494d7d3d990936af0a8b6d38413aa65f0bfc165cc58ec2e2b049720550cb",
//    "Command": "./n3iwf -c ./config/n3iwfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [],
//    "Labels": {
//      "com.docker.compose.config-hash": "fa483811f1ebf523f254a5996028d4c9d531086c05fe7993431f9767e2e7eca0",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-amf:service_started,free5gc-smf:service_started,free5gc-upf:service_started",
//      "com.docker.compose.image": "sha256:920b494d7d3d990936af0a8b6d38413aa65f0bfc165cc58ec2e2b049720550cb",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-n3iwf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 20 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//            "IPv4Address": "10.100.200.15"
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "6715a833b4af83f7035026012b6d86c2ba449df7a941a8fa55fd7d85c2c5fd33",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.15",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:0f",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "volume",
//        "Name": "dfae631973fedb514c46862f7045916969773697bdd5ff971ff565e44ba25e66",
//        "Source": "/var/lib/docker/volumes/dfae631973fedb514c46862f7045916969773697bdd5ff971ff565e44ba25e66/_data",
//        "Destination": "/free5gc/cert",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "volume",
//        "Name": "54409e91e5440dc74cbf423549f5c9d9e5fecc286b98b54749d30bacd23046da",
//        "Source": "/var/lib/docker/volumes/54409e91e5440dc74cbf423549f5c9d9e5fecc286b98b54749d30bacd23046da/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/n3iwfcfg.yaml",
//        "Destination": "/free5gc/config/n3iwfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/n3iwf-ipsec.sh",
//        "Destination": "/free5gc/n3iwf-ipsec.sh",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "1fcd3061bdc091a77d8f91510182ae88b5b2feeb21e2f7c7150e31546b57a86c",
//    "Names": [
//      "/chf"
//    ],
//    "Image": "free5gc/chf:v3.4.3",
//    "ImageID": "sha256:ab066dbc64f18e9d6aa9c529c3b12e3144d220d2cbeb79f8798509c40febba5e",
//    "Command": "./chf -c ./config/chfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      },
//      {
//        "PrivatePort": 2122,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "f7d90f14a8a7039085bdbd4622076723a39996c03dcac66bee8e3425d4981764",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-webui:service_started,db:service_started,free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:ab066dbc64f18e9d6aa9c529c3b12e3144d220d2cbeb79f8798509c40febba5e",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-chf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 19 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "53a3b61dca93a60bf91b4daf92725404463fa60f56d9d90692840fa24c465c9d",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.13",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:0d",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/chfcfg.yaml",
//        "Destination": "/free5gc/config/chfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "7dfd33e238000696973e19a7e89de53c6bc6d137a4c8b13e5b28b180ceb889e3",
//        "Source": "/var/lib/docker/volumes/7dfd33e238000696973e19a7e89de53c6bc6d137a4c8b13e5b28b180ceb889e3/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      }
//    ]
//  },
//  {
//    "Id": "d65d5b1c962fda345b9400a91dc09ae644edc4a838e9a44e549b2ea67d82d08d",
//    "Names": [
//      "/nssf"
//    ],
//    "Image": "free5gc/nssf:v3.4.3",
//    "ImageID": "sha256:bd623b641c6dba9d2e1ca343f597825c6fd35c43cf57e83511b6b875fd261d08",
//    "Command": "./nssf -c ./config/nssfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "3e12989614f1895e4630caa3b86b8e4cbdf0e92094804b2b085978c2e258bbaf",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:bd623b641c6dba9d2e1ca343f597825c6fd35c43cf57e83511b6b875fd261d08",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-nssf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "0e4c338c566e42d04bc9f4aab40eb24d0af00fe6110771362bfcb064869bef01",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.9",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:09",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "534a747785834078c96f09f30d769c7adaecb4e2d02978c1516a7110216fec52",
//        "Source": "/var/lib/docker/volumes/534a747785834078c96f09f30d769c7adaecb4e2d02978c1516a7110216fec52/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/nssfcfg.yaml",
//        "Destination": "/free5gc/config/nssfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "f599c11a8b54080715304b062107caccfe0c6bb67004bc48b541a08b04751c26",
//    "Names": [
//      "/amf"
//    ],
//    "Image": "free5gc/amf:v3.4.3",
//    "ImageID": "sha256:acdd5b6629a2e44552baee596b856ddf41545ad58fc2618d8ddbb037abb933af",
//    "Command": "./amf -c ./config/amfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 8000,
//        "PublicPort": 8002,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 8000,
//        "PublicPort": 8002,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "08fa2ba4e5e75481a3bc6c7af09b1d17f80c9da016f946c3349125e571b17941",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:acdd5b6629a2e44552baee596b856ddf41545ad58fc2618d8ddbb037abb933af",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-amf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//            "IPv4Address": "10.100.200.16"
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "8c9bb66ebabc8979212b60526954f0b323f3642921c64ba2ec8d38e6bb378658",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.16",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:10",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "3cb389dfeaaf915476de68b9bdd6fec17bb1af16c06683dc233a16cf887ee052",
//        "Source": "/var/lib/docker/volumes/3cb389dfeaaf915476de68b9bdd6fec17bb1af16c06683dc233a16cf887ee052/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/amfcfg.yaml",
//        "Destination": "/free5gc/config/amfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "b0491a782f10441d647b60d0e8c09d2cdf14c5c4f2fc3b73b90a7c8cb2949fc7",
//    "Names": [
//      "/pcf"
//    ],
//    "Image": "free5gc/pcf:v3.4.3",
//    "ImageID": "sha256:0b6b2ae582a77b0347adb984900ea7f9eeb438bfc024c63df3c4054dd908ffeb",
//    "Command": "./pcf -c ./config/pcfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "66fb2d795ba76775ce53e9b0295a6835b85b59bfcc4690bd7d3a19f63188e191",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:0b6b2ae582a77b0347adb984900ea7f9eeb438bfc024c63df3c4054dd908ffeb",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-pcf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "41ae93914d8d80c74c3da189a24ea7366a6fe56003663d4dcc662799b00b1fb6",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.8",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:08",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "d185e1e783166dbe09ff4bfe894fd7ae7d12ba70313dd423f50f57b896dc2621",
//        "Source": "/var/lib/docker/volumes/d185e1e783166dbe09ff4bfe894fd7ae7d12ba70313dd423f50f57b896dc2621/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/pcfcfg.yaml",
//        "Destination": "/free5gc/config/pcfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "bdd369c79458f287d72b4c475bcaebc3676a69caf0e9d598afa1f56463d4c128",
//    "Names": [
//      "/nef"
//    ],
//    "Image": "free5gc/nef:latest",
//    "ImageID": "sha256:24f549f04655f2291167d3e86b1670c27a1664d373f2f6ba5c0b57bbd5eec866",
//    "Command": "./nef -c ./config/nefcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "de7d9565f44da333fd7e0a0dad11153df489d61b655aa7590b98239f2aa15aa4",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started,db:service_started",
//      "com.docker.compose.image": "sha256:24f549f04655f2291167d3e86b1670c27a1664d373f2f6ba5c0b57bbd5eec866",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-nef",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "b326cea6a13f079ded38fc5444284f068a3444693fedfee4449b5d434b8fb320",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.7",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:07",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "c69944d51d9dfc945c5b1bbaa4dcd160d5e2d1b825fd28ad6fb18d0e0aae76f7",
//        "Source": "/var/lib/docker/volumes/c69944d51d9dfc945c5b1bbaa4dcd160d5e2d1b825fd28ad6fb18d0e0aae76f7/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/nefcfg.yaml",
//        "Destination": "/free5gc/config/nefcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "00cf48808dd8eec4ca7b030ed0ceccb3a96faf56cdee3b1b73faa7d16c94c785",
//    "Names": [
//      "/ausf"
//    ],
//    "Image": "free5gc/ausf:v3.4.3",
//    "ImageID": "sha256:65f253ffab0f81be5c1984c532c8344b650fa6b4d7d4e76ba674faa0f919ca7f",
//    "Command": "./ausf -c ./config/ausfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "cfda0d070e874fbc55176ec5f79934e3f948e46c870f79abf238f99bc2b60bfd",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:65f253ffab0f81be5c1984c532c8344b650fa6b4d7d4e76ba674faa0f919ca7f",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-ausf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "b1bb88fab7cca07cf6a2664b7f5c328d8d4ec5315ea7177c55bd9ce5f4d506fb",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.2",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:02",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "c7a8d5a30c267ba050a0f9e2191523342e85fabe8cd5d5c709d0ea97eab26049",
//        "Source": "/var/lib/docker/volumes/c7a8d5a30c267ba050a0f9e2191523342e85fabe8cd5d5c709d0ea97eab26049/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/ausfcfg.yaml",
//        "Destination": "/free5gc/config/ausfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "c8fedcc4503b270cbda603b52058510399796b8721cf4e3c60b2e7e36e28f44f",
//    "Names": [
//      "/udr"
//    ],
//    "Image": "free5gc/udr:v3.4.3",
//    "ImageID": "sha256:b8d7cd138448679d9fbe80ff26026d324f8925f158dcd4db3a27b0534b0af655",
//    "Command": "./udr -c ./config/udrcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "4528db2b1099bb7715798068803c5b5795be1212ce6b3689d49d8cb3adda4100",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "db:service_started,free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:b8d7cd138448679d9fbe80ff26026d324f8925f158dcd4db3a27b0534b0af655",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-udr",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 20 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "34dfd5d39fb9800220ee69bd736286243214edf3f6be3de8d3f9cac4046e6c99",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.11",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:0b",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "fcf2e7f5c0118fbf5c5c8f8dcfb9af79b237efa1208b1cd7875e33bd42f5bb62",
//        "Source": "/var/lib/docker/volumes/fcf2e7f5c0118fbf5c5c8f8dcfb9af79b237efa1208b1cd7875e33bd42f5bb62/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/udrcfg.yaml",
//        "Destination": "/free5gc/config/udrcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "6fcf642f95a99ffac81033d0bf52df88a534627484a1bef85f4e32324eeaf3f0",
//    "Names": [
//      "/udm"
//    ],
//    "Image": "free5gc/udm:v3.4.3",
//    "ImageID": "sha256:e53413d020ef4b657e1d56341a7ea6a07820b7962abad259c91da44a622ded2c",
//    "Command": "./udm -c ./config/udmcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "c279d10174dedfd33e7cc0778e234b5fc67582ec08ee9a0e8f6cbe0d5cc48faf",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started,db:service_started",
//      "com.docker.compose.image": "sha256:e53413d020ef4b657e1d56341a7ea6a07820b7962abad259c91da44a622ded2c",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-udm",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "9f6d08ef2da48f33a73dabb546f46e5ec9156339c639641997734b72d8906cd6",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.5",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:05",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/udmcfg.yaml",
//        "Destination": "/free5gc/config/udmcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "b688daedee2028692a541385af3b8f290755e4174f98e0d12d37cac0659bcc31",
//        "Source": "/var/lib/docker/volumes/b688daedee2028692a541385af3b8f290755e4174f98e0d12d37cac0659bcc31/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      }
//    ]
//  },
//  {
//    "Id": "766e52e446b528f9ec1feeadca800de30769fdd9bbb7b88e16610a781f944f78",
//    "Names": [
//      "/smf"
//    ],
//    "Image": "free5gc/smf:v3.4.3",
//    "ImageID": "sha256:5520b14070a0b08765b9dc365795d313f787dc79484d56a0cde6465eec1ce007",
//    "Command": "./smf -c ./config/smfcfg.yaml -u ./config/uerouting.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "PrivatePort": 8000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "3bedc55b9024c8d6cb6db1bf7e547cfc7871e0c5d5dc838e9950c382527a5d6a",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-upf:service_started,free5gc-nrf:service_started",
//      "com.docker.compose.image": "sha256:5520b14070a0b08765b9dc365795d313f787dc79484d56a0cde6465eec1ce007",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-smf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 27 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "eb838de50b55f31d95390326e8cf14eeeeb7fcc09ad773f7cd12430cc891b0aa",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.6",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:06",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "0d9a821bfa923b1645a3c7ba76396c52e945d8eec062386aa4f5f1ba6dfbbfd7",
//        "Source": "/var/lib/docker/volumes/0d9a821bfa923b1645a3c7ba76396c52e945d8eec062386aa4f5f1ba6dfbbfd7/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/smfcfg.yaml",
//        "Destination": "/free5gc/config/smfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/uerouting.yaml",
//        "Destination": "/free5gc/config/uerouting.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "a5756c84d1159df238e1c464e49d069004883aeaaf12342eeb2fc4828ebade49",
//    "Names": [
//      "/webui"
//    ],
//    "Image": "free5gc/webui:v3.4.3",
//    "ImageID": "sha256:30315d1e88bf6f3355b7f67801de2e6b83f78bd1da7b660fc9c6d33ca9476fbb",
//    "Command": "./webui -c ./config/webuicfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 2121,
//        "PublicPort": 2121,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 2121,
//        "PublicPort": 2121,
//        "Type": "tcp"
//      },
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 2122,
//        "PublicPort": 2122,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 2122,
//        "PublicPort": 2122,
//        "Type": "tcp"
//      },
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 5000,
//        "PublicPort": 5000,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 5000,
//        "PublicPort": 5000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "ad4d9d21195b26a91b30955f8171a318ee9b76b8b122b222e08e45295a0089a3",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "free5gc-nrf:service_started,db:service_started",
//      "com.docker.compose.image": "sha256:30315d1e88bf6f3355b7f67801de2e6b83f78bd1da7b660fc9c6d33ca9476fbb",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-webui",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 22 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "d821e7c34691466b2acd768ae86d8ae4e3a5bdd0f4c693ea9d60df31da31f8fd",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.10",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:0a",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "volume",
//        "Name": "ae3295e6068e902436f951d4c19ee27913bdd478480d182b37c03b50d5f42e9b",
//        "Source": "/var/lib/docker/volumes/ae3295e6068e902436f951d4c19ee27913bdd478480d182b37c03b50d5f42e9b/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/webuicfg.yaml",
//        "Destination": "/free5gc/config/webuicfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "61bb449b8598cf2a93b23abfaccd861ff26e144fb39496ebd306159348c7a4ca",
//    "Names": [
//      "/nrf"
//    ],
//    "Image": "free5gc/nrf:v3.4.3",
//    "ImageID": "sha256:9e6fe5d564fc0ed03ac9ac68459215ebed79bf2c1d481d0b5dbc3627ce8ca3b6",
//    "Command": "./nrf -c ./config/nrfcfg.yaml",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 8000,
//        "PublicPort": 8001,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 8000,
//        "PublicPort": 8001,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "80d122fe70001d22ed3d8655246feefa6840d3ac1a749da13dbeb9cbe5412f0d",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "db:service_started",
//      "com.docker.compose.image": "sha256:9e6fe5d564fc0ed03ac9ac68459215ebed79bf2c1d481d0b5dbc3627ce8ca3b6",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "free5gc-nrf",
//      "com.docker.compose.version": "2.6.1",
//      "description": "Free5GC open source 5G Core Network",
//      "version": "Stage 3"
//    },
//    "State": "running",
//    "Status": "Up 39 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "e3df4c8ea012e56c48184890f848d0ec23bc9d4bf5b91825dcd56b137d23b0a9",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.4",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:04",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/cert",
//        "Destination": "/free5gc/cert",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      },
//      {
//        "Type": "volume",
//        "Name": "be26b6923a324872a43c4346fd6cde9a80f8fa42e672813f35788ff4519c17b7",
//        "Source": "/var/lib/docker/volumes/be26b6923a324872a43c4346fd6cde9a80f8fa42e672813f35788ff4519c17b7/_data",
//        "Destination": "/free5gc/config",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "bind",
//        "Source": "/home/imran/free5gc/free5gc-compose/config/nrfcfg.yaml",
//        "Destination": "/free5gc/config/nrfcfg.yaml",
//        "Mode": "rw",
//        "RW": true,
//        "Propagation": "rprivate"
//      }
//    ]
//  },
//  {
//    "Id": "ff1612275296c6f3fc927bd5b2454a1f5c49ae12319f1b1c33be05369bed6794",
//    "Names": [
//      "/mongodb"
//    ],
//    "Image": "mongo:3.6.8",
//    "ImageID": "sha256:336f61db5f267c3c229c992fb639ca6a8061b321fbc88e87b06b981a57ed3d87",
//    "Command": "docker-entrypoint.sh mongod --port 27017",
//    "Created": 1734197684,
//    "Ports": [
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 27017,
//        "PublicPort": 27017,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 27017,
//        "PublicPort": 27017,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "com.docker.compose.config-hash": "15be31ac333e6a089f752577af21f20011aaaf359e6a397046d1f609e0b12f0f",
//      "com.docker.compose.container-number": "1",
//      "com.docker.compose.depends_on": "",
//      "com.docker.compose.image": "sha256:336f61db5f267c3c229c992fb639ca6a8061b321fbc88e87b06b981a57ed3d87",
//      "com.docker.compose.oneoff": "False",
//      "com.docker.compose.project": "free5gc-compose",
//      "com.docker.compose.project.config_files": "/home/imran/free5gc/free5gc-compose/docker-compose.yaml",
//      "com.docker.compose.project.working_dir": "/home/imran/free5gc/free5gc-compose",
//      "com.docker.compose.service": "db",
//      "com.docker.compose.version": "2.6.1"
//    },
//    "State": "running",
//    "Status": "Up 41 seconds",
//    "HostConfig": {
//      "NetworkMode": "free5gc-compose_privnet"
//    },
//    "NetworkSettings": {
//      "Networks": {
//        "free5gc-compose_privnet": {
//          "IPAMConfig": {
//
//          },
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "c267c1fd1a3a57158583063f71790483454bb30ed5fe267d4029e9a7a09e2d16",
//          "EndpointID": "46f912d3a0b2c37cb8c5361f422c5f4744a09952edb45bf5534b12fd861ee18c",
//          "Gateway": "10.100.200.1",
//          "IPAddress": "10.100.200.3",
//          "IPPrefixLen": 24,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:0a:64:c8:03",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//        "Type": "volume",
//        "Name": "c03cb43d288395e116ddac9cf34006dd7261679fb865b39796229030c0cb838d",
//        "Source": "/var/lib/docker/volumes/c03cb43d288395e116ddac9cf34006dd7261679fb865b39796229030c0cb838d/_data",
//        "Destination": "/data/configdb",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      },
//      {
//        "Type": "volume",
//        "Name": "free5gc-compose_dbdata",
//        "Source": "/var/lib/docker/volumes/free5gc-compose_dbdata/_data",
//        "Destination": "/data/db",
//        "Driver": "local",
//        "Mode": "z",
//        "RW": true,
//        "Propagation": ""
//      }
//    ]
//  },
//  {
//    "Id": "c4780413db6fea877ad6f9421c11a66ffdac893591434a045953e972cf8d2648",
//    "Names": [
//      "/openspeedtest"
//    ],
//    "Image": "openspeedtest/latest",
//    "ImageID": "sha256:7d7dd083272cc1d6501cc166e7bcdff485a8a7220d16ccd6798a1928ac787319",
//    "Command": "/docker-entrypoint.sh /entrypoint.sh",
//    "Created": 1733575610,
//    "Ports": [
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 3001,
//        "PublicPort": 3001,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 3001,
//        "PublicPort": 3001,
//        "Type": "tcp"
//      },
//      {
//        "PrivatePort": 8080,
//        "Type": "tcp"
//      },
//      {
//        "IP": "0.0.0.0",
//        "PrivatePort": 3000,
//        "PublicPort": 3000,
//        "Type": "tcp"
//      },
//      {
//        "IP": "::",
//        "PrivatePort": 3000,
//        "PublicPort": 3000,
//        "Type": "tcp"
//      }
//    ],
//    "Labels": {
//      "maintainer": "OpenSpeedTest.com \u003Csupport@OpenSpeedTest.com\u003E",
//      "org.opencontainers.image.created": "2024-01-22T00:57:27.762Z",
//      "org.opencontainers.image.description": "Unprivileged NGINX Dockerfiles",
//      "org.opencontainers.image.licenses": "Apache-2.0",
//      "org.opencontainers.image.revision": "87e29d2ba0bcec34c36f85611f03aebcda591dbb",
//      "org.opencontainers.image.source": "https://github.com/nginxinc/docker-nginx-unprivileged",
//      "org.opencontainers.image.title": "docker-nginx-unprivileged",
//      "org.opencontainers.image.url": "https://github.com/nginxinc/docker-nginx-unprivileged",
//      "org.opencontainers.image.version": "1.24.0-alpine"
//    },
//            "State": "running",
//    "Status": "Up 8 minutes",
//    "HostConfig": {
//                "NetworkMode": "default"
//    },
//    "NetworkSettings": {
//                "Networks": {
//                    "bridge": {
//                        "IPAMConfig": null,
//          "Links": null,
//          "Aliases": null,
//          "NetworkID": "516d0dddf5bb9f8e168d07b6e6fc114077260338c9ffbd6d10418a3280e08aea",
//          "EndpointID": "87f2f1633849427d6e823193bd58692ee92093d4670b757bbe745c9778b4f697",
//          "Gateway": "172.17.0.1",
//          "IPAddress": "172.17.0.2",
//          "IPPrefixLen": 16,
//          "IPv6Gateway": "",
//          "GlobalIPv6Address": "",
//          "GlobalIPv6PrefixLen": 0,
//          "MacAddress": "02:42:ac:11:00:02",
//          "DriverOpts": null
//        }
//      }
//    },
//    "Mounts": [
//      {
//          "Type": "volume",
//        "Name": "1e430276b161f1cb1296ae824953b4aea46e579fee432b98f92fc2ccbec9acca",
//        "Source": "",
//        "Destination": "/var/log/letsencrypt",
//        "Driver": "local",
//        "Mode": "",
//        "RW": true,
//        "Propagation": ""
//      }
//    ]
//  }
//]';


            $services = json_decode($servicesJson, true);
            // Transform data for the frontend
            $processedServices = array_map(function ($service) {
                return [
                    'id' => $service['Id'] ?? 'N/A',
                    'name' => $service['Names'][0] ?? 'N/A',
                    'status' => $service['Status'] ?? 'Unknown',
                ];
            }, $services);


            return view('docker.services', ["services" => $processedServices]);
            }

            return response()->json(['error' => 'Failed to fetch services'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
