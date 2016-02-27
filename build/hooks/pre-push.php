#!/usr/bin/env php
<?php

echo 'Checking Push ...' . PHP_EOL;

echo 'Running Unit Tests...' . PHP_EOL;
exec('vendor/bin/phpunit -c tests/phpunit.xml', $testResults, $unitTests);

if ($unitTests !== 0) {

    $testOutput .= array_pop($testResults);
    $testOutput = array_pop($testResults) . PHP_EOL . $testOutput;

    echo $testOutput . PHP_EOL;
    echo "Did you break a Unit Test?" . PHP_EOL;
    print "Aborting" . PHP_EOL;
    exit(1);
}

echo 'Running Code Linter...' . PHP_EOL;
exec('php build/scripts/linter.php', $linterResults, $linter);

if ($linter !== 0) {

    $linterOutput .= array_pop($linterResults);
    $linterOutput = array_pop($linterResults) . PHP_EOL . $linterOutput;

    echo $linterOutput . PHP_EOL;
    echo "Did you break a file?" . PHP_EOL;
    print "Aborting" . PHP_EOL;
    exit(1);
}

exit(0);
