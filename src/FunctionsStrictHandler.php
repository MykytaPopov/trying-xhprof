<?php

declare(strict_types=1);

namespace App;

/**
 * Class FunctionsStrictHandler to strict compare two arrays using fluent php functions
 */
class FunctionsStrictHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function findDiff(array $a, array $b): array
    {
        $diff = [
            'new' => [],
            'changed' => [],
            'removed' => [],
        ];

        if ($this->sameOnTheFirstStep($a, $b)) {
            return $diff;
        }

        $strictCompare = function ($a, $b) {
            return $a !== $b;
        };

        $diff['new'] = array_diff_key($b, $a);
        $diff['changed'] = array_udiff_assoc(array_diff_key($b, $diff['new']), $a, $strictCompare);
        $diff['removed'] = array_diff_key($a, $b);

        return $diff;
    }
}
