<?php

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

$req = $bdd ->prepare ('INSERT INTO billets (titre,contenu,date_creation) VALUES (?,?,NOW())');
$req-> execute(array($_POST ['titre'],$_POST['contenu']));


header('Location:adminfred3fk.php');

?>