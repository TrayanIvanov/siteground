<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

abstract class AbstractUnitTestCase extends TestCase
{
    use ProphecyTrait;
}
