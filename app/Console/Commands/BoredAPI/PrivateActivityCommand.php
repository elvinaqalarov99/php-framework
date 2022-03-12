<?php

namespace App\Console\Commands\BoredAPI;

use Symfony\Component\Console\{Command\Command, Input\InputInterface, Input\InputOption, Output\OutputInterface};
use App\Services\API\BoredAPIService;

class PrivateActivityCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('private-activity')
            ->setDescription('Prints private random activity from BoredAPI!')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addOption(
                'type',
                't',
                InputOption::VALUE_OPTIONAL,
                'Pass the activity type.',
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getOption('type') ?? '';

        $activity = (new BoredAPIService)->type($type)->send();

        $output->writeln($activity);

        return 0;
    }
}