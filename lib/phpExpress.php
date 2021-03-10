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
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://";
        } else {
            $url = "http://";
        }

        $url .= $_SERVER['HTTP_HOST'];

        header('Access-Control-Allow-Origin: ' . $url); // cors

        //Get Json data
        $this->req = json_decode(file_get_contents('php://input'), true);
        //GET data
        $this->req = array_merge((array) $_GET, (array) $this->req);
        //POST data
        $this->req = array_merge((array) $_POST, (array) $this->req);
    }

    public static function send($result, bool $cache = false)
    {
        // cache option control
        if ($cache) {
            header("Cache-Control: max-age=3600"); // (https://webhint.io/docs/user-guide/hints/hint-http-cache/?source=devtools)
        } else {
            header("Cache-Control: no-cache");
        }

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

    /*
    Usage: class->listen();
    explain: Return 404 if no HTTP method was called
     */
    public function listen()
    {
        http_response_code(404);
        exit;
    }

    /*
    Usage: $this->->removePhpUrl(URL);
    explain: Remove string before .php
     */
    private function removePhpUrl(string $url): string
    {
        $result = $url; // org url
        if (strpos($url, ".php")) {
            $result = substr($url, strpos($url, ".php") + 4);
        }
        if (strpos($result, "?")) {
            $result = substr($result, 0, strpos($result, "?"));
        }
        return $result;
    }

    /*
    Usage: $this->convertParm(parm);
    explain: /{key} to /key and Allocate req varible
     */
    private function convertParm(string $parm): string
    {
        $replaceParm = $parm;
        $count = preg_match_all('/{/', $replaceParm);
        $query = $this->removePhpUrl($_SERVER['REQUEST_URI']);
        for ($dataEnd = 0, $end = 0, $i = 0; $i < $count; ++$i) {
            // parm spread
            $start = strpos($parm, "{", $end) + 1;
            $end = strpos($parm, "}", $start);

            // query spread
            $dataStart = strpos($query, "/", $dataEnd) + 1;
            if ($dataStart > 0) {
                break;
            }

            $dataEnd = strpos($query, "/", $dataStart);

            $key = substr($parm, $start, $end - $start);
            $value = substr($query, $dataStart, $dataEnd - $dataStart);
            $this->req[$key] = $value;
            $replaceParm = str_replace("{" . $key . "}", $value, $replaceParm);
        }
        return $replaceParm;
    }

    public function get(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        http_response_code(200);
        $function($this->req, $this);
    }

    public function post(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        http_response_code(201);
        $function($this->req, $this);
    }

    public function put(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        $function($this->req, $this);
    }

    public function patch(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        $function($this->req, $this);
    }

    public function delete(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        $function($this->req, $this);
    }

    public function options(string $parm, $function)
    {
        $parm = $this->convertParm($parm);
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
            return;
        } else if (strcmp($this->removePhpUrl($_SERVER['REQUEST_URI']), $parm)) {
            return;
        }

        $function($this->req, $this);
    }
}
