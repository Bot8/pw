<?php

namespace App\Core;

class Model
{

    /**
     * Model constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function toArray()
    {
        $properties = array_map(function (\ReflectionProperty $property) {
            return [$property->getName() => $property->getValue($this)];
        }, (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC));

        return $properties;
    }
}