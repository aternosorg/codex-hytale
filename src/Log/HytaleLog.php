<?php

namespace Aternos\Codex\Hytale\Log;

use Aternos\Codex\Hytale\Analyser\HytaleAnalyser;
use Aternos\Codex\Analyser\AnalyserInterface;
use Aternos\Codex\Detective\LinePatternDetector;
use Aternos\Codex\Detective\SinglePatternDetector;
use Aternos\Codex\Hytale\Analysis\Information\HytaleVersionInformation;
use Aternos\Codex\Log\AnalysableLog;
use Aternos\Codex\Log\DetectableLogInterface;
use Aternos\Codex\Parser\ParserInterface;
use Aternos\Codex\Parser\PatternParser;

class HytaleLog extends AnalysableLog implements DetectableLogInterface
{
    public static string $prefixPattern = '(\[((?:[0-9]{2,4}\/?){3} (?:[0-9]{2}\:?){3})\s*(\w+)\])';
    protected static string $detectionPattern = '\[HytaleServer\] Starting HytaleServer';

    public static function getPattern(string $contentPattern = ''): string
    {
        if ($contentPattern) {
            $contentPattern = '\s*' . $contentPattern;
        }
        return '/^' . static::$prefixPattern . $contentPattern . '.*$/';
    }

    public static function getDefaultParser(): ParserInterface
    {
        return new PatternParser()
            ->setPattern(static::getPattern())
            ->setMatches([PatternParser::PREFIX, PatternParser::TIME, PatternParser::LEVEL])
            ->setTimeFormat("Y/m/d H:i:s");
    }

    public static function getDefaultAnalyser(): AnalyserInterface
    {
        return new HytaleAnalyser();
    }

    public static function getDetectors(): array
    {
        return [
            new SinglePatternDetector()->setPattern(static::getPattern(static::$detectionPattern)),
            new LinePatternDetector()->setPattern(static::getPattern())
        ];
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        /** @var HytaleVersionInformation[] $insights */
        $insights = $this->analyse()->getFilteredInsights(HytaleVersionInformation::class);
        if (count($insights) === 0) {
            return null;
        }
        return $insights[0]->getValue();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'id' => "hytale/server",
            'name' => "Hytale",
            'type' => "Server Log",
            'version' => $this->getVersion(),
            'title' => "Hytale Server Log"
        ], parent::jsonSerialize());
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return "Hytale Server Log";
    }
}