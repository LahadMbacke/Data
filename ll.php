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


$_POST["pseudo"] = "OwtKLahad";
$_POST["password"] = "222000";

    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

  // Exécuter la requête SQL pour récupérer l'ID du joueur
    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE pseudo = :pseudo AND password = :password");
    $stmt->execute(array(':pseudo' => $pseudo, ':password' => $hashed_password));
    $result = $stmt->fetch();
  // Renvoyer l'ID du joueur ou 0 si aucun joueur n'est trouvé
	 if ($result) 
	 {
            if($result["verified"]==1)
            {
              $stmt = $pdo->prepare("UPDATE Joueur SET isConnected = :isConnected WHERE pseudo = :pseudo");
              $stmt->execute(['isConnected' => 1,'pseudo' => $pseudo]);
	       if ($stmt->rowCount() == 1)
               {
                echo $result['id_joueur'];
               }
            }
            else
               echo "0";
 	 }
	 else 
          {
   		echo "0";
	  }
?>
