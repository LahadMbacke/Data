<?php 
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "Connected successfully";
}
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

//$_POST['pseudo'] = "user4";
//$_POST['password'] = "12";

    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $hashed_password = md5($password);
  // Exécuter la requête SQL pour récupérer l'ID du joueur
      $req = "SELECT * FROM Joueur  WHERE pseudo = ?";
      $res=$pdo->prepare($req);
      $res->execute([$pseudo]);
      $result = $res->fetch();
      if(!$result)
      {
         echo "-2";
      }
      else
        if($result["verified"] == 1) 
        {
          if($hashed_password == $result['password'])
          {
            $stmt = $pdo->prepare("UPDATE Joueur SET isConnected = :isConnected WHERE pseudo = :pseudo");
            $stmt->execute(['isConnected' => 1,'pseudo' => $pseudo]);
            if ($stmt->rowCount() == 1)
            {
              echo $result['id_joueur'];
            }
            else
            {
              echo "-1"; // Deja connecte
            }
          }
          else
            echo "-3"; //problem password     
        }
        else
        {
           echo "-4"; // compte supp 
        }
  ?>
