<?php

namespace BrekiTomasson\UtilityPHP;

use BrekiTomasson\UtilityPHP\Exceptions\IndexOutOfBoundsException;
use BrekiTomasson\UtilityPHP\Exceptions\OddsOutOfBoundsException;

class Utility
{
    protected array $outcomes;

    protected float $value = 0;

    /**
     * Utility constructor.
     *
     * @param  array  $input
     *
     * @throws OddsOutOfBoundsException
     */
    public function __construct(array $input = [])
    {
        // If an array is given during construction, bulk add those values.
        if (count($input) > 0) {
            $this->addOutcomes($input);
        }
    }

    public function calculateValue() : void
    {
        $this->value = 0;

        foreach ($this->outcomes as $outcome) {
            $this->value += $outcome['odds'] * $outcome['value'];
        }
    }

    public function getValue() : float
    {
        return $this->value;
    }

    public function listOutcomes() : array
    {
        return $this->outcomes;
    }

    /**
     * @param  int  $index
     *
     * @throws IndexOutOfBoundsException
     */
    public function removeOutcome(int $index) : void
    {
        $this->throwIfIndexIsOutOfRange($index);

        unset($this->outcomes[$index]);

        $this->outcomes = array_values($this->outcomes);

        $this->calculateValue();

    }

    /**
     * @param  int     $index
     * @param  float   $odds
     * @param  float   $value
     * @param  string  $text
     *
     * @throws IndexOutOfBoundsException
     * @throws OddsOutOfBoundsException
     */
    public function alterOutcome(int $index, float $odds, float $value, string $text = '') : void
    {
        $this->throwIfIndexIsOutOfRange($index);

        $this->throwIfOddsAreInvalid($odds);

        $this->outcomes[$index] = ['odds' => $odds, 'value' => $value, 'text' => $text];

        $this->calculateValue();
    }

    /**
     * @param  float   $odds
     * @param  float   $value
     * @param  string  $text
     *
     * @throws OddsOutOfBoundsException
     * @return float
     */
    public function addOutcome(float $odds, float $value, string $text = '') : float
    {
        $this->add($odds, $value, $text);

        $this->calculateValue();

        return $this->getValue();
    }

    /**
     * @param  array  $input
     *
     * @throws OddsOutOfBoundsException
     * @return float
     */
    public function addOutcomes(array $input) : float
    {
        foreach ($input as $item) {
            $this->add($item[0], $item[1], $item[2] ?? '');
        }

        $this->calculateValue();

        return $this->getValue();
    }

    /**
     * @param  float   $odds
     * @param  float   $value
     * @param  string  $text
     *
     * @throws OddsOutOfBoundsException
     */
    private function add(float $odds, float $value, string $text) : void
    {
        $this->throwIfOddsAreInvalid($odds);

        $this->outcomes[] = ['odds' => $odds, 'value' => $value, 'text' => $text];
    }

    /**
     * @param  int  $index
     *
     * @return bool
     */
    protected function indexIsOutOfRange(int $index) : bool
    {
        if ($index < 0) {
            return false;
        }

        return $index > count($this->outcomes) - 1;
    }

    /**
     * @param  float  $odds
     *
     * @return bool
     */
    private function oddsAreInvalid(float $odds) : bool
    {
        return $odds <= 0 || $odds > 1;
    }

    /**
     * @param  int  $index
     *
     * @throws IndexOutOfBoundsException
     */
    private function throwIfIndexIsOutOfRange(int $index) : void
    {
        if ($this->indexIsOutOfRange($index)) {
            throw new IndexOutOfBoundsException($index . ' is out of bounds. Valid index values range 0-' . (count($this->outcomes) - 1) . '.');
        }
    }

    /**
     * @param  float  $odds
     *
     * @throws OddsOutOfBoundsException
     */
    private function throwIfOddsAreInvalid(float $odds) : void
    {
        if ($this->oddsAreInvalid($odds)) {
            throw new OddsOutOfBoundsException($odds . ' is out of bounds. Valid odds must be greater than 0 and lower than or equal to 1.');
        }
    }

}
