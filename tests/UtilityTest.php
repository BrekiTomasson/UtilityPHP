<?php

use BrekiTomasson\UtilityPHP\Exceptions\IndexOutOfBoundsException;
use BrekiTomasson\UtilityPHP\Exceptions\OddsOutOfBoundsException;
use BrekiTomasson\UtilityPHP\Utility;

class UtilityTest extends \PHPUnit\Framework\TestCase
{

    public function testValuesCanBeAddedOneByOne() : void
    {
        $utility = new Utility();

        $utility->addOutcome(0.5, 20);
        $utility->addOutcome(0.1, -10);
        $utility->addOutcome(0.1, -20);

        self::assertEquals(7, $utility->getValue());
    }

    public function testValuesCanBeAddedOnCreation() : void
    {
        $utility = new Utility([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        self::assertEquals(7, $utility->getValue());
    }

    public function testValuesCanBeBulkAddedAfterCreation() : void
    {
        $utility = new Utility;

        $utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        self::assertEquals(7, $utility->getValue());
    }

    public function testDeletingValueWithIndexOutOfBoundsThrowsException() : void
    {
        $utility = new Utility;

        $utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        $this->expectException(IndexOutOfBoundsException::class);

        $utility->removeOutcome(4);
    }

    public function testRemovingValueRegeneratesValue() : void
    {
        $utility = new Utility;

        $utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        // Remove the 10% possibility of -10.
        $utility->removeOutcome(1);

        self::assertEquals(8, $utility->getValue());
    }

    public function testAlteringValueWithIndexOutOfBoundsThrowsException() : void
    {
        $utility = new Utility;

        $utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        $this->expectException(IndexOutOfBoundsException::class);

        $utility->alterOutcome(4, 0.2, -10);
    }

    public function testAlteringValueRegeneratesValue() : void
    {
        $utility = new Utility;

        $utility->addOutcomes([
            [0.5, 20],
            [0.1, -10],
            [0.1, -20]
        ]);

        // Alter the 10% possibility of -10 to a 20% possibility of -10.
        $utility->alterOutcome(1, 0.2, -10);

        self::assertEquals(6, $utility->getValue());
    }

    public function testAddingNegativeOddsThrowsException() : void
    {
        $utility = new Utility;

        $this->expectException(OddsOutOfBoundsException::class);

        $utility->addOutcome(-4, 20);
    }

    public function testAddingOddsGreaterThanOneThrowsException() : void
    {
        $utility = new Utility;

        $this->expectException(OddsOutOfBoundsException::class);

        $utility->addOutcome(4, 20);
    }

    public function testEmptyObjectGivesZeroValue() : void
    {
        $utility = new Utility;

        self::assertEquals(0, $utility->getValue());
    }


    public function testRemovingAllEntriesGivesZeroValue() : void
    {
        $utility = new Utility([[0.5, 100], [0.2, -100], [0.4, 99]]);

        $utility->removeOutcome(2);
        $utility->removeOutcome(1);
        $utility->removeOutcome(0);

        self::assertEquals(0, $utility->getValue());
    }

    public function testExampleFromReadme() : void
    {
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
            [0.05, -5, 'stuff breaks during move']
        ];

        $utility = new Utility($values);

        self::assertEquals(-5.3, $utility->getValue());
    }

}
