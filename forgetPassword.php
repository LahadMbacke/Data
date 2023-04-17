<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";
try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "Connected successfully";
   }
 catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

// Fonction pour generer un mot de passe
function generate_password() {
    $password = '';
    $chars = '0123456789'; // chiffres uniquement
    $char_count = strlen($chars);

    for ($i = 0; $i < 8; $i++) {
        $random_index = rand(0, $char_count - 1);
        $password .= $chars[$random_index];
    }

    return $password;
}

//$_POST['email'] = "mikoyi7966@fectode.com";
    // Récupère l'e-mail soumis par l'utilisateur
    $email = $_POST['email'];
    // Vérifie si l'e-mail existe dans la base de données
    $stmt = $connect->prepare('SELECT * FROM Joueur WHERE email = :email');
    $stmt->execute(array('email' => $email));

    if($row = $stmt->fetch()){
        $new_password = generate_password(); 
        $password = md5($new_password);

        $stmt = $connect->prepare("UPDATE Joueur SET password = :password WHERE email = :email");
        $stmt->execute(['password' => $password,'email' => $email]);

	if ($stmt->rowCount() == 1) {
            // On  envoie le noveau mot de passe a l'utilsateur
	   $to = $email;
           $subject = "Votre nouveau mot de passe";
           $message = "Votre password est : " .$new_password;
           $headers = "From: projetludo2023@outlook.fr";
       	      if(mail($to, $subject, $message, $headers))
            	echo "1"; // le mot de passe est envoye
       	     else
                echo "0"; //erreur sur l'envoi du nouveau password
        }
    }

    else{
	  echo "0";
    }

?>
