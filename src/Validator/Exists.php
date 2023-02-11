<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Exists extends Constraint
{
    public string $message = 'Non-existing goods provided - {{ string }}.';
}
