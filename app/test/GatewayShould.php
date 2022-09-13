<?php

namespace Fomento\Test;

use Fomento\Gateway;
use Fomento\Signer;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use SoapClient;

class GatewayShould extends TestCase
{
    private Signer $signer;
    private SoapClient $soapClient;

    public function setUp(): void
    {
        $this->signer = $this->createMock(Signer::class);
        $this->soapClient = $this->createMock(SoapClient::class);
    }

    /**
     * @test
     */
    public function uses_the_webservice(): void
    {
        $this
            ->soapClient
            ->expects($this->once())
            ->method('__getFunctions');

        $gateway = $this->buildGateway();
        $gateway->getFunctions();
    }

    /**
     * @param string $method
     * @test
     * @return void
     * @dataProvider methodNamesProvider
     */
    public function sign_the_xml_it_receives(string $method): void
    {
        $xml = new SimpleXMLElement('<root/>');
        $xml->addChild('aChild');

        $xmlText = $xml->asXML();

        $this->signer
            ->expects($this->once())
            ->method('sign')
            ->with($xmlText);

        $gateway = $this->buildGateway();
        $method = "aMethod";

        $gateway->call($method, $xmlText);
    }

    public function call_the_method_it_receives(): void
    {
    }

    public function return_the_raw_xml(): void
    {
    }

    public function methodNamesProvider(): array
    {
        return
            [
                ['aMethod',],
                ['ConsultaDeServicio',],
            ];
    }

    /**
     * @return Gateway
     */
    private function buildGateway(): Gateway
    {
        return new Gateway($this->soapClient, $this->signer);
    }
}
