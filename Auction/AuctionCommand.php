<?php

namespace Auction;

use Console\CommandService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AuctionCommand extends CommandService
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName('auction');
    }

    /**
     * Execute command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
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

    private function sandbox()
    {
        $this->writeEmpty();
        $this->output->writeln('<info>Commencing Auction.</info>');
        $this->writeEmpty();



        $this->writeEmpty();
        $this->output->writeln('<info>Auction has ended.</info>');
        $this->writeEmpty();
    }
}
