<?php
/**
 * Script for starting a development server.
 */
chdir(__DIR__ . '/..');

$documentRoot = 'public/';
$domain = 'localhost:8888';

// Start up the built-in web server.
echo "Serving project on http://{$domain}...\n";
echo "Press Ctrl+C to stop.\n";
passthru(PHP_BINARY . " -S {$domain} -t {$documentRoot}");
