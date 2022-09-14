<?php

namespace Fomento;

use XmlDsig\XmlDigitalSignature;

class Signer
{
    private XmlDigitalSignature $digitalSignature;

    public function __construct(string $privateKeyPath, string $publicKeyPath, string $privateKeyPassphrase)
    {
        $this->digitalSignature = new XmlDigitalSignature();
        $this->digitalSignature->loadPrivateKey($privateKeyPath);
        $this->digitalSignature->loadPublicKey($publicKeyPath);
    }

    public function sign(string $text): string
    {
        $this->digitalSignature->addObject($text);
        $this->digitalSignature->sign();

        return $this->digitalSignature->getSignedDocument();
    }
}