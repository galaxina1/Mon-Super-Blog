<?php

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}
$req=$bdd->prepare('DELETE FROM commentaires WHERE auteur=?');
	$req->execute(array($_POST['auteur']));
	$req->closeCursor();





header('Location:commentaires.php?billet='.$_POST['numerobillet']);

?>