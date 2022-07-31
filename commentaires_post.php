<?php

// Connexion base de données //

try
{
	$bdd = new PDO ('mysql:host=localhost;dbname=test;charset=utf8','root','root');

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

// INSERTION COMMENTAIRES DANS BASE DE DONNEES//

$req = $bdd ->prepare ('INSERT INTO commentaires (id_billet,auteur,commentaire,date_commentaire) VALUES (?,?,?,NOW())');
$req-> execute(array($_POST ['numerobillet'],$_POST['auteur'],$_POST['commentaire']));

// IMAGE //

// Upload de l'image //

		if (isset($_FILES['image'])) {
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


		        if (in_array($extension,$extensions) and $size <= $maxSize and $error == 0)

		        {

		    	// Nom unique du fichier //

		    	$uniqueName = uniqid('',true);
		    	$file = $uniqueName.".".$extension;

		    	// -------------------- //

		    	move_uploaded_file($tmpName,'./imagesUploads/'.$file);

		    	// Insertion Nom du fichier dans la base de données //

                        $req = $bdd->prepare('INSERT INTO images (name) VALUES (?)');
                        $req->execute([$file]);	

                        // Afficher les images //

                        $req = $bdd->query('SELECT name FROM images ORDER BY id DESC');
                        while($data = $req->fetch()) {
	                ?> <br/><img src="imagesUploads/<?php echo $data['name'] ?>" width="600px"> <?php
                        }	

		    	}

		elseif ($size > $maxSize) {
		    	echo " Taille trop grande";
		    			}
		elseif ( $error !== 0)	{ echo "Erreur";}	
		    
		else { echo " Mauvaise extension";}	

		}    	
// ----- //

header('Location:commentaires.php?billet='.$_POST['numerobillet']);

?>