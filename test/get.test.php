<?php
require '../lib/phpExpress.php';

$app = new phpExpress();

// Request : http://localhost:3000/test/get.test.php/3/get
// Result : 3
$app->get('/{id}/get', static function ($req) {
    try {
        return $req["id"];
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test
// Result : phpExpress
$app->get('/test', static function ($req) {
    try {
        return "phpExpress";
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test2
// Result : {"msg":"phpExpress"}
$app->get('/test2', static function ($req) {
    try {
        return (object) ["msg" => "phpExpress"];
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// 404 return
$app->listen();
