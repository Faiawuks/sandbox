<?php

namespace Helper;

class Memento
{
    private $keeper;

    public function __construct($object)
    {
        $this->create($object);
    }

    private function create($object)
    {
        if (!is_object($object)) {
            // Actually better to throw exception.
            return null;
        }

        $this->keeper = serialize($object);
    }

    public function isDirty($possibleDirtyObject)
    {
        if (null !== $this->keeper) {
            $memento = unserialize($this->keeper);

            return $memento != $possibleDirtyObject;
        }

        return false;
    }

    public function hardReset($dirtyObject)
    {
        $workbenchObject = new \ReflectionClass($dirtyObject);
        $workbenchProperties = $workbenchObject->getProperties(
            \ReflectionProperty::IS_PUBLIC |
            \ReflectionProperty::IS_PROTECTED |
            \ReflectionProperty::IS_PRIVATE
        );

        $originalObject = unserialize($this->keeper);
        $blueprintObject = new \ReflectionClass($originalObject);
        $blueprintObjectProperties = $blueprintObject->getProperties(
            \ReflectionProperty::IS_PUBLIC |
            \ReflectionProperty::IS_PROTECTED |
            \ReflectionProperty::IS_PRIVATE
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

    public function softReset($dirtyObject)
    {
        $originalObject = unserialize($this->keeper);
        $blueprintObject = new \ReflectionClass($originalObject);
        $blueprintObjectProperties = $blueprintObject->getProperties(
            \ReflectionProperty::IS_PUBLIC |
            \ReflectionProperty::IS_PROTECTED |
            \ReflectionProperty::IS_PRIVATE
        );

        foreach ($blueprintObjectProperties as $blueprintPropertyKey => $blueprintProperty) {

            $dirtyObjectSetMethod = 'set' . ucfirst($blueprintProperty->getName());
            if (is_callable(array($dirtyObject, $dirtyObjectSetMethod))) {
                $blueprintProperty->setAccessible(true);
                $dirtyObject->$dirtyObjectSetMethod($blueprintProperty->getValue($originalObject));
            }
        }
    }

    public function manualReset($dirtyObject)
    {
        $originalObject = unserialize($this->keeper);

        // Reset dirty object.
        $dirtyObject->setAge($originalObject->getAge());
        $dirtyObject->setFullName($originalObject->getFullName());

        return $dirtyObject;
    }
}
