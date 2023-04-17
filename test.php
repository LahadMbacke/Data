<?php
 require_once 'vendor/autoload.php';
         require_once 'confi.php'; 

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

   // Fonction pour générer un code de vérification de 6 chiffres
                function generateVerificationCode() {
                   return mt_rand(100000, 999999);
                }

//                $_POST["pseudo"] = "O2hwqwwwuaj2wgalMK" ;
  //              $_POST["password"] = "wokkww";
    //            $_POST["email"] = "dejahe6373@marikuza.com";
   if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email']))
   {
    $pseudo_exist = 0;
    $email_exist = 0;
  
      // la valeur de chaque inputs est assigner a une variable
      $pseudo = $_POST["pseudo"];
      $password = md5($_POST["password"]);
      $email = $_POST["email"];

      //Check si le pseudo existe deja
      $req = "SELECT * FROM Joueur  WHERE pseudo= ?";
      $res=$connect->prepare($req);
       $res->execute([$pseudo]);
          $row = $res->fetch(); // On recupere le resultat 
          if($row)
          {
            $pseudo_exist = 1;
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

        if($pseudo_exist ==1 && $email_exist == 0)
         {
            //Ce Pseudo existe deja
	    echo "10";
         }
         elseif($pseudo_exist == 0 && $email_exist == 1)
         {
            //Cet Email existe deja
	   echo "111";
         }
          elseif($pseudo_exist == 1 && $email_exist == 1)
         {
            //Cet Email et Pseudo existe deja
           echo "112";
         }

   else {
        // L'adresse e-mail est valide, générer un code de vérification et l'envoyer à l'utilisateur par e-mail
        $verificationCode = generateVerificationCode();
           // Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com',587, 'tls'))
      ->setUsername(EMAIL)
      ->setPassword(PASS)
;
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);
// Create a message
$message = (new Swift_Message('Code de confirmation'))
  ->setFrom([EMAIL => 'Ludo Game'])
  ->setTo([$email])
  ->setBody('Votre code de vérification est :'.$verificationCode)
;
// Send the message
 if($mailer->send($message))
   {
//echo"EEE";
           // Le code de vérification a été envoyé avec succès, enregistrer l'utilisateur dans la base de données
            $req = "INSERT INTO Joueur (pseudo,email,password,verification_code) VALUES(?,?,?,?)";
            $stmt = $connect->prepare($req);
            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password);
	    $stmt->bindParam(4, $verificationCode);
            $stmt->execute();
	   if ($stmt->rowCount() == 1) 
		echo "1";
           else
              echo "0";
    }

 else {
            // Une erreur s'est produite lors de l'envoi du code de vérification, afficher un message d'erreur
            echo "0";
      }
  } //fin else 
} // finsi

   else
   {
     echo "Data empty";
   }
?>
