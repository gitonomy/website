#!/usr/bin/env php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Buzz\Browser;
use Buzz\Client\Curl;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\CssSelector\CssSelector;

$console = new Application('ProjectName', '0.1');

$console->register( 'generate-changelog' )
    ->setDefinition(array(
        new InputOption('url', null, InputOption::VALUE_OPTIONAL, 'URL of markdown file'),
    ))
    ->setDescription('Generate the changelog page from a changelog markdown file')
    ->setHelp('Usage: <info>./console.php generate-changelog [--url=<file>]</info>')
    ->setCode(
        function(InputInterface $input, OutputInterface $output) {
            if (null === $url = $input->getOption('url')) {
                $url = 'http://github.com/gitonomy/gitonomy/raw/master/CHANGELOG.md';
            }

            $output->writeln(sprintf('Fetching "%s"...', $url));

            $client  = new Curl();
            $browser = new Browser($client);
            $browser->get($url);

            $output->writeln('Converting to xml...');

            $command = 'rst2xml --no-toc-backlinks --no-doc-title --no-generator --no-source-link --no-footnote-backlinks --strip-comments';

            $ioDescription = array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
            );

            $proc = proc_open($command, $ioDescription, $pipes, '/tmp', NULL);

            if (!is_resource($proc)) {
                throw new \LogicException('proc_open failed');
            }

            fwrite($pipes[0], $browser->getLastResponse()->getContent());
            fflush($pipes[0]);
            fclose($pipes[0]);

            $xml = stream_get_contents($pipes[1]);

            proc_close($proc);

            $document = new \DOMDocument('1.0', 'utf-8');
            $document->loadXML($xml);
            $xpath = new \DOMXPath($document);

            $versions = array();
            $nodes = $xpath->query(CssSelector::toXPath('document > bullet_list > list_item'));

            $lastChange = null;

            foreach ($nodes as $node) {
                $version = $node->getElementsByTagName('paragraph')->item(0)->textContent;
                preg_match('#(?P<version>[^/]+) \((?P<date>[0-9]{4}-[0-9]{2}-[0-9]{2})\)#', $version, $versionData);

                $versionDetails = array(
                    'version'  => $versionData['version'],
                    'date'     => $versionData['date'],
                    'features' => array(),
                );

                if (null === $lastChange) {
                    $lastChange = array(
                        'version'  => $versionData['version'],
                        'date'     => $versionData['date'],
                    );
                }

                foreach ($node->getElementsByTagName('list_item') as $childNode) {
                    $feature = $childNode->getElementsByTagName('paragraph')->item(0)->textContent;
                    preg_match('#(?P<level>\w+) (?P<feature>\w+)#', $feature, $featureData);

                    $featureDetails = array(
                        'level'   => $featureData['level'],
                        'feature' => $featureData['feature'],
                    );

                    array_push($versionDetails['features'], $featureDetails);
                }

                array_push($versions, $versionDetails);
            }

            $output->writeln('Generating cache...');

            file_put_contents(__DIR__.'/cache/changelog.json', json_encode($versions));
        }
    );

$console->run();
