<?php

namespace Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MementoCommand extends CommandService
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName('memento');
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
        $this->output->writeln('<info>Begin testing Memento pattern</info>');
        $this->writeEmpty();

        $mementoOriginatorModel = new \Helper\MementoOriginatorModel();

        $this->output->writeln('<comment>Setting memento...</comment>');
        $this->writeEmpty();

        $mementoOriginatorModel->setMemento();
        $originalModel = $mementoOriginatorModel->getMemento();

        $this->output->writeln('Old "age" value was: ' . $originalModel->getAge());

        $this->output->writeln('<comment>Setting new values...</comment>');

        $mementoOriginatorModel->setFullName('test123');
        $mementoOriginatorModel->setAge(30);

        $this->output->writeln('Set new "age" value: ' . $mementoOriginatorModel->getAge());

        $newTreatment = new \Model\Treatment();
        $newTreatment->setDescription('Second test');
        $mementoOriginatorModel->setTreatment($newTreatment);

        if ($mementoOriginatorModel->isDirty()) {
            $this->writeEmpty();
            $this->output->writeln('<fg=red>Object is dirty!</fg=red>');
        }

        $this->writeEmpty();
        $this->output->writeln('<comment>Restoring model...</comment>');

        $mementoOriginatorModel->resetMemento();

        $this->output->writeln('Original "age" value restored: ' . $mementoOriginatorModel->getAge());

        $this->writeEmpty();
        $this->output->writeln('<info>End testing Memento pattern</info>');
        $this->writeEmpty();
    }
}
