<?php namespace GitS3\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends Command {

    protected function configure() {
        $this->setName('deploy');
        $this->setDescription('Deploy the current git repo');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeLn('Deployment goes here!');
    }
}