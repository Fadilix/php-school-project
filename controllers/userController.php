<?php
include "C:/xampp/htdocs/projets php/php_p/php-projet/config/database.php";
error_reporting(0);

$msg = "";

// Ajoute un nouvel utilisateur
function addNewUser($username, $password)
{
    global $db;
    global $msg;

    // Chequer si l'utilsateur existe
    $checkUsernameQuery = "SELECT COUNT(*) as count FROM user WHERE username = ?";
    $stmt = $db->prepare($checkUsernameQuery);
    $stmt->execute([$username]);
    $result = $stmt->fetch();

    if ($result['count'] > 0) {
        $msg = "Ce nom d'utilisateur existe déjà";
        return;
    }


    // si le username n'est pas dans la base alors on l'ajoute
    if (strlen($password) >= 8) {
        $msg = "";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $addNewUserQuery = "INSERT INTO user (username, password) VALUES (?, ?)";
        $stmt = $db->prepare($addNewUserQuery);
        $stmt->execute([$username, $hashedPassword]);
        header("Location: login.php");
        exit;
    } else {
        $msg = "Le mot de passe doit contenir au moins 8 caractères";
    }
}


// loger l'utilisateur en vérifiant son nom d'utilisateur et son mot de passe
function logUser($username, $password)
{
    global $db;
    global $msg;

    $getUserQuery = "SELECT * FROM user WHERE username = ?";
    $stmt = $db->prepare($getUserQuery);
    $stmt->execute([$username]);

    $userData = $stmt->fetch();
    $msg = "";

    if (isset($userData) && password_verify($password, $userData['password'])) {
        $msg = "Connecté avec succès";

        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $userData["id"];
        header("Location: home.php");
    } else {
        $msg = "Connexion échouée, le mot de passe ou le nom d'utilisateur n'est pas correct.";
    }
}



// Rechercher le username d'un utilisateur à partir de son id
function getUsernameById($userId)
{
    global $db;
    $getUserQuery = "SELECT * FROM user WHERE id = ?";
    $stmt = $db->prepare($getUserQuery);
    $stmt->execute([$userId]);
    $userData = $stmt->fetch();
    return $userData["username"];
}
