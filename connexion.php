<?php
session_start();
if (isset($_SESSION['pseudo'])) 
{
header('Location:index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>S'identifier</title>
   <link rel="stylesheet" type="text/css" href="<?php if (isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style2.css") { echo "connexion2.css";} else { echo "connexion.css";}?>">
</head>

<body>
<h1><a href = "index.php">Mon Super blog !</a></h1>
<h2>S'identifier</h2>
<div id="formulaire"><br/><br/>
<form action="connexion.php" method="post">
       Pseudo
       <input type="text" id="pseudo" name="pseudo"value="<?php 
       if (isset($_COOKIE['pseudo']) and isset($_POST['pseudo'])) { echo $_POST['pseudo'];}
       elseif (isset($_COOKIE['pseudo']) and !isset($_POST['pseudo'])) { echo $_COOKIE['pseudo'];}
       elseif (isset($_POST['pseudo'])) { echo $_POST['pseudo'];}


       ?>"><br/><br/>
       Mot de passe
       <input type="password" id="pass" name="pass" value="<?php

       if (isset($_COOKIE['copass']) and isset($_POST['pass'])) { echo $_POST['pass'];}
       elseif (isset($_COOKIE['copass']) and !isset($_POST['pass'])) { echo substr($_COOKIE['copass'],0,10);}
       elseif (isset($_POST['pass'])) { echo $_POST['pass'];}

       ?>"><br/><br/>
<!-- Checkbox -->
       <div class="connexAuto">Connexion automatique
        
       <input type="checkbox" id ="connex" name="connexion_auto" checked></div>
      
       
<!-- -------- -->
</div>

       <div id="connect" class="se_connecter"><input type="submit" value="Se Connecter" name="submit"></div>
 </form> 


<?php 


if (isset($_POST['pseudo'],$_POST['pass'])) 


{   
    if ($_POST['pseudo']=="admin") {
      header('Location:admin_2/index.php');
    }
    else { 
// Se connecter
    try
    {

$bdd = new PDO ('mysql:host=mysql-deslay.alwaysdata.net;dbname=deslay_blog;charset=utf8','deslay','deslay12345deslay');


    
    }

    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());

    }
// Récupération de l'utilisateur 


$req =$bdd->query('SELECT * FROM membres WHERE pseudo ="'.$_POST['pseudo'].'"'); 
$donnees = $req->fetch();



// Comparaison des mots de passe 

if (!$donnees) {
   ?> <p class="wrong">Mauvais pseudo ou mot de passe</p><?php
}

   if (!empty($_POST['pseudo'])) { 
      if ($donnees) {
        // Javascript ---------------
        ?><script>
        document.getElementById("pseudo").readOnly = "true";
        document.getElementById('pseudo').style.backgroundColor = "yellow";
        </script><?php

         
         $valid=password_verify($_POST['pass'], $donnees['pass']);
         if ($valid or $_POST['pass']== substr($donnees['pass'],0,10))

            
           
          {


            // Javascript ----------------------

            ?><script>
            document.getElementById("connect").style.display = "none";   


            
            document.getElementById('pass').readOnly ="true";
            document.getElementById('pass').style.backgroundColor = "yellow";
            </script><?php  


            // Cookies ---------------------------

            if (isset($_POST ['connexion_auto'])) {

                setcookie ('pseudo',$donnees['pseudo'],time() + 365*24*3600,null,null,false,true);


                setcookie ('copass',$donnees['pass'],time() + 365*24*3600,null,null,false,true);
            // Javascript ------------------------
                ?><script>
                   document.getElementById('connex').disabled ="true";
                  </script><?php

             }
             else {
                setcookie('pseudo','');
                setcookie('copass','');

             // Javascript -----------------------
                ?><script>
                    document.getElementById('connex').disabled =true;
                    document.getElementById('connex').checked=false;

                  </script><?php  
             

             }
            // Session -----------------------------

            $_SESSION['id'] = $donnees['id'];
            $_SESSION['pseudo'] = $donnees['pseudo'];
            
         ?><p class="ok">Vous êtes connecté !</p><?php
         }
         else {
         ?><p class="wrong">Mauvais mot de passe</p><?php
         }

      } 


   }





}
   
          
}




?>

 <!-- Apparence -->

<p onclick="clic()" id="ampoule"><img src="images/ampoule.png" class="ampoule" alt="image" title="Apparence"/></p> 

<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style.css" or empty($_COOKIE['apparence'])) { ?>

<script>
function clic() { 

    document.cookie = "apparence = style2.css";

    document.getElementsByTagName('link')[0].setAttribute('href','connexion2.css');
    document.getElementById('ampoule').setAttribute('onclick','clic2()'); }

function clic2() {

    document.cookie = "apparence = style.css"; 
    
    document.getElementsByTagName('link')[0].setAttribute('href','connexion.css');
    document.getElementById('ampoule').setAttribute('onclick','clic()'); }

                 
</script>

<?php } ?>

<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style2.css") { ?>

<script>


    function clic() { 

    document.cookie = "apparence = style.css"; 

    document.getElementsByTagName('link')[0].setAttribute('href','connexion.css');
    document.getElementById('ampoule').setAttribute('onclick','clic2()');}

function clic2() {

    document.cookie = "apparence = style2.css"; 
    
    document.getElementsByTagName('link')[0].setAttribute('href','connexion2.css');
    document.getElementById('ampoule').setAttribute('onclick','clic()');}

</script>

<?php } ?>
         
<!-- --------- -->
</body>
</html>