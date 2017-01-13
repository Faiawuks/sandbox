<?php

namespace Auction\Model;

class Bid
{
    /** @var int */
    private $id;

    /** @var int */
    private $amount;

    /** @var \Auction\Model\Bidder */
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
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \Auction\Model\Bidder
     */
    public function getBidder()
    {
        return $this->bidder;
    }

    /**
     * @param \Auction\Model\Bidder $bidder
     *
     * @return $this
     */
    public function setBidder($bidder)
    {
        $this->bidder = $bidder;

        return $this;
    }


}
