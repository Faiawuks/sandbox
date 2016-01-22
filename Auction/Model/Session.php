<?php

namespace Auction\Model;

use Auction\Memento;

class Session
{
    /** @var string */
    const STATUS_IN_PROGRESS = 'in_progress';

    /** @var string */
    const STATUS_DONE = 'done';

    /** @var Item */
    private $item;

    /** @var Bid */
    private $bid;

    /** @var string */
    private $status;

    /**
     * @return Memento
     */
    public function setMemento()
    {
        return new Memento($this);
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Bid
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @param Bid $bid
     *
     * @return $this
     */
    public function setBid($bid)
    {
        $this->bid = $bid;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Session
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
