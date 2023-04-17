<?php
$servername = "192.168.100.103";
$username = "group1-0";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$image_path = '/var/www/html/ttt/2.png';
$image_data = file_get_contents($image_path);

try {
    $sql = "INSERT INTO Avatar (picavatar) VALUES (:picavatar)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':picavatar', $image_data, PDO::PARAM_LOB);
    $stmt->execute();
    echo "Image inserted successfully";
} catch(PDOException $e) {
    echo "Error inserting image: " . $e->getMessage();
}
?>
