<?php
session_start();// ici on continue la session

if ((!isset($_SESSION['id_user'])) || ($_SESSION['id_user'] == ''))
{

	// La variable $_SESSION['login'] n'existe pas, ou bien elle est vide
	// <=> la personne ne s'est PAS connectée

	header('Location: Authentification.php');
	exit();

}
else {
    $idUser=$_SESSION['id_user'];
}
?>