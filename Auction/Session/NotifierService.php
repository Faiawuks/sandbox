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
     * Attacht observer to this subject.
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
     */
    public function detach(ObserverInterface $observer, $event)
    {
        $key = array_search($observer, $this->observers[$event]);
        if (false !== $key) {
            unset ($this->observers[$event][$key]);
        }
    }

    /**
     * Update session information, and notify events.
     *
     * @param Session $session
     */
    public function update(Session $session)
    {
        $this->session = $session;
        $this->notifyEvents();
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Determine subscribed events, and notify observers
     */
    private function notifyEvents()
    {
        if (Session::STATUS_DONE === $this->session->getStatus()) {
            $this->notify(static::EVENT_SESSION_RESULT);
        }

        $this->notify(static::EVENT_SESSION_LIVE);
    }

    /**
     * Notify all subscribed observers on their events.
     *
     * @param string $event
     */
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
