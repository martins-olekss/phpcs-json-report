<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CodeSnifferCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:run';

    protected function configure()
    {
        $this
            ->setDescription('Run test.')
            ->setHelp('This command runs Code Sniffer inspection');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Whoa!');

        return 1;
    }
}