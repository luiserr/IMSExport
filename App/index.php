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

use IMSExport\Application\Entities\Group;
use IMSExport\Application\IMS\Exporter\Cartridge;
use IMSExport\Core\Router\Teeny;
use IMSExport\Application\XMLGenerator\Generator;

$app = new Teeny;

$app->action('get', '/xml', function () {
    $group = new Group(10000);
    $cartridge = new Cartridge($group);
    echo '<h1>Curso exportado con éxito!</h1>';
    $cartridge->export();
});

/*
$app->action('get', 'xml2', function () {

    $obj = new Generator();

    $obj->createElement('root', ['message' => 'hola mundo'], null, function (Generator $generator) {
       $generator
           ->createElement('children1', null, 'Hola mundo 1')
           ->createElement('children2', null, 'Hola mundo 2')
           ->createElement('children3', null, null, function (Generator $generator) {
              $generator->createElement('children4', ['attr' => 'hola'], 'texto');
           });
    })
    ->finish();

});
/*

/*
<?xml version="1.0" encoding="UTF-8"?>
<root message="hola mundo">
    <children1>Hola mundo 1</children1>
    <children2>Hola mundo 2</children2>
    <children3>
        <children4 attr="hola">texto</children4>
    </children3>
</root>
*/

/*
$app->action('get', 'discussion', function() {
    $dis = new Generator();
    $dis->createElement(
        'dt:topic', 
        ['xmlns:dt'  => 'http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1',
         'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance'], 
        null, 
        function(Generator $generator) {
        $generator
            ->createElement('dt:title', null, 'S1: Foro de consultas')
            ->createElement('dt:text', ['textype' => 'text/html'], htmlentities('TEXTO HTML', ENT_QUOTES, "UTF-8")) //Convertirá tanto las comillas dobles como las simples
            ->createElement('dt:attachments', null, null, function (Generator $generator) {
                $generator->createElement('dt:attachment', ['href' => 'archivo2.xml'], null);
            });
    })
    ->finish();
 });
 */

/*
https://www.imsglobal.org/cc/ccv1p0/imscc_profilev1p0.html#toc-32

http://localhost/IMSExport/discussion

discussion_topic00001/discussion_topic00001.xml

<?xml version="1.0" encoding="UTF-8"?>
<dt:topic xmlns:dt="http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <dt:title>S1: Foro de consultas</dt:title>
	<dt:text texttype="text/html">TEXTO HTML
    </dt:text>
    <dt:attachments>
        <dt:attachment href="archivo2.xml"/>
    </dt:attachments>
</dt:topic>

$carpeta = '/ruta/miserver/public_html/carpeta';
if (!file_exists($carpeta))
   if (!mkdir($carpeta, 0777, true))
      die('Fallo al crear las carpetas...');
*/

return $app->exec();
