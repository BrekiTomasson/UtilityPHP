<?php

declare(strict_types=1);

use BrekiTomasson\UtilityPHP\Exceptions\IndexOutOfBounds;
use BrekiTomasson\UtilityPHP\Exceptions\OddsOutOfBounds;
use BrekiTomasson\UtilityPHP\Utility;

beforeEach(function (): void {
    $this->utility = new Utility();
});

it(
    'throws exceptions when deleting an out of bounds index',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->removeOutcome(4);
    },
)->throws(IndexOutOfBounds::class);

it(
    'throws exceptions when altering an out of bounds index',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->alterOutcome(4, 0.2, -10);
    },
)->throws(IndexOutOfBounds::class);

it(
    'throws exceptions when getting an out of bounds index',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->getOutcome(4);
    },
)->throws(IndexOutOfBounds::class);

it(
    'throws exceptions when using negative numbers as odds',
    function (): void {
        $this->utility->addOutcome(-1, 20);
    },
)->throws(OddsOutOfBounds::class);

it(
    'throws exceptions when using numbers greater than 1 as odds',
    function (): void {
        $this->utility->addOutcome(4, 20);
    },
)->throws(OddsOutOfBounds::class);
