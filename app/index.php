<?php

require_once 'vendor/autoload.php';

use Fomento\Gateway;
use Fomento\Signer;

echo "Creating the client".PHP_EOL;

$gateway = new Gateway(
    new SoapClient("https://sede.mitma.gob.es/MFOM.Services.VTC.Server/VTCPort?wsdl"),
    new Signer()
);

echo "Functions available: ".print_r($gateway->getFunctions(),1).PHP_EOL;

$xml = new SimpleXMLElement("<root/>");
$header = $xml->addChild("header");
$version = $header->addChild("version");
$versionSender = $header->addChild("versionsender");
$fecha = $header->addChild("fecha");

$gateway->call('ConsultaDeServicio', $xml->asXML());
echo $xml->asXML();