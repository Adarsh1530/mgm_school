const fs = require('fs');

let config = fs.readFileSync('config/config.php', 'utf8');
const target = `define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mgm_school');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');`;

const replacement = `define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'mgm_school');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');`;

config = config.replace(/\r\n/g, '\n').replace(target, replacement);
fs.writeFileSync('config/config.php', config);
console.log('Updated config/config.php');

// Also update config/database.php for port and SSL support
let dbCode = fs.readFileSync('config/database.php', 'utf8');
const oldDsn = `$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;`;
const newDsn = `$port = defined('DB_PORT') ? DB_PORT : '3306';
            $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;`;

dbCode = dbCode.replace(/\r\n/g, '\n').replace(oldDsn, newDsn);
fs.writeFileSync('config/database.php', dbCode);
console.log('Updated config/database.php');
