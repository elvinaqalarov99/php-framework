<?php

namespace App\Console\Commands\BoredAPI;

use Symfony\Component\Console\{Command\Command, Input\InputInterface, Input\InputOption, Output\OutputInterface};
use App\Services\API\BoredAPIService;

class PublicActivityCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('public-activity')
            ->setDescription('Prints public random activity from BoredAPI!')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addOption('participants', 'p', InputOption::VALUE_REQUIRED, 'Pass the activity participants.')
            ->addOption('type', 't', InputOption::VALUE_OPTIONAL, 'Pass the activity type.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getOption('type') ?? '';
        $participants = max((int)$input->getOption('participants'), 2);

        $activity = (new BoredAPIService)->participants($participants)->type($type)->send();

        $output->writeln($activity);

        return 0;
    }
}