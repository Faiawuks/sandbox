<?php

namespace Auction\Observer;

use Auction\Session\NotifierService;

/**
 * A website observer can for example handle updates for the auction house website.
 */
class WebsiteObserver implements ObserverInterface
{
    /**
     * {@inheritdoc}
     */
    public function update(NotifierService $sessionNotifier)
    {
        $session = $sessionNotifier->getSession();

        echo "[Website] Finished auction for item: " . $session->getItem()->getDescription() . "\n";
        echo $sessionNotifier->getSession()->getBid()->getBidder()->getName() . " has bought the item for: '" . $session->getBid()->getAmount() . "'\n\n";
    }
}
