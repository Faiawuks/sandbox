<?php

namespace Auction\Observer;

use Auction\Session\NotifierService;

interface ObserverInterface
{
    /**
     * Called when a notification has been sent.
     *
     * @param NotifierService $sessionNotifier
     */
    public function update(NotifierService $sessionNotifier);
}
