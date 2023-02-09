<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageBase;

abstract class AbstractStructArrayBase extends AbstractStructBase implements StructArrayInterface
{
    /**
     * Array that contains values when only one parameter is set when calling __construct method
     * @var array
     */
    private array $internArray = [];

    /**
     * Bool that tells if array is set or not
     * @var bool
     */
    private bool $internArrayIsArray = false;

    /**
     * Items index browser
     * @var int
     */
    private int $internArrayOffset = 0;

    /**
     * Method alias to count
     * @return int
     */
    public function length(): int
    {
        $this->initInternArray();

        return $this->count();
    }

    /**
     * Method returning item length, alias to length
     * @return int
     */
    public function count(): int
    {
        $this->initInternArray();

        return $this->getInternArrayIsArray() ? count($this->getInternArray()) : -1;
    }

    /**
     * Method returning the current element
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        $this->initInternArray();

        return $this->offsetGet($this->internArrayOffset);
    }

    /**
     * Method moving the current position to the next element
     * @return AbstractStructArrayBase
     */
    #[\ReturnTypeWillChange]
    public function next(): self
    {
        $this->initInternArray();

        return $this->setInternArrayOffset($this->getInternArrayOffset() + 1);
    }

    /**
     * Method resetting itemOffset
     * @return AbstractStructArrayBase
     */
    #[\ReturnTypeWillChange]
    public function rewind(): self
    {
        $this->initInternArray();

        return $this->setInternArrayOffset(0);
    }

    /**
     * Method checking if current itemOffset points to an existing item
     * @return bool
     */
    public function valid(): bool
    {
        $this->initInternArray();

        return $this->offsetExists($this->getInternArrayOffset());
    }

    /**
     * Method returning current itemOffset value, alias to getInternArrayOffset
     * @return int
     */
    public function key(): int
    {
        $this->initInternArray();

        return $this->getInternArrayOffset();
    }

    /**
     * Method alias to offsetGet
     * @param mixed $index
     * @return mixed
     */
    public function item($index)
    {
        $this->initInternArray();

        return $this->offsetGet($index);
    }

    /**
     * Default method adding item to array
     * @param mixed $item value
     * @return AbstractStructArrayBase
     */
    public function add($item): self
    {
        // init array
        if (!is_array($this->getPropertyValue($this->getAttributeName()))) {
            $this->setPropertyValue($this->getAttributeName(), []);
        }

        // current array
        $currentArray = $this->getPropertyValue($this->getAttributeName());
        $currentArray[] = $item;
        $this
            ->setInternArray($currentArray)
            ->setInternArrayIsArray(true)
            ->setInternArrayOffset(0)
            ->setPropertyValue($this->getAttributeName(), $currentArray);

        return $this;
    }

    /**
     * Method returning the first item
     * @return mixed
     */
    public function first()
    {
        $this->initInternArray();

        return $this->item(0);
    }

    /**
     * Method returning the last item
     * @return mixed
     */
    public function last()
    {
        $this->initInternArray();

        return $this->item($this->length() - 1);
    }

    /**
     * Method testing index in item
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        $this->initInternArray();

        return ($this->getInternArrayIsArray() && array_key_exists($offset, $this->getInternArray()));
    }

    /**
     * Method returning the item at "index" value
     * @param mixed $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        $this->initInternArray();

        return $this->offsetExists($offset) ? $this->internArray[$offset] : null;
    }

    /**
     * Method setting value at offset
     * @param mixed $offset
     * @param mixed $value
     * @return AbstractStructArrayBase
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value): self
    {
        $this->initInternArray();

        $this->internArray[$offset] = $value;

        $this->setPropertyValue($this->getAttributeName(), $this->internArray);

        return $this;
    }

    /**
     * Method unsetting value at offset
     * @param mixed $offset
     * @return AbstractStructArrayBase
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): self
    {
        $this->initInternArray();

        if ($this->offsetExists($offset)) {
            unset($this->internArray[$offset]);
            $this->setPropertyValue($this->getAttributeName(), $this->internArray);
        }

        return $this;
    }

    /**
     * Method returning intern array to iterate trough
     * @return array
     */
    private function getInternArray(): array
    {
        return $this->internArray;
    }

    /**
     * Method setting intern array to iterate trough
     * @param array $internArray
     * @return AbstractStructArrayBase
     */
    private function setInternArray(array $internArray): self
    {
        $this->internArray = $internArray;

        return $this;
    }

    /**
     * Method returns intern array index when iterating trough
     * @return int
     */
    private function getInternArrayOffset(): int
    {
        return $this->internArrayOffset;
    }

    /**
     * Method initiating internArray
     * @param array $array the array to iterate trough
     * @param bool $internCall indicates that methods is calling itself
     * @return AbstractStructArrayBase
     */
    private function initInternArray($array = [], bool $internCall = false): self
    {
        if (is_array($array) && count($array) > 0) {
            $this
                ->setInternArray($array)
                ->setInternArrayOffset(0)
                ->setInternArrayIsArray(true);
        } elseif (!$this->internArrayIsArray && !$internCall && property_exists($this, $this->getAttributeName())) {
            $this->initInternArray($this->getPropertyValue($this->getAttributeName()), true);
        }

        return $this;
    }

    /**
     * Method setting intern array offset when iterating trough
     * @param int $internArrayOffset
     * @return AbstractStructArrayBase
     */
    private function setInternArrayOffset(int $internArrayOffset): self
    {
        $this->internArrayOffset = $internArrayOffset;

        return $this;
    }

    /**
     * Method returning true if intern array is an actual array
     * @return bool
     */
    private function getInternArrayIsArray(): bool
    {
        return $this->internArrayIsArray;
    }

    /**
     * Method setting if intern array is an actual array
     * @param bool $internArrayIsArray
     * @return AbstractStructArrayBase
     */
    private function setInternArrayIsArray(bool $internArrayIsArray = false): self
    {
        $this->internArrayIsArray = $internArrayIsArray;

        return $this;
    }
}
