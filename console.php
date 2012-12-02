#!/usr/bin/env php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application('ProjectName', '0.1');

$console->register( 'sync' )
    ->setDefinition(array(
        new InputOption('test', '', InputOption::VALUE_NONE, 'Test mode'),
    ))
    ->setDescription('Synchronize with an external data source')
    ->setHelp('Usage: <info>./console.php sync [--test]</info>')
    ->setCode(
    function(InputInterface $input, OutputInterface $output) {
        if ($input->getOption('test')) {
            $output->write("\n\tTest Mode Enabled\n\n");
        }

        $output->write( "Contacting external data source ...\n");
    }
);

$console->run();
