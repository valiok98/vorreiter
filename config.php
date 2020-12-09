<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user "root" with no password) */
define("DB_SERVER", "127.0.0.1:3306");
define("DB_USERNAME", "web154_7");
define("DB_PASSWORD", "bFNRWgX8Qld42SvI");
define("DB_NAME", "web154_db7");
require_once dirname(__FILE__) . "/definitions.php";

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
