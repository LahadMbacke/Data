<?php
header("Access-Control-Allow-Origin: *"); // Autoriser les requêtes cross-origin
// Remplacez ces informations par les informations de connexion à votre base de données
$servername = "192.168.100.103";
$username = "group1-1";
$password = "Unistra2023#";
$dbname = "bdd_ludo";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['id_joueur'])) {
    $sql = "SELECT * FROM Joueur as j INNER JOIN Possesde as p ON j.id_joueur = p.id_joueur INNER JOIN Avatar as a ON p.id_avatar = a.id_avatar WHERE j.id_joueur = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['id_joueur']]);
    
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $image_data = $row["picavatar"];
        $base64_image = base64_encode($image_data);
        $response = array(
            "Pseudo" => $row["pseudo"],
            "nbVictoire" => $row["nbVictoire"],
            "nbMatch" => $row["nbMatch"],
            "Avatar" => $base64_image,
            "response" => "Success"
        );
    } else {
        $response = array("response" => "No Player Found");
    }
} else {
    $response = array("response" => "No ID Provided");
}

echo json_encode($response);
?>
