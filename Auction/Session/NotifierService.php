<?php

namespace Auction\Session;

use Auction\AbstractEventNotifier;
use Auction\Model\Session;

/**
 * This class behaves as the Observer Subject.
 */
class NotifierService extends AbstractEventNotifier
{
    /** @var string */
    const EVENT_SESSION_RESULT = 'auction.result';

    /** @var string */
    const EVENT_SESSION_LIVE = 'auction.live';

    /** @var Session */
    private $session;

    /**
     * Update session information, and notify events.
     *
     * @param \Auction\Model\Session $session
     */
    public function update(Session $session)
    {
        $this->session = $session;
        $this->notifyEvents();
    }

    /**
     * @return \Auction\Model\Session
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

        /** @var \Auction\Observer\ObserverInterface $observer */
        foreach($this->observers[$event] as $observer) {
            $observer->update($this);
        }
    }
}
