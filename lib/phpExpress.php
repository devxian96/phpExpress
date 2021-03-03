<?php
// phpExpress Framework
class Express
{
    private $req;
    public function __construct()
    {
        // Header Setting
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS');
        ob_start('ob_gzhandler'); //gzip
        header_remove('X-Powered-By');
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://";
        } else {
            $url = "http://";
        }

        // Append the host(domain name, ip) to the URL.
        $url .= $_SERVER['HTTP_HOST'];

        header('Access-Control-Allow-Origin: ' . $url);

        //Get Json data
        $this->req = json_decode(file_get_contents('php://input'), true);
    }

    public static function send($result)
    {
        if (is_object($result)) { // JSON
            header('content-type: application/json; charset=utf-8');
            echo json_encode($result);
        } else { // Plain Text
            header('content-type: text/plain; charset=utf-8');
            echo $result;
        }
        exit;
    }

    public function get($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        http_response_code(200);
        $this->send($function($this->req));
    }

    public function post($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        http_response_code(201);
        $this->send($function($this->req));
    }

    public function put($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        $this->send($function($this->req));
    }

    public function patch($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        $this->send($function($this->req));
    }

    public function delete($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        $this->send($function($this->req));
    }

    public function options($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'] . '?' . $parm)) {
            return;
        }

        $this->send($function($this->req));
    }
}
