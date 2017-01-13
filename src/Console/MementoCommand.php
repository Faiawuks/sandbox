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
            ->setName('sandbox:memento');
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

        $this->output->writeln('Original property value on object is: ' . $mementoOriginatorModel->getAge());
        $this->output->writeln('<comment>Saving object state (memento)...</comment>');

        $memento = $mementoOriginatorModel->setMemento();

        sleep(2);
        $this->output->writeln('<comment>Setting new values on object...</comment>');

        sleep(1);
        $mementoOriginatorModel->setFullName('test123');
        $mementoOriginatorModel->setAge(30);

        $this->output->writeln('New property value object: ' . $mementoOriginatorModel->getAge());

        $newContent = new \Model\Content();
        $newContent->setDescription('Second test');
        $mementoOriginatorModel->setContent($newContent);

        sleep(3);
        $this->output->writeln('<comment>Use dirty check on memento...</comment>');
        sleep(1);
        if ($memento->isDirty($mementoOriginatorModel)) {
            $this->output->writeln('<fg=red>Object is dirty!</fg=red>');
        }

        sleep(1);
        $this->output->writeln('<comment>Restoring object...</comment>');

        $memento->hardReset($mementoOriginatorModel);

        $this->output->writeln('Original "age" value restored: ' . $mementoOriginatorModel->getAge());

        $this->writeEmpty();
        $this->output->writeln('<info>End testing Memento pattern</info>');
        $this->writeEmpty();
    }
}
