<?php

declare(strict_types=1);

namespace Tests;

use BrekiTomasson\UtilityPHP\Utility;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * @internal
 */
abstract class TestCase extends BaseTestCase
{
    public Utility $utility;
}
