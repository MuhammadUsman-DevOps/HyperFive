<?php

namespace App\Services;

use phpseclib3\Net\SSH2;

class SSHService
{
    protected $ssh;
    protected $host;

    public function __construct()
    {
//        $this->host = config('ssh.host'); // Retrieve the host from the config file
        $this->host = '192.168.11.129';
        $this->ssh = new SSH2($this->host);
        if (!$this->ssh->login('imran', 'imran')) {
            throw new \Exception('SSH login failed');
        }
    }

    public function getFileContent($filePath)
    {
        $content = $this->ssh->exec("cat $filePath");
        if ($content === false) {
            throw new \Exception("Failed to read file: $filePath");
        }
        return $content;
    }
}
