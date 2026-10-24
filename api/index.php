<?php
/**
 * Vercel Serverless Function Entry Point
 * MGM Model School
 */

// Set working directory to project root so all relative paths resolve seamlessly
chdir(__DIR__ . '/..');

// Hand over execution to the main front controller
require __DIR__ . '/../index.php';
