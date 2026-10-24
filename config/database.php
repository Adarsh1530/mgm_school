<?php
/**
 * Database Connection (PDO)
 * MGM Model School Recreation Project - Hybrid MySQL & Zero-Config SQLite Fallback
 */

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            // 1. Try MySQL if DB_HOST is set and reachable
            $mysqlHost = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
            $mysqlPort = defined('DB_PORT') ? DB_PORT : '3306';
            $mysqlDb   = defined('DB_NAME') ? DB_NAME : 'mgm_school';
            $mysqlUser = defined('DB_USER') ? DB_USER : 'root';
            $mysqlPass = defined('DB_PASS') ? DB_PASS : '';
            $mysqlCharset = defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4';

            // Only attempt MySQL if not running in standalone serverless / zero-db mode
            if ($mysqlHost !== 'none' && !getenv('FORCE_SQLITE')) {
                try {
                    $dsn = "mysql:host={$mysqlHost};port={$mysqlPort};dbname={$mysqlDb};charset={$mysqlCharset}";
                    $mysqlOptions = $options;
                    $mysqlOptions[PDO::ATTR_TIMEOUT] = 2; // Fast timeout so serverless doesn't stall
                    self::$instance = new PDO($dsn, $mysqlUser, $mysqlPass, $mysqlOptions);
                    return self::$instance;
                } catch (Throwable $e) {
                    error_log("MySQL connection unavailable (" . $e->getMessage() . "). Falling back to embedded SQLite.");
                }
            }

            // 2. Seamless Fallback: Embedded SQLite Database (No external server needed)
            $sqlitePath = __DIR__ . '/../database/mgm_school.sqlite';
            // In serverless environments (e.g. Vercel), project files are read-only.
            // Copy to /tmp if running in serverless to ensure write & journal locks work cleanly.
            if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
                $tmpSqlite = '/tmp/mgm_school.sqlite';
                if (!file_exists($tmpSqlite) && file_exists($sqlitePath)) {
                    @copy($sqlitePath, $tmpSqlite);
                }
                if (file_exists($tmpSqlite)) {
                    $sqlitePath = $tmpSqlite;
                }
            }
            if (file_exists($sqlitePath)) {
                try {
                    self::$instance = new PDO("sqlite:" . $sqlitePath, null, null, $options);
                    return self::$instance;
                } catch (Throwable $e) {
                    error_log("SQLite connection error: " . $e->getMessage());
                }
            }

            // 3. Fallback in-memory PDO if all else fails to prevent fatal crashes
            self::$instance = new PDO("sqlite::memory:", null, null, $options);
        }
        return self::$instance;
    }
}

function getDB(): PDO {
    return Database::getConnection();
}
