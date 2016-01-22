<?php

namespace Auction\Session;

use Auction\Model\Session;
use Auction\Observer\ObserverInterface;

/**
 * This class behaves as the Observer Subject.
 */
class NotifierService
{
    /** @var string */
    const EVENT_SESSION_RESULT = 'auction.result';

    /** @var string */
    const EVENT_SESSION_LIVE = 'auction.live';

    /** @var ObserverInterface[] */
    private $observers = array();

    /** @var Session */
    private $session;

    /**
     * @param ObserverInterface $observer
     * @param string                     $event
     */
    public function attach(ObserverInterface $observer, $event)
    {
        $this->observers[$event][] = $observer;
    }

    /**
     * @param ObserverInterface $observer
     */
    public function detach(ObserverInterface $observer)
    {
        $key = array_search($observer, $this->observers);
        if (false !== $key) {
            unset ($this->observers[$key]);
        }
    }

    public function update(Session $session)
    {
        $this->session = $session;
        $this->notifyEvents();
    }

    public function getSession()
    {
        return $this->session;
    }

    private function notifyEvents()
    {
        if (Session::STATUS_DONE === $this->session->getStatus()) {
            $this->notify(static::EVENT_SESSION_RESULT);
        }

        $this->notify(static::EVENT_SESSION_LIVE);
    }

    private function notify($event)
    {
        if (!array_key_exists($event, $this->observers)) {
            return;
        }

        /** @var ObserverInterface $observer */
        foreach($this->observers[$event] as $observer) {
            $observer->update($this);
        }
    }
}
