<?php
require '../lib/phpExpress.php';

$app = new phpExpress();

/*
 * If you read that data from a web browser,
 */

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg":"phpExpress"}
$app->get('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg": "phpExpress"}
$app->post('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg": "phpExpress"}
$app->put('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg": "phpExpress"}
$app->patch('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg": "phpExpress"}
$app->delete('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// Request : http://localhost:3000/example/retrun.test.php/
// Result : {"msg": "phpExpress"}
$app->options('/', function ($req, $res) {
    try {
        $res->send((object) ["msg" => "phpExpress"]);
    } catch (Exception $e) {
        http_response_code(500);
        $res->send($e);
    }
});

// 404 return
$app->listen();
