<?php
/**
 * Multi-Threaded Linter for the Enterprise codebase.
 *
 * Validates all files for syntax errors, including Composer dependencies. Exits with a summary to stdout and an error
 *  code if any errors are found.
 *
 * This should be added to the build process after Composer resolves it's dependencies. At the time of inception, this
 *  took ~8s to run for our code, and ~33s to run including dependencies.
 *
 * The exclusions list below should only be used in circumstances where a parsing error is unavoidable. The examples
 *  that currently exist are either a result of libraries starting work on a phpNext upgrade, or deliberately having
 *  parse errors in their code for tests.
 */
$exclusions = array(
    // @todo These files use PHP7 anonymous classes. Remove when we upgrade.
    './vendor/phpunit/php-token-stream/tests/_fixture/class_with_method_that_declares_anonymous_class.php',
    './vendor/phpunit/php-token-stream/tests/_fixture/class_with_method_that_declares_anonymous_class2.php',
);

// Determine the number of parallel processes requested. Defaults to 8.
$processLimit = (int) (empty($argv[1]) ? 0 : $argv[1]);
$processLimit = ($processLimit < 1) ? 8 : $processLimit;

// Bootstrap the script.
chdir(__DIR__ . '/../..');
$start = gettimeofday(true);

// Pull a list of files to lint.
exec("find . -type f \\( -iname '*.php' -o -iname '*.phtml' -o -iname '*.inc' \\)", $files);
echo "Linting " . count($files) . " file(s) using {$processLimit} thread(s):\n";

// Keep going while files are either waiting, or processing.
$processing = array();
$errors = array();
while ($files || $processing) {

    // If a file is waiting, get it processing.
    if ($files) {
        $file = array_shift($files);
        if (in_array($file, $exclusions)) {
            continue; // If a file is excluded, move onto the next file.
        }

        // Open another process running PHP's linter on this file, and store the handle.
        $processing[] = popen("php -l -n -d error_reporting=E_ALL -d short_open_tags=1 {$file} 2>&1", 'r');

        if (count($processing) < $processLimit) {
            continue; // Keep queueing files until we hit the process limit.
        }
    }

    // If files are processing, process the first file's output.
    if ($processing) {
        $linter = array_shift($processing);

        // Read the output of the process, and close it.
        $output = '';
        while (!feof($linter)) {
            $output .= fgets($linter, 1024);
        }
        $result = pclose($linter);
        dot();

        if ($result === 0) {
            continue; // No errors? Loop round and start another file.
        }

        // Log the details of any error, then loop and start another file.
        preg_match('/(.+) in .\/(.+) on line (.+)/', $output, $matches);
        $errors[] = array_slice($matches, 1);
    }
}
echo "\n\n";

// Output a summary of the linting.
if ($errors) {
    foreach ($errors as $error) {
        echo "  {$error[0]}\n  {$error[1]}:{$error[2]}\n\n";
    }
    echo "Found " . count($errors) . " error(s).\n";
} else {
    echo "No errors.\n";
}
echo 'Completed in ' . round(gettimeofday(true) - $start, 1) . "s.\n";

// If any errors were found, exit with a foul code.
if ($errors) {
    exit(255); // Failure exit-point.
}
// Success exit-point.


/**
 * Outputs a dot to stdout every 20 calls, summarises every 1000 calls.
 */
function dot()
{
    static $i;
    if (++$i % 20 === 0) {
        echo '.';
        if ($i % 1000 === 0) {
            echo " [{$i}]\n";
        }
    }
}
