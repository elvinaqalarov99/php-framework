<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('example')
            ->setDescription('example description')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addOption(
                'example',
                'e',
                InputOption::VALUE_OPTIONAL,
                'example description',
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $option = $input->getOption('example') ?? '';

        return 0;
    }

}