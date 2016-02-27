#!/usr/bin/env php
<?php
$commitMessage =  file_get_contents($argv[1]);

if(strlen($commitMessage) <= 5) {
    echo PHP_EOL;
    echo $commitMessage . PHP_EOL;
    echo "Your commit message must be greater than 5 characters." . PHP_EOL;
    exit(1);
}

exit(0);
