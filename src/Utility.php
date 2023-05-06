<?php

declare(strict_types=1);

namespace BrekiTomasson\UtilityPHP;

use BrekiTomasson\UtilityPHP\Exceptions\IndexOutOfBounds;
use BrekiTomasson\UtilityPHP\Exceptions\OddsOutOfBounds;

class Utility
{
    protected array $outcomes = [];

    protected float $value = 0.0;

    /** @throws OddsOutOfBounds */
    public function __construct(array $input = [])
    {
        if (! empty($input)) {
            $this->addOutcomes($input);
        }
    }

    /** @throws OddsOutOfBounds */
    public function addOutcome(float $odds, float $value, string|null $text = null): float
    {
        $this->add($odds, $value, $text);

        return $this->getValue();
    }

    /** @throws OddsOutOfBounds */
    public function addOutcomes(array $input): float
    {
        foreach ($input as $item) {
            $this->add($item[0], $item[1], $item[2] ?? null);
        }

        return $this->getValue();
    }

    /** @throws IndexOutOfBounds|OddsOutOfBounds */
    public function alterOutcome(int $index, float $odds, float $value, string $text = ''): void
    {
        $this->throwIfIndexIsOutOfRange($index);

        $this->throwIfOddsAreInvalid($odds);

        $this->outcomes[$index] = ['odds' => $odds, 'value' => $value, 'text' => $text];

        $this->calculateValue();
    }

    public function calculateValue(): void
    {
        $this->value = 0.0;

        foreach ($this->outcomes as $outcome) {
            $this->value += $outcome['odds'] * $outcome['value'];
        }
    }

    public function getValue(): float
    {
        $this->calculateValue();

        return $this->value;
    }

    public function listOutcomes(): array
    {
        return $this->outcomes;
    }

    /** @throws IndexOutOfBounds */
    public function removeOutcome(int $index): void
    {
        $this->throwIfIndexIsOutOfRange($index);

        unset($this->outcomes[$index]);

        $this->outcomes = array_values($this->outcomes);

        $this->calculateValue();
    }

    /** @throws IndexOutOfBounds */
    public function getOutcome(int $index): array
    {
        $this->throwIfIndexIsOutOfRange($index);

        return $this->outcomes[$index];
    }

    protected function indexIsOutOfRange(int $index): bool
    {
        if ($index < 0) {
            return false;
        }

        return $index > count($this->outcomes) - 1;
    }

    /** @throws OddsOutOfBounds */
    private function add(float $odds, float $value, string|null $text = null): void
    {
        $this->throwIfOddsAreInvalid($odds);

        $this->outcomes[] = [
            'odds' => $odds,
            'value' => $value,
            'text' => $text,
        ];

        $this->calculateValue();
    }

    private function oddsAreInvalid(float $odds): bool
    {
        return $odds <= 0.0 || $odds > 1.0;
    }

    /** @throws IndexOutOfBounds */
    private function throwIfIndexIsOutOfRange(int $index): void
    {
        if ($this->indexIsOutOfRange($index)) {
            $message = $index
                . ' is out of bounds. Valid index values are 0 to '
                . (count($this->outcomes) - 1)
                . '.';

            throw new IndexOutOfBounds($message);
        }
    }

    /** @throws OddsOutOfBounds */
    private function throwIfOddsAreInvalid(float $odds): void
    {
        if ($this->oddsAreInvalid($odds)) {
            $message = $odds . ' is out of bounds. Valid odds must be greater than 0 and lower than or equal to 1.';

            throw new OddsOutOfBounds($message);
        }
    }
}
