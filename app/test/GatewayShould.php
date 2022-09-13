<?php

declare(strict_types=1);

namespace Fomento\Test;

use Exception;
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

    /**
     * @param string $method
     * @test
     * @return void
     * @dataProvider methodNamesProvider
     */
    public function call_the_method_it_receives(string $method): void
    {
        $this->soapClient
            ->expects($this->once())
            ->method("__soapCall")
            ->with($method)
        ;
        $gateway = $this->buildGateway();
        $gateway->call($method, "");
    }

    /**
     * @param string $method
     * @return void
     * @throws Exception
     * @test
     * @dataProvider methodNamesProvider
     */
    public function return_raw_xml(string $method): void
    {
        $this->expectNotToPerformAssertions();
        $xml = "<root/>";
        $gateway = $this->buildGateway();
        $xml = new SimpleXMLElement($gateway->call($method, $xml));
    }

    /**
     * @test
     * @param string $method
     * @dataProvider methodNamesProvider
     */
    public function return_result_from_the_webservice(string $method): void
    {
        $xml = (new SimpleXMLElement("<root/>"))->asXML();

        $this->soapClient
            ->method("__soapCall")
            ->with($method)
            ->willReturn($xml);

        $gateway = $this->buildGateway();
        $this->assertEquals($xml, $gateway->call($method, ""));
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
