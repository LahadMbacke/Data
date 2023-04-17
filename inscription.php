<?php 
$servername = "192.168.100.103";
$username = "group1-0";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
        $options = array(PDO::MYSQL_ATTR_SSL_CA => '/etc/mysql/ssl/ca-cert.pem');
	$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);
    
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Ajoutez votre code ici
$_POST["pseudo"] ="Fallou";
$_POST["password"]="1234";
$_POST["email"]= "lahadmbacke00@gmail.com";

    $pseudo_exist = 0;
    $email_exist = 0;
      // la valeur de chaque inputs est assigner a une variable
      $pseudo = $_POST["pseudo"];
      $password = md5($_POST["password"]);
      $email = trim($_POST["email"]);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		echo "110";
		return ;
	}

      //Check si le pseudo existe deja
      $req = "SELECT * FROM Joueur  WHERE pseudo= ?";
      $res=$connect->prepare($req);
       $res->execute([$pseudo]);
          $row = $res->fetch(); // On recupere le resultat 
          if($row)
          {
            $pseudo_exist = 1;
          }
          if($pseudo_exist ==1 && $email_exist == 0)
          {
             //Ce Pseudo existe deja
             echo "10";
             return;
          }


    // Fonction pour générer un code de vérification de 6 chiffres
		function generateVerificationCode() {
  		   return mt_rand(100000, 999999);
		}



       //Check si le email existe deja
       $req = "SELECT * FROM Joueur  WHERE email= ?";
       $res=$connect->prepare($req);
       $res->execute([$email]);
       $row = $res->fetch(); // On recupere le resultat 
           if($row)
           {
             $email_exist = 1;
           }
   
        if($pseudo_exist == 0 && $email_exist == 1)
        {
            //Cet Email existe deja
    	      echo "111";
             return;
         }

        // L'adresse e-mail est valide, générer un code de vérification et l'envoyer à l'utilisateur par e-mail
        $verificationCode = generateVerificationCode();
        $to = $email;
        $subject = "Code de vérification pour votre inscription";
        $message = "Votre code de vérification est : " . $verificationCode;
        $headers = "From: projetludo2023@outlook.fr";
        if(mail($to, $subject, $message, $headers)) {
            // Le code de vérification a été envoyé avec succès, enregistrer l'utilisateur dans la base de données
            $req = "INSERT INTO Joueur (pseudo,email,password,verification_code) VALUES(?,?,?,?)";
            $stmt = $connect->prepare($req);
            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password);
	    $stmt->bindParam(4, $verificationCode);
            $stmt->execute();
             echo "1";
        } else {
            // Une erreur s'est produite lors de l'envoi du code de vérification, afficher un message d'erreur
            echo "0";
		}
?>
