<?php

namespace Auction;

use Auction\Observer\BigMonitorObserver;
use Auction\Observer\WebsiteObserver;
use Auction\Session\AuctioneerService;
use Auction\Session\NotifierService;
use Silex\Application;
use Silex\ServiceProviderInterface;

class Container implements ServiceProviderInterface
{
    /**
     * Register services in application container.
     *
     * @param \Silex\Application $app
     */
    public function register(Application $app)
    {
        $app['auction.observer.big_monitor_observer'] = function ($self) {
            return new BigMonitorObserver();
        };

        $app['auction.observer.website_observer'] = function ($self) {
            return new WebsiteObserver();
        };

        $app['auction.session.notifier_service'] = function ($self) {
            return new NotifierService();
        };

        $app['auction.session.auctioneer_service'] = function ($self) {
            return new AuctioneerService(
                $self['auction.session.notifier_service']
            );
        };

        $app['auction.session_service'] = function ($self) {
            return new SessionService(
                $self['auction.session.auctioneer_service'],
                $self['auction.observer.big_monitor_observer'],
                $self['auction.observer.website_observer']
            );
        };
    }

    /**
     * @inheritdoc
     */
    public function boot(Application $app) {}
}
