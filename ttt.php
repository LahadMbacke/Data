<?php
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

function base64_encode_image($image_path) {
    $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
    $image_data = file_get_contents($image_path);
    return 'data:image/' . $image_type . ';base64,' . base64_encode($image_data);
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$image_paths = array(
    "/var/www/html/ttt/1.png",
    "/var/www/html/ttt/2.png",
    "/var/www/html/ttt/3.png"
);


$_POST['id_joueur']=1;
if (isset($_POST['id_joueur'])) {
    $req = "SELECT * FROM Joueur WHERE id_joueur= ? ";
    $res = $pdo->prepare($req);
    $res->execute([$_POST["id_joueur"]]);
    $retVal = array("id_joueur" => "", "response" => "Echec");

    if ($row = $res->fetch()) {
        $encoded_images = array_map("base64_encode_image", $image_paths);

        $retVal = array(
            "Pseudo" => $row["pseudo"],
            "nbVictoire" => $row["nbVictoire"],
            "nbMatch" => $row["nbMatch"],
            "images" => $encoded_images,
            "response" => "Success"
        );
    }
    echo json_encode($retVal);
} else {
    echo "No Player";
}
?>
