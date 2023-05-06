<?php

declare(strict_types=1);

uses(Tests\TestCase::class)
    ->in('Feature', 'Unit');

expect()->extend('toBeOne', fn () => $this->toBe(1));

function something(): void
{
    // Nothing here.
}
