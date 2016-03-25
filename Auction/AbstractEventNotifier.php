<?php

namespace Auction;

use Auction\Observer\ObserverInterface;

abstract class AbstractEventNotifier
{
    /** @var array */
    protected $observers = array();

    /**
     * Attach observer to this subject.
     *
     * @param ObserverInterface $observer
     * @param string            $event
     */
    public function attach(ObserverInterface $observer, $event)
    {
        $this->observers[$event][] = $observer;
    }

    /**
     * Detach observers on this subject.
     *
     * @param ObserverInterface $observer
     * @param string            $event
     */
    public function detach(ObserverInterface $observer, $event)
    {
        $key = array_search($observer, $this->observers[$event]);
        if (false !== $key) {
            unset ($this->observers[$event][$key]);
        }
    }
}
