<?php

namespace Fomento;

class Gateway
{

    public function __construct()
    {
    }

    public function getFunctions(): array
    {
        return ['ConsultaDeServicio'];
    }
}