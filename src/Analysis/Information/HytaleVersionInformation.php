<?php

namespace Aternos\Codex\Hytale\Analysis\Information;

use Aternos\Codex\Hytale\Analysis\Information\HytaleInformation;
use Aternos\Codex\Hytale\Log\HytaleLog;

class HytaleVersionInformation extends HytaleInformation
{
    /**
     * @return array|string[]
     */
    public static function getPatterns(): array
    {
        return [
            HytaleLog::getPattern('\[HytaleServer\] Booting up HytaleServer - Version: ([\w\.-]+), Revision: \w+')
        ];
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return "Hytale Version";
    }
}