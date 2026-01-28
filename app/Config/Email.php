<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail;
    public $fromName;
    public $recipients;
    public $userAgent = 'CodeIgniter';
    public $protocol = 'smtp';
    public $mailPath = '/usr/sbin/sendmail';
    public $SMTPHost;
    public $SMTPUser;
    public $SMTPPass;
    public $SMTPPort = 25;
    public $SMTPTimeout = 5;
    public $SMTPKeepAlive = false;
    public $SMTPCrypto = 'tls';
    public $wordWrap = true;
    public $wrapChars = 76;
    public $mailType = 'html';
    public $charset = 'UTF-8';
    public $validate = false;
    public $priority = 3;
    public $CRLF = "\r\n";
    public $newline = "\r\n";
    public $BCCBatchMode = false;
    public $BCCBatchSize = 200;
    public $DSN = false;

    public function __construct()
    {
        parent::__construct();

        $this->protocol   = env('email.protocol', 'smtp');
        $this->SMTPHost   = env('email.SMTPHost', 'smtp.gmail.com');
        $this->SMTPUser   = env('email.SMTPUser', '');
        $this->SMTPPass   = env('email.SMTPPass', '');
        $this->SMTPPort   = (int) env('email.SMTPPort', 587);
        $this->SMTPCrypto = env('email.SMTPCrypto', 'tls');
        $this->mailType   = env('email.mailType', 'html');
        $this->charset    = env('email.charset', 'utf-8');
        $this->fromEmail  = env('email.fromEmail', 'noreply@cychez.com');
        $this->fromName   = env('email.fromName', 'Cychez Store');
    }
}