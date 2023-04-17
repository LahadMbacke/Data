<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   	echo "Connected successfully";
}
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

      // la valeur de chaque inputs est assigner a une variable
      $pseudo = $_POST["myLog"];
      $password = $_POST["myPassword"];
      $email = $_POST["myEmail"];
//      echo $email;
	  echo $pseudo;
    	  echo $email;
         echo $password;

 //INSERTION DANS JOUEUR

  $req = "INSERT INTO joueur (pseudo,Email,password) VALUES(?,?,?)";
            $stmt = $connect->prepare($req);           
            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password);
            $stmt->execute();
?>
