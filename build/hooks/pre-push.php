<?php
declare(strict_types = 1);

require_once 'Command.php';

$lint = new Command\Command(
    'Code linting',
    'vendor/bin/parallel-lint',
    [
        'exclude' => 'vendor',
    ],
    [
        '.'
    ]
);
if (!$lint->execute()) {
    exit(1);
}

$unit = new Command\Command(
    'Unit Tests',
    'vendor/bin/phpunit',
    [
        'configuration' => 'tests/phpunit.xml',
    ]
);
if (!$unit->execute()) {
    exit(1);
}

$stan = new Command\Command(
    'PHP Stan',
    'vendor/bin/phpstan',
    [
        'no-progress' => null,
        'level'       => '4',
    ],
    [
        'analyse',
        'src',
    ]
);
if (!$stan->execute()) {
    exit(1);
}

$sniffer = new Command\Command(
    'PHP Code Sniffer',
    'vendor/bin/phpcs',
    [],
    [
        'src',
    ]
);
if (!$sniffer->execute()) {
    exit(1);
}

exit(0);
