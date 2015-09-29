<?php

namespace WsdlToPhp\PackageBase;

abstract class AbstractStructArrayBase extends AbstractStructBase implements StructArrayInterface
{
    /**
     * Array that contains values when only one parameter is set when calling __construct method
     * @var array
     */
    protected $internArray;
    /**
     * Bool that tells if array is set or not
     * @var bool
     */
    protected $internArrayIsArray;
    /**
     * Items index browser
     * @var int
     */
    protected $internArrayOffset;
    /**
     * Method alias to count
     * @uses ApiWsdlClass::count()
     * @return int
     */
    public function length()
    {
        return $this->count();
    }
    /**
     * Method returning item length, alias to length
     * @uses ApiWsdlClass::getInternArray()
     * @uses ApiWsdlClass::getInternArrayIsArray()
     * @return int
     */
    public function count()
    {
        return $this->getInternArrayIsArray() ? count($this->getInternArray()) : -1;
    }
    /**
     * Method returning the current element
     * @uses ApiWsdlClass::offsetGet()
     * @return mixed
     */
    public function current()
    {
        return $this->offsetGet($this->internArrayOffset);
    }
    /**
     * Method moving the current position to the next element
     * @uses ApiWsdlClass::getInternArrayOffset()
     * @uses ApiWsdlClass::setInternArrayOffset()
     * @return AbstractStructArrayBase
     */
    public function next()
    {
        return $this->setInternArrayOffset($this->getInternArrayOffset() + 1);
    }
    /**
     * Method resetting itemOffset
     * @uses ApiWsdlClass::setInternArrayOffset()
     * @return int
     */
    public function rewind()
    {
        return $this->setInternArrayOffset(0);
    }
    /**
     * Method checking if current itemOffset points to an existing item
     * @uses ApiWsdlClass::getInternArrayOffset()
     * @uses ApiWsdlClass::offsetExists()
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists($this->getInternArrayOffset());
    }
    /**
     * Method returning current itemOffset value, alias to getInternArrayOffset
     * @uses ApiWsdlClass::getInternArrayOffset()
     * @return int
     */
    public function key()
    {
        return $this->getInternArrayOffset();
    }
    /**
     * Method alias to offsetGet
     * @see ApiWsdlClass::offsetGet()
     * @uses ApiWsdlClass::offsetGet()
     * @param int $index
     * @return mixed
     */
    public function item($index)
    {
        return $this->offsetGet($index);
    }
    /**
     * Default method adding item to array
     * @uses ApiWsdlClass::getAttributeName()
     * @uses ApiWsdlClass::__toString()
     * @uses ApiWsdlClass::_set()
     * @uses ApiWsdlClass::_get()
     * @uses ApiWsdlClass::setInternArray()
     * @uses ApiWsdlClass::setInternArrayIsArray()
     * @uses ApiWsdlClass::setInternArrayOffset()
     * @param mixed $item value
     * @return AbstractStructArrayBase
     */
    public function add($item)
    {
        if (stripos(get_called_class(), 'array') !== false) {
            /**
             * init array
             */
            if (!is_array($this->_get($this->getAttributeName()))) {
                $this->_set($this->getAttributeName(), array());
            }
            /**
             * current array
             */
            $currentArray = $this->_get($this->getAttributeName());
            array_push($currentArray, $item);
            $this
                ->_set($this->getAttributeName(), $currentArray)
                ->setInternArray($currentArray)
                ->setInternArrayIsArray(true)
                ->setInternArrayOffset(0);
        }
        return $this;
    }
    /**
     * Method returning the first item
     * @uses ApiWsdlClass::item()
     * @return mixed
     */
    public function first()
    {
        return $this->item(0);
    }
    /**
     * Method returning the last item
     * @uses ApiWsdlClass::item()
     * @uses ApiWsdlClass::length()
     * @return mixed
     */
    public function last()
    {
        return $this->item($this->length() - 1);
    }
    /**
     * Method testing index in item
     * @uses ApiWsdlClass::getInternArrayIsArray()
     * @uses ApiWsdlClass::getInternArray()
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ($this->getInternArrayIsArray() && array_key_exists($offset, $this->getInternArray()));
    }
    /**
     * Method returning the item at "index" value
     * @uses ApiWsdlClass::offsetExists()
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->internArray[$offset] : null;
    }
    /**
     * Method setting value at offset
     * @param mixed $offset
     * @param mixed $value
     * @return AbstractStructArrayBase
     */
    public function offsetSet($offset, $value)
    {
        $this->internArray[$offset] = $value;
        return $this->_set($this->getAttributeName(), $this->internArray);
    }
    /**
     * Method unsetting value at offset
     * @param mixed $offset
     * @return AbstractStructArrayBase
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->internArray[$offset]);
            $this->_set($this->getAttributeName(), $this->internArray);
        }
        return $this;
    }
    /**
     * Method returning intern array to iterate trough
     * @return array
     */
    public function getInternArray()
    {
        return $this->internArray;
    }
    /**
     * Method setting intern array to iterate trough
     * @param array $internArray
     * @return AbstractStructArrayBase
     */
    public function setInternArray($internArray)
    {
        $this->internArray = $internArray;
        return $this;
    }
    /**
     * Method returnint intern array index when iterating trough
     * @return int
     */
    public function getInternArrayOffset()
    {
        return $this->internArrayOffset;
    }
    /**
     * Method initiating internArray
     * @uses ApiWsdlClass::setInternArray()
     * @uses ApiWsdlClass::setInternArrayOffset()
     * @uses ApiWsdlClass::setInternArrayIsArray()
     * @uses ApiWsdlClass::getAttributeName()
     * @uses ApiWsdlClass::initInternArray()
     * @uses ApiWsdlClass::__toString()
     * @param array $array the array to iterate trough
     * @param bool $internCall indicates that methods is calling itself
     * @return AbstractStructArrayBase
     */
    public function initInternArray($array = array(), $internCall = false)
    {
        if (stripos(get_called_class(), 'array') !== false) {
            if (is_array($array) && count($array) > 0) {
                $this
                    ->setInternArray($array)
                    ->setInternArrayOffset(0)
                    ->setInternArrayIsArray(true);
            } elseif (!$internCall && property_exists($this, $this->getAttributeName())) {
                $this->initInternArray($this->_get($this->getAttributeName()), true);
            }
        }
        return $this;
    }
    /**
     * Method setting intern array offset when iterating trough
     * @param int $internArrayOffset
     * @return AbstractStructArrayBase
     */
    public function setInternArrayOffset($internArrayOffset)
    {
        $this->internArrayOffset = $internArrayOffset;
        return $this;
    }
    /**
     * Method returning true if intern array is an actual array
     * @return bool
     */
    public function getInternArrayIsArray()
    {
        return $this->internArrayIsArray;
    }
    /**
     * Method setting if intern array is an actual array
     * @param bool $internArrayIsArray
     * @return AbstractStructArrayBase
     */
    public function setInternArrayIsArray($internArrayIsArray = false)
    {
        $this->internArrayIsArray = $internArrayIsArray;
        return $this;
    }
}
