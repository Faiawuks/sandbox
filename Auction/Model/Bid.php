<?php

namespace Auction\Model;

class Bid
{
    /** @var int */
    private $id;

    /** @var int */
    private $amount;

    /** @var Bidder */
    private $bidder;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Session
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Bidder
     */
    public function getBidder()
    {
        return $this->bidder;
    }

    /**
     * @param Bidder $bidder
     *
     * @return Session
     */
    public function setBidder($bidder)
    {
        $this->bidder = $bidder;

        return $this;
    }


}
