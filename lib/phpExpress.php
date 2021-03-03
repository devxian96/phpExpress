<?php
/*
 * phpExpress Framework v0.0.1 (https://github.com/devxian96/phpExpress)
 * Copyright 2021 DevXian
 * Licensed under MIT (https://github.com/devxian96/phpExpress/blob/main/LICENSE)
 */
class phpExpress
{
    private $req;
    public function __construct()
    {
        // Header Setting
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS');
        header('X-Content-Type-Options: nosniff'); // (https://webhint.io/docs/user-guide/hints/hint-x-content-type-options/?source=devtools)
        ob_start('ob_gzhandler'); //gzip
        header_remove('X-Powered-By'); // server type remove
        header_remove('Host'); // (https://webhint.io/docs/user-guide/hints/hint-no-disallowed-headers/?source=devtools)
        header("Cache-Control: max-age=3600, private"); // (https://webhint.io/docs/user-guide/hints/hint-http-cache/?source=devtools)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://";
        } else {
            $url = "http://";
        }

        $url .= $_SERVER['HTTP_HOST'];

        header('Access-Control-Allow-Origin: ' . $url); // cors

        //Get Json data
        $this->req = json_decode(file_get_contents('php://input'), true);
    }

    public static function send($result)
    {
        if (is_object($result)) { // JSON
            header('content-type: application/json; charset=utf-8');
            $len = strlen(json_encode($result));

            echo json_encode($result);
        } else { // Plain Text
            header('Content-Type: text/plain; charset=utf-8');
            $len = strlen($result);

            echo $result;
        }
        header('content-length: ' . $len);
        exit;
    }

    public function listen()
    {
        http_response_code(404);
        exit;
    }

    public function get($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        http_response_code(200);
        $this->send($function($this->req));
    }

    public function post($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        http_response_code(201);
        $this->send($function($this->req));
    }

    public function put($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        $this->send($function($this->req));
    }

    public function patch($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        $this->send($function($this->req));
    }

    public function delete($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        $this->send($function($this->req));
    }

    public function options($parm, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
            return;
        } else if (strcmp($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'])) {
            return;
        }

        $this->send($function($this->req));
    }
}
