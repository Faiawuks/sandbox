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
            return null;
        }

        $this->keeper = serialize($object);
    }

    public function get()
    {
        return unserialize($this->keeper);
    }

    public function resetBreakEncapsulation($dirtyObject)
    {
        $workbenchObject = new \ReflectionClass($dirtyObject);
        $workbenchProperties = $workbenchObject->getProperties(
            \ReflectionProperty::IS_PUBLIC |
            \ReflectionProperty::IS_PROTECTED |
            \ReflectionProperty::IS_PRIVATE
        );

        $originalObject = $this->get();
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

    public function resetWithEncapsulation($dirtyObject)
    {
        $originalObject = $this->get();
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

    public function resetOriginal($dirtyObject)
    {
        $originalObject = $this->get();

        // Reset dirty object.
        $dirtyObject->setAge($originalObject->getAge());
        $dirtyObject->setFullName($originalObject->getFullName());

        return $dirtyObject;
    }
}
