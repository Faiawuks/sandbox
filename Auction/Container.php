<?php

namespace Auction;

use Silex\Application;
use Silex\ServiceProviderInterface;

class Container implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['auction.console'] = function ($self) {
//            return new ($c['cookie_name']);
        };
    }

    public function boot(Application $app) {}
}
