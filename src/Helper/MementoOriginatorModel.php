<?php

namespace Helper;

class MementoOriginatorModel
{
    private $fullName;
    private $age;
    private $dateOfBirth;
    private $address;
    private $content;

    public function __construct()
    {
        $this->setFullName('Starting State');
        $this->setAge(28);
        $this->setDateOfBirth('2015-01-20');
        $this->setAddress('Kanaalweg 29');

        $content = new \Model\Content();
        $content->setDescription('First test');
        $this->setContent($content);
    }

    public function setMemento()
    {
        return new Memento($this);
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
