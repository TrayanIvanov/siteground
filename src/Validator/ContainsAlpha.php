<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsAlpha extends Constraint
{
    public string $message = 'Invalid goods list provided - it can only contain capital letters.';
}
