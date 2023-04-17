<?php
    session_start();
    $player_id = $_SESSION['id_joueur'];

    echo 'Player id: ' .$player_id;
?>
