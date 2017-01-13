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

    /** @var \Auction\Model\Bid */
    private $bid;

    /** @var string */
    private $status;

    /**
     * @return \Auction\Memento
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
     * @param \Auction\Model\Item $item
     *
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return \Auction\Model\Bid
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @param \Auction\Model\Bid $bid
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
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
