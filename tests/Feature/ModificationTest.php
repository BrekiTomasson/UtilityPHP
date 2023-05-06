<?php

declare(strict_types=1);

use BrekiTomasson\UtilityPHP\Utility;

beforeEach(function (): void {
    $this->utility = new Utility();
});

it(
    'correctly returns correct values after altering outcome entries',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->alterOutcome(1, 0.2, -10);

        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(6.0);
    },
);

it(
    'returns zero if all outcomes are removed',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->removeOutcome(2);
        $this->utility->removeOutcome(1);
        $this->utility->removeOutcome(0);

        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(0.0);
    },
);

it(
    'correctly returns correct values after deleting outcome entries',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        $this->utility->removeOutcome(1);

        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(8.0);
    },
);
