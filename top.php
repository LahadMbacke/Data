<?php
// Remplacez ces informations par vos propres informations de connexion à la base de données
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

   header('Content-type: image/png');
  $image_path = "/var/www/html/ttt/1.png";
  $image_data = file_get_contents($image_path);
// echo $image_data;
    $stmt = $pdo->prepare("INSERT INTO Avatar (picavatar) VALUES (:picavatar)");
    $stmt->bindParam(':picavatar', $image_data, PDO::PARAM_LOB);
    $stmt->execute();
    
?>
