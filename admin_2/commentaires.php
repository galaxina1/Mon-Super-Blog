<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style_2.css" />
	<title>Mon Super blog</title>
</head>

<body>

<h1>Mon Super blog !</h1>


<h4><a href="adminfred3fk.php">Retour à la liste des billets</a></h4></br>

<h4> 
        <form action="supprimer.php" method="post">
	
	<input type="submit" value="Supprimer"><br/>
        <input type="hidden" name="numerobillet" value="<?php echo $_GET['billet'] ?>">
     
        </form>
<h4/><br/>
<h4>
        
        <form action="modifier.php" method="post">
	<input type="submit" value="Modifier le contenu :">
	<input type="text" name="contenudubillet">
	<br/>
        <input type="hidden" name="numerobillet" value="<?php echo $_GET['billet'] ?>">
       
        </form>


<h4/>
<br/>


<?php



try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}


$req = $bdd->prepare('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss") AS date FROM billets WHERE id =?');
$req->execute(array($_GET['billet']));
$donnees =$req->fetch(); 
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> le <?php echo ($donnees ['date']);
	?> <br /> </h3>

	<p class="news"> <br/><?php
    echo ($donnees ['contenu']); 
	?><br/><br/>
	
    </p><br/>


<?php
	


?><h2> Commentaires : </h2> </br>

<?php
$req->closecursor();

$req = $bdd->prepare('SELECT auteur,commentaire,DATE_FORMAT(date_commentaire,"%d/%m/%Y à %Hh %imin %ss")AS date FROM commentaires WHERE id_billet=?ORDER BY date');
$req->execute (array($_GET['billet']));
while ($donnees =$req->fetch()) { 

	?>

	<p class="commentaires"><strong> <?php echo htmlspecialchars($donnees ['auteur']); ?></strong> le <?php echo($donnees ['date']);
	?> <br /><br/> <?php echo htmlspecialchars($donnees ['commentaire']); ?>

	   <br/> 

	</p><br/>
	
<!-- Suppresion des commentaires -->

          <h4> <form action="commentaires_delete.php" method="post">
        	 <input type ="hidden" name="auteur" value="<?php echo $donnees['auteur']?>">
        	 <input type ="hidden" name="numerobillet" value="<?php echo $_GET['billet']?>">
        	 <input type="submit" value="Supprimer">
               </form><br/>

               

          </h4>     

	<?php
}



$req->closecursor();

?>
<h4>
	<form action="commentaires_post.php" method="post">
	Pseudo : &nbsp;
	<input type="text" name="auteur"><br/>
        Message :
        <input type="text" name="commentaire"><br/>
        <input type="hidden" name="numerobillet" value="<?php echo $_GET['billet'] ?>">
        <input type="submit" value="Ajouter">
        </form>

</h4>




</body>
</html>