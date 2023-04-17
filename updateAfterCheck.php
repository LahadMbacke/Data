<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
    // echo $_POST['verification_code'];
    if(isset($_POST['verification_code']))
    {
        $verificationCode =  $_POST['verification_code'];
        // Vérifier si l'adresse e-mail et le code de vérification sont valides
    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE verification_code = :verification_code");
    $stmt->execute(['verification_code' => $verificationCode]);
    $user = $stmt->fetch();
    if($user) {
        // L'adresse e-mail et le code de vérification sont valides, enregistrer l'utilisateur comme étant vérifié
        $stmt = $pdo->prepare("UPDATE Joueur SET verified = :verified WHERE verification_code = :verification_code");
        $stmt->execute(['verified' => 1,'verification_code' => $verificationCode]);
	if ($stmt->rowCount() == 1) {
            // Success update
		echo "1";
        }
       else
         echo "0";
    }
   else {
        // L'adresse e-mail et/ou le code de vérification sont invalides, afficher un message d'erreur
        //code de vérification invalides.";
        echo "10";
    }
 }
 else
   echo "-1";
    
    
?>
