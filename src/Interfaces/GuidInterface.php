<?php

namespace App\Interfaces;

interface GuidInterface
{
    public function getLength(string $input): void;

    public function filsDeLoutre(): bool;
}