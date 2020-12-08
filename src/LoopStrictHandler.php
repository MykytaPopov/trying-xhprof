<?php

declare(strict_types=1);

namespace App;

/**
 * Class LoopStrictHandler to compare two arrays using for loop
 *
 * @package App
 */
class LoopStrictHandler extends AbstractHandler
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

        foreach ($a as $key => $value) {
            if (isset($b[$key])) {
                if ($value !== $b[$key]) {
                    $diff['changed'][$key] = $b[$key];
                }
                unset($b[$key]);
                continue;
            }
            $diff['removed'][$key] = $value;
        }

        $diff['new'] = $b;

        return $diff;
    }
}