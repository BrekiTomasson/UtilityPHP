<?php

declare(strict_types=1);

use BrekiTomasson\UtilityPHP\Utility;

beforeEach(function (): void {
    $this->utility = new Utility();
});

it(
    'can add values one by one',
    function (): void {
        $this->utility->addOutcome(0.5, 20);
        $this->utility->addOutcome(0.1, -10);
        $this->utility->addOutcome(0.1, -20);

        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(7.0);
    },
);

it(
    'can add values on creation',
    function (): void {
        $utility = new Utility([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        expect($utility->getValue())
            ->toBeFloat()
            ->toBe(7.0);
    },
);

it(
    'can add values in bulk after creation',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(7.0);
    },
);

it(
    'returns zero when no outcomes are added',
    function (): void {
        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(0.0);
    },
);

it(
    'can return the value of a specific outcome',
    function (): void {
        $this->utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20],
        ]);

        expect($this->utility->getOutcome(1))
            ->toBeArray()
            ->toBe([
                'odds' => 0.1,
                'value' => -10.0,
                'text' => null,
            ]);
    }
);
