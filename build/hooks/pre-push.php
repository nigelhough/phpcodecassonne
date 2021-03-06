<?php
declare(strict_types = 1);

echo 'Checking Push ...' . PHP_EOL;

if (!executeCheck('Code linting', 'vendor/bin/parallel-lint --exclude vendor .')) {
    exit;
}
if (!executeCheck('Unit Tests', 'vendor/bin/phpunit -c tests/phpunit.xml --coverage-html tests/coverage')) {
    exit;
}
if (!executeCheck('PHP Stan', 'vendor/bin/phpstan analyse src --no-progress --level=4')) {
    exit;
}
if (!executeCheck('PHP Code Sniffer', 'vendor/bin/phpcs src')) {
    exit;
}

/**
 * Execute a command that runs a check on the codebase
 *
 * @param string $checkName    Name of the check on the codebase
 * @param string $checkCommand Command to run the check
 *
 * @return bool Has passed check?
 */
function executeCheck($checkName, $checkCommand)
{
    echo "Running {$checkName}...\n";
    exec($checkCommand, $checkOutput, $result);

    if ($result !== 0) {
        // Convert check out into readable summary format
        $output = array_pop($checkOutput);
        $output = array_pop($checkOutput) . "\n{$output}\n";
        echo "{$output}Did you break something?\nAborting\n";
        return false;
    }
    echo "{$checkName} Passed!\n";
    return true;
}

exit(0);
