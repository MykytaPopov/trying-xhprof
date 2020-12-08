<?php

declare(strict_types=1);

namespace App;

/**
 * Class AbstractHandler to compare two arrays
 */
abstract class AbstractHandler
{
    /**
     * returns diff in format
     * [
     *     'new' => [..],
     *     'changed' => [..],
     *     'removed' => [..],
     * ]
     *
     * @param array $a
     * @param array $b
     *
     * @return array[][]
     */
    abstract public function findDiff(array $a, array $b): array;

    /**
     * First level comparison if arrays are the same length
     *
     * @param array $a
     * @param array $b
     *
     * @return bool
     */
    public function sameOnTheFirstStep(array $a, array $b): bool
    {
        if (count($a) !== count($b)) {
            return false;
        }

        asort($a);
        asort($b);

        return $a === $b;
    }
}
