<?php 
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "Connected successfully";
}
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
    $ID = $_POST['id_joueur'];
    $stmt = $pdo->prepare("UPDATE Joueur SET isConnected = :isConnected WHERE id_joueur = :id_joueur");
        $stmt->execute(['isConnected' => 0,'id_joueur' => $ID]);
	if ($stmt->rowCount() == 1) {
	  echo "1"; //Deconnexion avec success
        }
       else
         echo "0"; //Toujours connecte
?>
