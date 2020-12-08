<?php

declare(strict_types=1);

namespace App;

/**
 * Class FunctionsHandler to compare two arrays using fluent php functions
 */
class FunctionsHandler extends AbstractHandler
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

        $diff['new'] = array_diff_key($b, $a);
        $diff['changed'] = array_diff_assoc(array_diff_key($b, $diff['new']), $a);
        $diff['removed'] = array_diff_key($a, $b);

        return $diff;
    }
}
