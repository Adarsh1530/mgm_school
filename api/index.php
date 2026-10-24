<?php
/**
 * Vercel Serverless Function Entry Point
 * MGM Model School
 */

// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Ensure session directory is writable in serverless environment
if (is_dir('/tmp') && is_writable('/tmp')) {
    @ini_set('session.save_path', '/tmp');
}

// Catch any fatal errors that bypass standard try-catch
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');
        echo "<h1>MGM Model School - Execution Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . " on line " . $error['line'] . "</p>";
    }
});

try {
    // Set working directory to project root so all relative paths resolve seamlessly
    chdir(__DIR__ . '/..');

    // Hand over execution to the main front controller
    require __DIR__ . '/../index.php';
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h1>MGM Model School - Serverless Exception</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
