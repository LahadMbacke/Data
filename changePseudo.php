<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//  echo "Connected successfully";
}
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$pseudo_exist = 0;

// Récupération des données POST
$ID = $_POST['id_joueur'];
$newPseudo = $_POST['newPseudo'];

  //Check si le pseudo existe deja
  $req = "SELECT * FROM Joueur  WHERE pseudo= ?";
  $res=$pdo->prepare($req);
  $res->execute([$newPseudo]);
      $row = $res->fetch(); // On recupere le resultat 
      if($row)
      {
        $pseudo_exist = 1;
      }
  if($pseudo_exist ==1)
  {
      //Ce Pseudo existe deja
      echo "-1";
      return;
  }

    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE id_joueur = :id_joueur");
    $stmt->execute(array(':id_joueur' => $ID));
    $result = $stmt->fetch();
    if ($result) {    

        // Préparation et exécution de la requête SQL pour mettre à jour le mot de passe de l'utilisateur
         $stmt = $pdo->prepare("UPDATE Joueur SET pseudo = :pseudo WHERE id_joueur = :id_joueur");
         $stmt->execute(['pseudo' => $newPseudo,'id_joueur' => $ID]);
          
         $stmt1 = $pdo->prepare("UPDATE Joueur SET isConnected = :isConnected WHERE id_joueur = :id_joueur");
         $stmt1->execute(['isConnected' => 0,'id_joueur' => $ID]);
        if($stmt->rowCount() == 1 AND $stmt1->rowCount()==1)
           echo "1"; // modification avec success
        else 
          echo "0";  // Echec de modification
        }
	  else {
   		echo "0"; //erreur sur mot de passe
	}
?>
