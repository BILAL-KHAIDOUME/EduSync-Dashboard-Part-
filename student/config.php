<?php


try {
    $conn = new PDO("mysql:host=localhost;dbname=edusync;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur DB : " . $e->getMessage());
}

// ⚠️ Simulation utilisateur connecté (remplacer par login)
$_SESSION['user_id'] = 3; 