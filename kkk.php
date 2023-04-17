<?php
$servername = "192.168.100.103";
$username = "group1-0";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

$ssl_key = '/etc/mysql/ssl/server-key.pem';
$ssl_cert = '/etc/mysql/ssl/server-cert.pem';
$ssl_ca = '/etc/mysql/ssl/ca-cert.pem';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(
        PDO::MYSQL_ATTR_SSL_KEY => $ssl_key,
        PDO::MYSQL_ATTR_SSL_CERT => $ssl_cert,
        PDO::MYSQL_ATTR_SSL_CA => $ssl_ca,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => 1
    ));

    echo "Connexion réussie avec SSL !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
