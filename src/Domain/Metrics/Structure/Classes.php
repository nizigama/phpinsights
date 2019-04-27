<?php

declare(strict_types=1);

namespace NunoMaduro\PhpInsights\Domain\Metrics\Structure;

use NunoMaduro\PhpInsights\Domain\Collector;
use NunoMaduro\PhpInsights\Domain\Contracts\HasInsights;
use NunoMaduro\PhpInsights\Domain\Contracts\HasValue;
use NunoMaduro\PhpInsights\Domain\Insights\ClassTooBig;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\MethodTooBig;
use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Classes\DuplicateClassNameSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use SlevomatCodingStandard\Sniffs\Classes\ModernClassNameReferenceSniff;
use SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff;

/**
 * @internal
 */
final class Classes implements HasValue, HasInsights
{
    /**
     * {@inheritdoc}
     */
    public function getValue(Collector $collector): string
    {
        return sprintf('%d', $collector->getClasses());
    }

    /**
     * {@inheritdoc}
     */
    public function getInsights(): array
    {
        return [
            ForbiddenNormalClasses::class,
            ValidClassNameSniff::class,
            ClassDeclarationSniff::class,
            DuplicateClassNameSniff::class,
            UnusedPrivateElementsSniff::class,
            ModernClassNameReferenceSniff::class,
            ClassTraitAndInterfaceLengthSniff::class,
            MethodPerClassLimitSniff::class,
            ClassTooBig::class,
            MethodTooBig::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPercentage(Collector $collector): float
    {
        return count($collector->getFiles()) > 0 ? ($collector->getClasses() / count($collector->getFiles())) * 100 : 0;
    }
}
