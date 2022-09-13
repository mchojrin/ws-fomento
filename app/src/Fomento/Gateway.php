<?php

namespace Fomento;

use SoapClient;

class Gateway
{

    private SoapClient $client;

    public function __construct(SoapClient $client)
    {
        $this->client = $client;
    }

    public function getFunctions(): ?array
    {
        return $this->client->__getFunctions();
    }
}