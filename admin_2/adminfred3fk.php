
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style_2.css" />
	<title>Mon Super Blog</title>
</head>

<body>

<h1>Mon Super blog !</h1>


<h2> Billets du blog : </h2> </br>
<form action="ajouter.php" method="post">
	<h4> Ajouter un billet : <br/><br/>
	Titre :
	<input type="text" name="titre">
	Texte :
	<input type="text" name="contenu">
	<input type="submit" value="Ajouter">
	</h4><br/>
</form>



<?php
try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}


$req= $bdd->query('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss")AS date FROM billets ORDER BY date_creation DESC');
while ($donnees =$req->fetch()) {
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> &ensp;<span class="date"> le <?php echo ($donnees ['date']);
	?></span> <br /> </h3>

	<p class="news"> <br/><?php
    echo htmlspecialchars($donnees ['contenu']); 
	?><br/><br/>
	<a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a>

	<br/><br/></p><br/>

	<?php
}


$req->closecursor();



?>




</body>
</html>