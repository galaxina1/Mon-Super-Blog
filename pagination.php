<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php if (isset($_COOKIE['apparence'])) { echo $_COOKIE['apparence'];} else { echo "style.css";}?>" />
	<title>Mon Super Blog</title>
</head>

<body>

<?php
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
{
	?><p class = "bienvenue ">Bienvenue <?php echo $_SESSION['pseudo']; ?> ! </p><p class ="deconnexion"><a href ="deconnexion.php">Se déconnecter</a></p><?php
}
else { 
?>

<p class="identifierinscrire">🔒<a href="connexion.php"> S'identifier</a> - 👤<a href="inscription.php"> S'inscrire</a></p>
<?php }

?>

<h1>Mon Super blog !</h1>


<h2> Derniers billets du blog : </h2> </br>



<?php
try
{

	$bdd = new PDO ('mysql:host=mysql-deslay.alwaysdata.net;dbname=deslay_blog;charset=utf8','deslay','deslay12345deslay');

	

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}


if ($_GET['page']==1) { 


        $req= $bdd->query('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss")AS date FROM billets ORDER BY date_creation DESC LIMIT 0,5');
        while ($donnees =$req->fetch()) {
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> &ensp;<span class="date"> le <?php echo ($donnees ['date']);
	?></span> <br /> </h3>

	<p class="news"> <br/><?php
        echo htmlspecialchars($donnees ['contenu']); 
	?><br/><br/>
	<a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a>
	<br/><br/>
        </p><br/>

	<?php
}


$req->closecursor();



}
     
 
elseif ($_GET['page']==2) { 


        $req= $bdd->query('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss")AS date FROM billets ORDER BY date_creation DESC LIMIT 5,5');
        while ($donnees =$req->fetch()) {
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> &ensp;<span class="date"> le <?php echo ($donnees ['date']);
	?></span> <br /> </h3>

	<p class="news"> <br/><?php
    echo htmlspecialchars($donnees ['contenu']); 
	?><br/><br/>
	<a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a>
	<br/><br/>
    </p><br/>

	<?php
}


$req->closecursor();



}

elseif ($_GET['page']==3) { 


        $req= $bdd->query('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss")AS date FROM billets ORDER BY date_creation DESC LIMIT 10,5');
        while ($donnees =$req->fetch()) {
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> &ensp;<span class="date"> le <?php echo ($donnees ['date']);
	?></span> <br /> </h3>

	<p class="news"> <br/><?php
    echo htmlspecialchars($donnees ['contenu']); 
	?><br/><br/>
	<a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a>
	<br/><br/>
    </p><br/>

	<?php
}


$req->closecursor();



}

elseif ($_GET['page']==4) { 


        $req= $bdd->query('SELECT id,titre,contenu,DATE_FORMAT(date_creation,"%d/%m/%Y à %Hh %imin %ss")AS date FROM billets ORDER BY date_creation DESC LIMIT 15,5');
        while ($donnees =$req->fetch()) {
	?>
	<h3> <?php

	echo htmlspecialchars($donnees ['titre']); ?> &ensp;<span class="date"> le <?php echo ($donnees ['date']);
	?></span> <br /> </h3>

	<p class="news"> <br/><?php
    echo htmlspecialchars($donnees ['contenu']); 
	?><br/><br/>
	<a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a>
	<br/><br/>
    </p><br/>

	<?php
}


$req->closecursor();



}


?>
<p class="pages"> Pages :&nbsp;
<a href="pagination.php?page=1">1</a>&nbsp; 
<a href="pagination.php?page=2">2</a>&nbsp; 
<a href="pagination.php?page=3">3</a>&nbsp; 
<a href="pagination.php?page=4">4</a> </p>
        
<!-- Apparence -->

<p onclick="clic()" id="ampoule"><img src="images/ampoule.png" class="ampoule" alt="image" title="Apparence"/></p> 




<?php 
if ($_GET['page']==1 or 2 or 3 or 4) { 

if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style.css" or empty($_COOKIE['apparence'])) { ?>

<script>
function clic() { 

        document.cookie = "apparence = style2.css";

	document.getElementsByTagName('link')[0].setAttribute('href','style2.css');
	document.getElementById('ampoule').setAttribute('onclick','clic2()'); }

function clic2() {

	
	document.getElementsByTagName('link')[0].setAttribute('href','style.css');
	document.getElementById('ampoule').setAttribute('onclick','clic()'); }

</script>

<?php } ?>

<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style2.css") { ?>

<script>


	function clic() { 

	document.cookie = "apparence = style.css"; 

	document.getElementsByTagName('link')[0].setAttribute('href','style.css');
	document.getElementById('ampoule').setAttribute('onclick','clic2()');}

function clic2() {

	document.cookie = "apparence = style2.css"; 
	
	document.getElementsByTagName('link')[0].setAttribute('href','style2.css');
	document.getElementById('ampoule').setAttribute('onclick','clic()');}

</script>

<?php } }?>
	     
<!-- --------- -->

<!-- Musique --> 
<?php
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])) { 
?>

<audio src="musique/情義兩心堅.mp3" id="audio1"  ></audio> 
<p><img src="images/icone_musique.png" class="iconeMusique" onclick="play()"></p>
       
<script type="text/javascript">

function play() {
    var player = document.getElementById("audio1");
     
    if (player.paused) {
        player.play();
        
    } else {
        player.pause();
        player.currentTime = 0;
    }
}
</script>

<?php } ?>

<!-- ------- -->




</body>
</html>