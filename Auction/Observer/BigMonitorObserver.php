<?php

namespace Auction\Observer;

use Auction\Model\Session;
use Auction\Session\NotifierService;

/**
 * A website observer can for example handle updates for a live monitor feed at the auction house location.
 */
class BigMonitorObserver implements ObserverInterface
{
    /**
     * @inheritdoc
     */
    public function update(NotifierService $sessionNotifier)
    {
        $session = $sessionNotifier->getSession();

        echo "[Monitor] Update in auction for item: " . $session->getItem()->getDescription() . "\n";

        if (Session::STATUS_DONE === $sessionNotifier->getSession()->getStatus()) {
            echo $sessionNotifier->getSession()->getBid()->getBidder()->getName() . " has bought the item for: '" . $session->getBid()->getAmount() . "'\n\n";
        } else {
            echo "Bid of '" . $session->getBid()->getAmount() . "' by: " . $session->getBid()->getBidder()->getName() . "\n\n";
        }
    }
}
