<?php

declare(strict_types=1);

use BrekiTomasson\UtilityPHP\Utility;

beforeEach(function (): void {
    $this->utility = new Utility();
});

it(
    'returns correct values through complex usage',
    function (): void {
        $this->utility = new Utility();

        // Add some outcomes.
        $this->utility->addOutcome(0.5, 20);
        $this->utility->addOutcome(0.1, -10);
        $this->utility->addOutcome(0.1, -20);

        // At this point, the value should be 7.
        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(7.0);

        // Delete the first outcome.
        $this->utility->removeOutcome(0);

        // At this point, the value should be -3.
        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(-3.0);

        // Change the odds of what is now the first outcome.
        $this->utility->alterOutcome(0, 0.25, 5);

        // At this point, the value should be -0.75.
        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(-0.75);

        // Add some more outcomes.
        $this->utility->addOutcome(0.05, 5);
        $this->utility->addOutcome(0.5, 20);
        $this->utility->addOutcome(0.12, -30);

        // At this point, the value should be 5.9.
        expect($this->utility->getValue())
            ->toBeFloat()
            ->toBe(5.9);
    },
);

it('correctly handles the example in the README file', function (): void {
    $values = [
        [0.2, -5, 'less at sale'],
        [0.1, 6, 'more at sale'],
        [0.25, -6, 'more expensive buy'],
        [0.05, 8, 'less expensive buy'],
        [0.2, -4, 'significant renovation required'],
        [0.05, 3, 'no renovation required'],
        [0.3, -4, 'upkeep goes up'],
        [0.05, 6, 'upkeep goes down'],
        [1, -2, 'familiarity goes away'],
        [0.05, -5, 'stuff breaks during move'],
    ];

    $this->utility->addOutcomes($values);

    expect($this->utility->getValue())
        ->toBeFloat()
        ->toBe(-5.3);
});
