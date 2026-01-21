<?php

namespace Aternos\Codex\Hytale\Analyser;

use Aternos\Codex\Analyser\PatternAnalyser;
use Aternos\Codex\Hytale\Analysis\Information\HytaleVersionInformation;

class HytaleAnalyser extends PatternAnalyser
{
    public function __construct()
    {
        $this->addPossibleInsightClass(HytaleVersionInformation::class);
    }
}