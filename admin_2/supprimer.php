<?php

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

$req = $bdd->prepare('DELETE FROM billets WHERE id= ?');
$req->execute(array($_POST['numerobillet']));
$req->closeCursor();
// Redirection du visiteur vers la page  admin
header('Location:adminfred3fk.php');



?>