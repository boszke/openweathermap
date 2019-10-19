<?php

namespace App\Structure;

interface ValidatorInterface
{
    /**
     * @throws \App\Exception\ValidationException
     */
    public function valid();
}
