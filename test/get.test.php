<?php
require '../lib/phpExpress.php';

$app = new Express();

// Request : http://localhost:3000/test/get.test.php?/test
// Result : phpExpress
$app->get('/test', static function ($req, $sql) {
    try {
        return "phpExpress";
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});

// Request : http://localhost:3000/test/get.test.php?/test2
// Result : {"msg":"phpExpress"}
$app->get('/test2', static function ($req, $sql) {
    try {
        return (object) ["msg" => "phpExpress"];
    } catch (Exception $e) {
        http_response_code(500);
        return $e;
    }
});
