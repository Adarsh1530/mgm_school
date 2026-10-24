<?php
/**
 * Vercel Serverless Function Entry Point
 * MGM Model School
 */

// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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
