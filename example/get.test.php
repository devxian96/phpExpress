<?php
require '../lib/phpExpress.php';

$app = new phpExpress();

// Request : http://localhost:3000/test/get.test.php/3/get
// Result : 3
$app->get('/{id}/get', function ($req, $res) {
    try {
        $res->send($req["id"]);
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test
// Result : phpExpress
$app->get('/test', function ($req, $res) {
    try {
        $res->send("phpExpress");
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test2
// Result : {"msg":"phpExpress"}
$app->get('/test2', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// 404 return
$app->listen();
