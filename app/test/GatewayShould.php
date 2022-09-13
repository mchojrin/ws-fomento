<?php

namespace Fomento\Test;

use Fomento\Gateway;
use PHPUnit\Framework\TestCase;

class GatewayShould extends TestCase
{
    /**
     * @test
     */
    public function connect_to_fomento_webservice(): void
    {
        $gateway = new Gateway();
        $this->assertContains('ConsultaDeServicio', $gateway->getFunctions());
    }
}
