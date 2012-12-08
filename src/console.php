<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Gitonomy\ChangeLog\ChangeLogFactory;

$console = new Application('Gitonomy Website', '0.1');

$console->register( 'generate:changelog' )
    ->setDefinition(array(
        new InputOption('url', null, InputOption::VALUE_OPTIONAL, 'URL of markdown file'),
    ))
    ->setDescription('Generate the changelog page from a changelog markdown file')
    ->setHelp('Usage: <info>./console.php generate-changelog [--url=<file>]</info>')
    ->setCode(
        function(InputInterface $input, OutputInterface $output) {
            $url = $input->getOption('url');

            $changeLog = ChangeLogFactory::createFromGithub($url);
            $json = ChangeLogFactory::toJson($changeLog);
            file_put_contents(__DIR__.'/../cache/changelog.json', $json);
        }
    )
;
