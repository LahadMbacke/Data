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

 
       // On fait un select pour trouver les stas des joueur , on les classe par nbVict et nbDefaite
        $req = "SELECT * FROM  Joueur Order by nbVictoire DESC , nbDefaite ASC";
        $res=$pdo->prepare($req);
        $retVal = array("response" => "Echec"); // On declare un tableau 
        $rang = 1;  // la postion d'un joueur dans le classement
        while ($row = $res->fetch()) { //on parcour chaque ligne corespondant a un joueur
            //On affiche ses infos
	$retVal = array("Rang" => $rang,
           "Pseudo" => $row["pseudo"],
           "nbVictoire" => $row["nbVictoire"],
           "nbDefaite" => $row["nbDefaite"],
           "response" => "Ok");
           $rang++;

           echo json_encode($retVal); // On affiche le classement des joueur et les stat
        }
 echo json_encode($retVal);
?>
