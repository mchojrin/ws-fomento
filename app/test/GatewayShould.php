<?php

namespace Fomento\Test;

use Fomento\Gateway;
use PHPUnit\Framework\TestCase;
use SoapClient;

class GatewayShould extends TestCase
{
    /**
     * @test
     */
    public function uses_the_webservice(): void
    {
        $client = $this->createMock(SoapClient::class);
        $client
            ->expects($this->once())
            ->method('__getFunctions');

        $gateway = new Gateway($client);
        $gateway->getFunctions();
    }
}
