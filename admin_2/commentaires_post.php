<?php

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

$req = $bdd ->prepare ('INSERT INTO commentaires (id_billet,auteur,commentaire,date_commentaire) VALUES (?,?,?,NOW())');
$req-> execute(array($_POST ['numerobillet'],$_POST['auteur'],$_POST['commentaire']));


header('Location:commentaires.php?billet='.$_POST['numerobillet']);

?>