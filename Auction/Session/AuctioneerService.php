<?php

namespace Auction\Session;

use Auction\Memento;
use Auction\Model\Bidder;
use Auction\Model\Bid;
use Auction\Model\Session;
use Auction\Observer\ObserverInterface;

/**
 * An actioneer manages the session.
 */
class AuctioneerService
{
    /** @var \Auction\Session\NotifierService */
    private $sessionNotifier;

    /** @var Memento[] */
    private $sessionHistory;

    /**
     * @param \Auction\Session\NotifierService $sessionNotifier
     */
    public function __construct(NotifierService $sessionNotifier)
    {
        $this->sessionNotifier = $sessionNotifier;
    }

    /**
     * Attach observer to the notifier (observer subject).
     *
     * @param \Auction\Observer\ObserverInterface $observer
     * @param string $event
     */
    public function attachObserver(ObserverInterface $observer, $event)
    {
        $this->sessionNotifier->attach($observer, $event);
    }

    /**
     * Receive bidding information.
     *
     * @param \Auction\Model\Session $session
     * @param \Auction\Model\Bidder $bidder
     * @param int $amount
     *
     * @return \Auction\Model\Bid
     */
    public function placeBid(Session $session, Bidder $bidder, $amount)
    {
        $bid = new Bid();
        $newBidId = count($this->sessionHistory) + 1;
        $bid->setId($newBidId);
        $bid->setAmount($amount);
        $bid->setBidder($bidder);

        $session->setBid($bid);

        $this->sessionHistory[$newBidId] = $session->setMemento();
        $this->sessionNotifier->update($session);

        return $bid;
    }

    /**
     * @param \Auction\Model\Session $session
     * @param \Auction\Model\Bid $bidToWithdraw
     */
    public function withdrawBid(Session $session, Bid $bidToWithdraw)
    {
        $bidToWithdrawId = $bidToWithdraw->getId();
        $mostRecentBid = $this->getMostRecentBid();

        // Bidder withdraws, remove from session.
        unset($this->sessionHistory[$bidToWithdrawId]);

        if ($mostRecentBid->getId() === $bidToWithdrawId) {
            // Most recent bid was withdrawn, reset current session pointer to session before most recent.
            $newMostRecentBid = $bidToWithdrawId - 1;
            if (array_key_exists($newMostRecentBid, $this->sessionHistory)) {
                $newMostRecentSessionAction = $this->sessionHistory[$newMostRecentBid];
                $newMostRecentSessionAction->reset($session);
            }

            $this->sessionNotifier->update($session);
        }
    }

    /**
     * Complete/finish bidding for a session.
     *
     * @param \Auction\Model\Session $session
     */
    public function completeBid(Session $session)
    {
        $session->setStatus(Session::STATUS_DONE);
        $this->sessionNotifier->update($session);
    }

    /**
     * @return \Auction\Model\Bid
     */
    private function getMostRecentBid()
    {
        /** @var \Auction\Memento $latestChangeInSession */
        $latestChangeInSession = end($this->sessionHistory);
        /** @var $latestChangeInSessionContent \Auction\Model\Session */
        $latestChangeInSessionContent = $latestChangeInSession->getContent();

        return $latestChangeInSessionContent->getBid();
    }
}
