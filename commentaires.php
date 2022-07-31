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


<h4><a href="index.php">Retour à la liste des billets</a></h4></br>




<?php

// CONNEXION BASE DE DONNEES //

try
{

$bdd = new PDO ('mysql:host=mysql-deslay.alwaysdata.net;dbname=deslay_blog;charset=utf8','deslay','deslay12345deslay');




}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

// AFFICHAGE DU BILLET //

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
	
// AFFICHAGE DES COMMENTAIRES //

?><h2> Commentaires : </h2> </br>

<?php
$req->closecursor();

$req = $bdd->prepare('SELECT auteur,commentaire,images,videos,DATE_FORMAT(date_commentaire,"%d/%m/%Y à %Hh %imin %ss")AS date FROM commentaires WHERE id_billet=?ORDER BY date_commentaire');
$req->execute (array($_GET['billet']));
while ($donnees =$req->fetch()) { 

	?>

	<p class="commentaires"><strong> <?php echo htmlspecialchars($donnees ['auteur']); ?></strong> le <?php echo($donnees ['date']);
	?> <br /><br/> <?php echo htmlspecialchars($donnees ['commentaire']);
	?></p><br/>
	<?php if(!empty($donnees['images'])) { ?>
	<p class="photo"><img src="imagesUploads/<?php echo $donnees['images'];?>" class="imageUploads" ></p><br/><?php }
	
}
$req->closecursor();

// Accès aux posts de commentaires

if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])) 
    {

    ?>

    <h4>
	    <form action="commentaires.php" method="post" enctype="multipart/form-data">
	    <div class="imageAjouterMessage">
	    <input type="hidden" name="auteur" value="<?php echo $_SESSION['pseudo'];?>"><br/>
            Message :
            <input type="text" name="commentaire"><br/>
            <input type="hidden" name="numerobillet" value="<?php echo $_GET['billet'] ?>"><br/>
            <input type="file" name="video" id="video_upload" style="display:none">
            <label for="video_upload">🎬 &nbsp;VIDEO &ensp;&nbsp;</label>	
            <input type="file" name="image" id="image_upload" style="display:none">
            <label for="image_upload">🏔 &nbsp;IMAGE</label> &nbsp;
            
            <input type="submit" value="Ajouter" class="submit"></div>
            </form>

    </h4>



    <?php

    // INSERTION COMMENTAIRES DANS BASE DE DONNEES 

    // S'IL Y A UN COMMENTAIRE 

      

      if(isset($_POST['commentaire']) and !empty($_POST['commentaire']) and $_FILES['image']['error']==4 and $_FILES['video']['error']==4) { 

      	   
            $req = $bdd ->prepare ('INSERT INTO commentaires (id_billet,auteur,commentaire,images,videos,date_commentaire) VALUES (?,?,?,?,?,NOW())');
            $req-> execute(array($_POST ['numerobillet'],$_POST['auteur'],$_POST['commentaire'],"","")); 

            header('Location:commentaires.php?billet='.$_POST['numerobillet']);}


      elseif (isset($_POST['commentaire']) and empty($_POST['commentaire']) and $_FILES['image']['error']==4 and $_FILES['video']['error']==4) {
     	    header('Location:commentaires.php?billet='.$_POST['numerobillet']);
     }
 

    // S'IL Y A UNE IMAGE 

      if(isset($_POST['commentaire']) and isset($_FILES['image'])) {
	    $tmpName = $_FILES['image']['tmp_name'];
	    $name = $_FILES['image']['name'];
	    $size =$_FILES['image']['size'];
	    $error = $_FILES['image']['error'];

	    // Gérer les erreurs //

	    $tabExtension = explode ('.',$name);
	    $extension = strtolower(end($tabExtension));

	    // Extensions et Taille acceptées, pas d'erreurs //

	    $extensions =['jpg','png','jpeg','gif'];
	    $maxSize = 4000000;


		if (in_array($extension,$extensions) and $size <= $maxSize and $error == 0) {

		    	// Nom unique du fichier //

		    	$uniqueName = uniqid('',true);
		    	$file = $uniqueName.".".$extension;

		    	// -------------------- //

		        move_uploaded_file($tmpName,'./imagesUploads/'.$file);
		
                        // Insertion Nom du fichier dans la base de données //

                        $req = $bdd ->prepare ('INSERT INTO commentaires (id_billet,auteur,commentaire,images,videos,date_commentaire) VALUES (?,?,?,?,?,NOW())');
                        $req-> execute(array($_POST ['numerobillet'],$_POST['auteur'],$_POST['commentaire'],$file,"")); 

                        header('Location:commentaires.php?billet='.$_POST['numerobillet']);} 

       
	     elseif ($size > $maxSize) { 
	     	header('Location:commentaires.php?billet='.$_POST['numerobillet']); 
	     	// echo " Taille trop grande"; // 
	     }  

		 elseif ( $error !== 0)	{ 
		 	header('Location:commentaires.php?billet='.$_POST['numerobillet']); 
		 	// echo "Erreur";//
		 }	
		    
		 else { 
		 	header('Location:commentaires.php?billet='.$_POST['numerobillet']); 
		 	// echo " Mauvaise extension"; //
		 }			
        
	 }

	 // S'IL Y A UNE VIDEO //
     
     
     	
     



     }

?>
<!-- Apparence -->

<p onclick="clic()" id="ampoule"><img src="images/ampoule.png" class="ampoule" alt="image" title="Apparence"/></p> 





<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style.css" or empty($_COOKIE['apparence'])) { ?>


<script>

function clic() { 


    document.cookie = "apparence = style2.css"; 

	document.getElementsByTagName('link')[0].setAttribute('href','style2.css');
	document.getElementById('ampoule').setAttribute('onclick','clic2()');}


function clic2() {

	document.cookie = "apparence = style.css"; 

	document.getElementsByTagName('link')[0].setAttribute('href','style.css');
	document.getElementById('ampoule').setAttribute('onclick','clic()');}

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

<?php } ?>




   
	     
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