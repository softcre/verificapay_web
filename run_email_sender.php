<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$project_directory = __DIR__;
$index_file = $project_directory . DIRECTORY_SEPARATOR . 'index.php';

if (!is_file($index_file)) {
    fwrite(STDERR, "CodeIgniter index.php was not found in the project directory." . PHP_EOL);
    exit(1);
}

if (!function_exists('exec')) {
    fwrite(STDERR, "PHP exec() is disabled; run the CodeIgniter command directly." . PHP_EOL);
    exit(1);
}

if (!chdir($project_directory)) {
    fwrite(STDERR, "Unable to set the working directory to the project directory." . PHP_EOL);
    exit(1);
}

$php_binary = defined('PHP_BINARY') && PHP_BINARY !== '' ? PHP_BINARY : 'php';
$command = escapeshellarg($php_binary) . ' ' .
    escapeshellarg($index_file) .
    ' email_sender send_emails 2>&1';

exec($command, $output, $exit_code);

if ($output) {
    echo implode(PHP_EOL, $output) . PHP_EOL;
}

exit($exit_code);
