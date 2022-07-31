
<?php

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}


$req = $bdd->prepare('UPDATE billets SET contenu = :contenu WHERE id=:id');
$req->execute(array(':contenu' => $_POST['contenudubillet'],':id' => $_POST['numerobillet']));
$req->closeCursor();

header('Location:adminfred3fk.php');

?>