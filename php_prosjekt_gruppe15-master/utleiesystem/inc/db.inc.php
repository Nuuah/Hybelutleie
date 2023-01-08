<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hybelutleie');
$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
} catch (PDOException $e) {
    echo 'Error connecting to database: ' . $e->getMessage();
}
?>