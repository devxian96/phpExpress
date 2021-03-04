<?php
require '../lib/phpExpress.php';

$app = new phpExpress();

// Request : http://localhost:3000/test/get.test.php/3/th/good
// Result : 3th
$app->get('/{id}/{text}/good', static function ($req) {
    try {
        return $req["id"] . $req["text"];
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test
// Result : phpExpress
$app->post('/test', static function ($req) {
    try {
        return "phpExpress";
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php/test2
// Result : {"msg":"phpExpress"}
$app->post('/test2', static function ($req) {
    try {
        return (object) ["msg" => "phpExpress"];
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// 404 return
$app->listen();
