<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


//require_once $_SERVER['DOCUMENT_ROOT'] . '/webservices/conexionBD.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/paths.php';

require_once __DIR__ . '/vendor/autoload.php';

use IMSExport\Core\Router\Teeny;
use IMSExport\Application\XMLGenerator\Generator;

$app = new Teeny;

$app->action('get', '/xml', function () {
    $xml = new Generator();
    $xml->createElement('manifest', [
        'identifier' => 'man00001',
        'xmlns' => 'http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1',
        'xmlns:lom' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/resource",
        'xmlns:lomimscc' => "http://ltsc.ieee.org/xsd/imsccv1p1/LOM/manifest",
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance"
    ], null, function (Generator $generator) {
        $generator->createElement('metadata', null, null,
            static function (Generator $generator) {
                $generator
                    ->createElement('schema', null, 'IMS Common Cartridge')
                    ->createElement('schemaversion', null, '1.0.0', null);
            })
            ->finish();
    });
});

$app->action('get', 'xml2', function(){

    $obj = new Generator();

    $obj->createElement('root', ['message' => 'hola mundo'], null, function (Generator $generator) {
       $generator
           ->createElement('children1', null, 'Hola mundo 2')
           ->createElement('children2', null, null, function (Generator $generator) {
              $generator->createElement('children3', ['attr' => 'hola'], 'texto');
           });
    })
    ->finish();

});

/*
 *
 * <root message="hola mundo">
 *  <children1>Hola mundo 2</children1>
 *  <children2>
 *      <children3 attr="hola">texto</children3>
 *  </children2>
 * </root>
 *
 *
 * */

return $app->exec();
