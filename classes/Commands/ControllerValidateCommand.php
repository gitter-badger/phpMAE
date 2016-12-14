<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */
 
namespace CloudObjects\PhpMAE\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CloudObjects\PhpMAE\ClassValidator;

class ControllerValidateCommand extends AbstractObjectCommand {

  protected function configure() {
    $this->setName('controller:validate')
      ->setDescription('Validates a controller class for the phpMAE.')
      ->addArgument('coid', InputArgument::REQUIRED, 'The COID of the object.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->parse($input->getArgument('coid'));
    $this->assertRDF();
    if (!in_array('coid://phpmae.cloudobjects.io/ControllerClass', $this->rdfTypes))
      throw new \Exception("Object is not a controller.");
    $this->assertPHPExists();

    // Running validator
    $validator = new ClassValidator();
    $validator->validateAsController(file_get_contents($this->fullName.'.php'));
    $output->writeln("Validated successfully.");
  }

}
