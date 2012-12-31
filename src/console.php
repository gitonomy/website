<?php

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$app = new Gitonomy\Application();
$console = new ConsoleApplication('Gitonomy Website', '0.1');

$console->register('generate:changelog')
    ->setDescription('Generate the changelog page from a changelog markdown file')
    ->setHelp('Usage: <info>./console.php generate-changelog</info>')
    ->setCode(
        function(InputInterface $input, OutputInterface $output) use ($app) {
            $changelog = $app['gitonomy.changelog.cache']->refresh();

            $output->writeln(sprintf("<info>Changelog</info> refreshed. Last version: <info>%s</info>", $changelog->getLastStableVersion()->getVersion()));
        }
    )
;
