<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

use InvalidArgumentException;
use JsonSerializable;
use ReflectionClass;

abstract class AbstractStructBase implements StructInterface, JsonSerializable
{
    /**
     * Returns the properties of this object
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return \get_object_vars($this);
    }

    /**
     * Generic method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @param array $array the exported values
     * @return self
     */
    public static function __set_state(array $array): StructInterface
    {
        $reflection = new ReflectionClass(get_called_class());
        $object = $reflection->newInstance();
        foreach ($array as $name => $value) {
            $object->setPropertyValue($name, $value);
        }

        return $object;
    }

    /**
     * Generic method setting value
     * @throws InvalidArgumentException
     * @param string $name property name to set
     * @param mixed $value property value to use
     * @return self
     * @internal
     */
    public function setPropertyValue(string $name, $value): self
    {
        $setMethod = 'set' . ucfirst($name);
        if (method_exists($this, $setMethod)) {
            $this->$setMethod($value);
        } else {
            throw new InvalidArgumentException(sprintf('Setter does not exist for "%s" property', $name));
        }

        return $this;
    }

    /**
     * Generic method getting value
     * @throws InvalidArgumentException
     * @param string $name property name to get
     * @return mixed
     * @internal
     */
    public function getPropertyValue(string $name)
    {
        $getMethod = 'get' . ucfirst($name);
        if (method_exists($this, $getMethod)) {
            return $this->$getMethod();
        }

        throw new InvalidArgumentException(sprintf('Getter does not exist for "%s" property', $name));
    }

    /**
     * Default string representation of current object. Don't want to expose any sensible data
     * @return string
     */
    public function __toString(): string
    {
        return get_called_class();
    }
}
