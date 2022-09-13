<?php

namespace Fomento;

use SoapClient;

class Gateway
{
    private SoapClient $client;
    private Signer $signer;

    public function __construct(SoapClient $client, Signer $signer)
    {
        $this->client = $client;
        $this->signer = $signer;
    }

    public function getFunctions(): ?array
    {
        return $this->client->__getFunctions();
    }

    public function call(string $method, string $xmlText): string
    {
        return $this->client->__soapCall($method, [$this->signer->sign($xmlText)]);
    }
}