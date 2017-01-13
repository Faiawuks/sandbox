<?php

namespace Auction;

use Auction\Model\Bid;
use Auction\Model\Bidder;
use Auction\Model\Item;
use Auction\Model\Session;
use Auction\Observer\BigMonitorObserver;
use Auction\Observer\WebsiteObserver;
use Auction\Session\AuctioneerService;
use Auction\Session\NotifierService;

class SessionService
{
    /** @var AuctioneerService */
    private $sessionAuctioneer;

    /** @var BigMonitorObserver */
    private $bigMonitorObserver;

    /** @var WebsiteObserver */
    private $websiteObserver;

    /**
     * @param \Auction\Session\AuctioneerService $sessionAuctioneer
     * @param \Auction\Observer\BigMonitorObserver $bigMonitorObserver
     * @param \Auction\Observer\WebsiteObserver $websiteObserver
     */
    public function __construct(
        AuctioneerService $sessionAuctioneer,
        BigMonitorObserver $bigMonitorObserver,
        WebsiteObserver $websiteObserver
    ) {
        $this->sessionAuctioneer = $sessionAuctioneer;
        $this->bigMonitorObserver = $bigMonitorObserver;
        $this->websiteObserver = $websiteObserver;
    }

    /**
     * Set up an auction session.
     *
     * @return \Auction\Model\Session
     */
    public function setUpRandomSession()
    {
        $item = new Item();
        $item->setDescription('Chinese Vase');
        $item->setStartingBid(1000);

        $bid = new Bid();
        $bid->setAmount($item->getStartingBid());

        $session = new Session();
        $session->setItem($item);
        $session->setBid($bid);
        $session->setStatus(Session::STATUS_IN_PROGRESS);

        return $session;
    }

    /**
     * Run an auction flow.
     *
     * @param \Auction\Model\Session $session
     */
    public function runSession(Session $session)
    {
        $this->sessionAuctioneer->attachObserver($this->bigMonitorObserver, NotifierService::EVENT_SESSION_LIVE);
        $this->sessionAuctioneer->attachObserver($this->websiteObserver, NotifierService::EVENT_SESSION_RESULT);

        $bidder1 = new Bidder();
        $bidder1->setId(132);
        $bidder1->setName('Bidder 1');
        $bidder2 = new Bidder();
        $bidder2->setId(522);
        $bidder2->setName('Bidder 2');
        $bidder3 = new Bidder();
        $bidder3->setId(346);
        $bidder3->setName('Bidder 3');

        $bid1 = $this->sessionAuctioneer->placeBid($session, $bidder2, 2000);

        sleep(2);
        $bid2 = $this->sessionAuctioneer->placeBid($session, $bidder3, 3000);

        sleep(2);
        $bid3 = $this->sessionAuctioneer->placeBid($session, $bidder1, 4000);

        sleep(2);
        $bid4 = $this->sessionAuctioneer->placeBid($session, $bidder3, 5000);

        sleep(2);
        $this->sessionAuctioneer->withdrawBid($session, $bid1);
        $this->sessionAuctioneer->withdrawBid($session, $bid4);

        sleep(2);
        $this->sessionAuctioneer->completeBid($session);
    }
}
