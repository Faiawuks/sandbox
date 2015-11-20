<?php

namespace Helper;

class MementoOriginatorModel
{
    private $memento;

    private $fullName;
    private $age;
    private $dateOfBirth;
    private $address;
    private $treatment;

    public function __construct()
    {
        $this->setFullName('Starting State');
        $this->setAge(28);
        $this->setDateOfBirth('2015-01-20');
        $this->setAddress('Kanaalweg 29');

        $treatment = new \Model\Treatment();
        $treatment->setDescription('First test');
        $this->setTreatment($treatment);
    }

    public function isDirty()
    {
        if (null !== $this->memento) {
            $memento = $this->memento->get();
            $freezedMemento = $this->memento;
            $this->memento = null;

            $isDirty = $memento != $this;
            $this->memento = $freezedMemento;

            return $isDirty;
        }

        return false;
    }

    public function setMemento()
    {
        $this->memento = new Memento($this);
    }

    public function getMemento()
    {
        if (null !== $this->memento) {
            return $this->memento->get();
        }

        return null;
    }

    public function resetMemento()
    {
        $this->memento->resetBreakEncapsulation($this);
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getTreatment()
    {
        return $this->treatment;
    }

    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;
    }
}
