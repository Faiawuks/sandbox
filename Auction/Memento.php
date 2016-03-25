<?php

namespace Auction;

use ReflectionClass;
use ReflectionProperty;

class Memento
{
    /** @var object */
    private $keeper;

    /**
     * @param object $object
     */
    public function __construct($object)
    {
        $this->create($object);
    }

    /**
     * Return content.
     *
     * @return object
     */
    public function getContent()
    {
        return unserialize($this->keeper);
    }

    /**
     * Create a memento for an object.
     *
     * @param object $object
     */
    private function create($object)
    {
        if (is_object($object)) {
            $this->keeper = serialize($object);
        }
    }

    /**
     * Check if given object is dirty.
     *
     * @param object $possibleDirtyObject
     *
     * @return bool
     */
    public function isDirty($possibleDirtyObject)
    {
        if (null !== $this->keeper) {
            $memento = unserialize($this->keeper);

            return $memento != $possibleDirtyObject;
        }

        return false;
    }

    /**
     * Reset object to original state.
     *
     * @param object $dirtyObject
     */
    public function reset($dirtyObject)
    {
        $workbenchObject = new ReflectionClass($dirtyObject);
        $workbenchProperties = $workbenchObject->getProperties(
            ReflectionProperty::IS_PUBLIC |
            ReflectionProperty::IS_PROTECTED |
            ReflectionProperty::IS_PRIVATE
        );

        $originalObject = unserialize($this->keeper);
        $blueprintObject = new ReflectionClass($originalObject);
        $blueprintObjectProperties = $blueprintObject->getProperties(
            ReflectionProperty::IS_PUBLIC |
            ReflectionProperty::IS_PROTECTED |
            ReflectionProperty::IS_PRIVATE
        );

        foreach ($blueprintObjectProperties as $blueprintPropertyKey => $blueprintProperty) {
            $blueprintProperty->setAccessible(true);
            $workbenchProperties[$blueprintPropertyKey]->setAccessible(true);

            $workbenchProperties[$blueprintPropertyKey]->setValue(
                $dirtyObject,
                $blueprintProperty->getValue($originalObject)
            );
        }
    }
}
