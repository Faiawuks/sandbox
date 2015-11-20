<?php

namespace Console;

use Knp\Command\Command;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Helper class for console commands for the LiveBible bundles.
 */
abstract class CommandService extends Command
{
    /** @var \Silex\Application */
    protected $app;

    /** @var \Symfony\Component\Console\Input\InputInterface */
    protected $input;

    /** @var \Symfony\Component\Console\Output\OutputInterface */
    protected $output;

    /**
     * Constructor.
     *
     * @param \Silex\Application $app
     */
    public function __construct($app)
    {
        parent::__construct();

        $this->app = $app;
    }

    /**
     * Get the applications default table style.
     *
     * @return \Symfony\Component\Console\Helper\TableStyle
     */
    protected function getDefaultTableStyle()
    {
        $style = new TableStyle();
        $style
            ->setHorizontalBorderChar('-')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar(' ');

        return $style;
    }

    /**
     * Output empty line.
     *
     * @param int $number
     */
    protected function writeEmpty($number = 1)
    {
        for ($i = 1; $i <= $number; $i++) {
            $this->output->writeln("");
        }
    }

    /**
     * Clear the screen.
     */
    protected function clear()
    {
        system('clear');
    }

    /**
     * Ask user input on the Translation (short) Indicator.
     *
     * @param string $input
     *
     * @return string
     */
    protected function defaultInputQuestion($input)
    {
        $helper = $this->getHelper('question');
        $question = new Question($input . ': ');
        $value = $helper->ask($this->input, $this->output, $question);

        if (empty($value)) {
            $value = $this->defaultInputQuestion($input);
        }

        return $value;
    }

    /**
     * A default confirmation question.
     *
     * @param string $question
     * @param bool   $defaultChoice
     *
     * @return bool
     */
    protected function defaultConfirmationQuestion($question, $defaultChoice = false)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion($question, $defaultChoice);

        if (false === $helper->ask($this->input, $this->output, $question)) {
            return false;
        }
        return true;
    }
}