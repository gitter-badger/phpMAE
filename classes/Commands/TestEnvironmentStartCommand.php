<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */
 
namespace CloudObjects\PhpMAE\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cilex\Provider\Console\Command;
use CloudObjects\PhpMAE\TestEnvironmentManager;

class TestEnvironmentStartCommand extends Command {

    protected function configure() {
      $this->setName('testenv:start')
        ->setDescription('Starts a local test environment.')
        ->addOption('port', null, InputOption::VALUE_OPTIONAL, 'Use this port for test environment.', 9000)
        ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'Bind test environment to this host.', '127.0.0.1');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
      $port = $input->getOption('port');
      $host = $input->getOption('host');

      TestEnvironmentManager::setTestEnvironment('http://localhost:'.$port.'/');
      $dir = realpath(__DIR__."/../../web/");
      passthru('cd '.$dir.'; php -S '.$host.':'.$port.' index.php');
    }

}
