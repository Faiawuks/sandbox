<?php

namespace Auction\Model;

class Item
{
    /** @var string */
    private $description;

    /** @var int */
    private $startingBid;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartingBid()
    {
        return $this->startingBid;
    }

    /**
     * @param int $startingBid
     *
     * @return $this
     */
    public function setStartingBid($startingBid)
    {
        $this->startingBid = $startingBid;

        return $this;
    }


}
