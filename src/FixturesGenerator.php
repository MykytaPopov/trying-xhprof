<?php

declare(strict_types=1);

namespace App;

/**
 * Class FixturesGenerator generates random array data
 */
class FixturesGenerator
{
    private array $data = [];

    /**
     * Puts generated array data to object property
     *
     * @param int $length The number of array elements to be generated
     *
     * @return $this
     */
    public function load(int $length): self
    {
        if ($length < 1) {
            throw new \RangeException('Could not generate less than 1 record of data');
        }

        $this->data = $this->generateData($length);

        return $this;
    }

    /**
     * Resets array data values from object property
     *
     * @param int $length Number of array elements to be reset
     *
     * @return $this
     */
    public function resetValues(int $length): self
    {
        $dataLength = count($this->data);
        if ($length > $dataLength) {
            $length = count($this->data);
        }

        $randKeys = array_rand($this->data, $length);

        foreach ($randKeys as $randKey) {
            $this->data[$randKey] = $this->generateRandomString();
        }

        return $this;
    }

    /**
     * Adds new array elements to data in object property
     *
     * @param int $length Number of array elements to be added
     *
     * @return $this
     */
    public function addValues(int $length): self
    {
        $data = $this->generateData($length);

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Removes array elements from data in object property
     *
     * @param int $length Number of array elements to be removed
     *
     * @return $this
     */
    public function removeValues(int $length): self
    {
        $dataLength = count($this->data);
        if ($length > $dataLength) {
            $length = $dataLength;
        }

        $keys = array_rand($this->data, $length);

        $this->data = array_diff_key($this->data, array_flip($keys));

        return $this;
    }

    /**
     * Converts array data of object property into json
     *
     * @return string
     */
    public function getJsonData(): string
    {
        return json_encode($this->data);
    }

    /**
     * Generate array data
     *
     * @param int $length Number of array elements to be generated
     *
     * @return array
     */
    private function generateData(int $length): array
    {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $key = $this->generateRandomString();
            if (isset($data[$key])) {
                $i--;
                continue;
            }
            $data[$key] = 'iteration: ' . $i;
        }

        return $data;
    }

    /**
     * Generates random string with specified length
     *
     * @param int $length Number of characters in the generated string
     *
     * @return string
     */
    private function generateRandomString($length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $key;
    }
}
