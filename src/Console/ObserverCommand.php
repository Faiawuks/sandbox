<?php

namespace Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ObserverCommand extends CommandService
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName('observer');
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
        $this->output->writeln('<info>Begin testing Observer pattern</info>');
        $this->writeEmpty();

        $patternGossiper = new \Helper\ObserverSubject();
        $patternGossipFan = new \Helper\Observer();

        // Attach the 'update action' that is run when something is updated, to the observer.
        $patternGossiper->attach($patternGossipFan);

        $patternGossiper->updateFavorites('abstract factory, decorator, visitor');
        $patternGossiper->updateFavorites('abstract factory, observer, decorator');

        $patternGossiper->detach($patternGossipFan);

        $patternGossiper->updateFavorites('abstract factory, observer, paisley');

        $this->writeEmpty();
        $this->output->writeln('<info>End testing Observer pattern</info>');
        $this->writeEmpty();
    }
}
