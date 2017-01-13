<?php

namespace Auction;

use Console\CommandService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AuctionCommand extends CommandService
{
    /** @var \Auction\SessionService */
    private $sessionService;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('sandbox:auction');
    }

    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->sessionService = $this->app['auction.session_service'];
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->writeEmpty();
        $this->output->write("<question>Sandboxing: " . $this->getName() . "</question>");
        $this->writeEmpty();

        $this->sandbox();
    }

    /**
     * Set up an auction session.
     */
    private function sandbox()
    {
        $this->writeEmpty();
        $this->output->writeln('<info>Commencing Auction.</info>');
        $this->writeEmpty();

        /** @var \Auction\SessionService $sessionService */

        $session = $this->sessionService->setUpRandomSession();

        $this->sessionService->runSession($session);

        $this->writeEmpty();
        $this->output->writeln('<info>Auction has ended.</info>');
        $this->writeEmpty();
    }
}
