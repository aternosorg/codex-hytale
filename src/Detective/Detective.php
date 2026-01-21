<?php

namespace Aternos\Codex\Hytale\Detective;

class Detective extends \Aternos\Codex\Detective\Detective
{
    protected array $possibleLogClasses = [
        \Aternos\Codex\Hytale\Log\HytaleLog::class,
    ];
}