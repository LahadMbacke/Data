<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

$ssl_options = array(
    PDO::MYSQL_ATTR_SSL_KEY => '/etc/mysql/certs/client-key.pem',
    PDO::MYSQL_ATTR_SSL_CERT => '/etc/mysql/certs/client-cert.pem',
    PDO::MYSQL_ATTR_SSL_CA => '/etc/mysql/certs/server-cert.pem',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $ssl_options);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully using SSL";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
