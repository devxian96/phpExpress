<?php
require '../lib/phpExpress.php';

$app = new phpExpress();

// Request : http://localhost:3000/example/get.test.php/3/urlarg
// Result : 3
$app->get('/{id}/urlarg', function ($req, $res) {
    try {
        $res->send($req["id"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/get.test.php/text
// Result : phpExpress
$app->get('/text', function ($req, $res) {
    try {
        $res->send("phpExpress");
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/get.test.php/json
// Result : {"msg":"phpExpress"}
$app->get('/json', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/get.test.php/argument?a=1
// body : json {"b":2}
// Result : 3
$app->get('/argument', function ($req, $res) {
    try {
        $result = $req["a"] + $req["b"];
        $res->send($result);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// 404 return
$app->listen();
