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
   <title>Inscription</title>
   <link rel="stylesheet" type="text/css" href=" <?php if (isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style2.css") { echo "inscriptionstyle2.css";} else { echo "inscriptionstyle.css";}?>">
</head>
<body>
<h1><a href = "index.php">Mon Super blog !</a></h1>
<h2>Inscription</h2>
<div id="formulaire"><br/><br/>
<form action="inscription.php" method="post">
       
       
       Pseudo  
       <input type="text" name="pseudo" id="pseudo"value ="<?php if(isset ($_POST['pseudo'])) { echo $_POST['pseudo'];}?>"><br/><br/><p class="wrong" id="pseudoWrong"></p><br style="line-height: 28px"/>
       Mot de passe
       <input type="password" name="pass" id="pass" value="<?php if(isset($_POST['pass'])) { echo $_POST['pass'];}?>"><br/><br/><p class="wrong" id="passWrong"></p><br style="line-height: 28px"/>
       Retapez votre mot de passe
       <input type="password" name="pass_2" id="pass_2" value="<?php if(isset($_POST['pass_2'])) { echo $_POST['pass_2'];}?>"><br/><br/><p class="wrong" id="pass_2Wrong"></p><br style="line-height: 28px"/>
       Adresse email
       <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email'];}?>"><br/><br/><p class="wrong" id="emailWrong"></p><br/><br/><br/>

       <div class="valider" id="valider"><input type="submit" value=" Valider "></div>
 </form>
 </div>

<?php 
 
if (isset($_POST['pseudo'],$_POST['pass'],$_POST['pass_2'],$_POST['email'])) 
{ 

    // Rendre inoffensives les balises html

    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $_POST['pass'] = htmlspecialchars($_POST['pass']);
    $_POST['pass_2'] = htmlspecialchars($_POST['pass_2']);
    $_POST['email'] = htmlspecialchars($_POST['email']);

}

if (!empty($_POST)) {
    $valid = true;

// Se connecter

try
{

    $bdd = new PDO ('mysql:host=mysql-deslay.alwaysdata.net;dbname=deslay_blog;charset=utf8','deslay','deslay12345deslay');

    

}

catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}

// Vérification de la validité des informations :

// 1.Le pseudo est-il libre ?

$req = $bdd->query('SELECT COUNT(*) AS pseudos_existants FROM membres WHERE pseudo = "'.$_POST['pseudo'].'"');
$donnees=$req->fetch(); 


if ($donnees ['pseudos_existants'] == '0') 
{
?>
<!-- Javascript -->
<script>
    document.getElementById('pseudo').readOnly=true;
    document.getElementById('pseudo').style.backgroundColor="yellow";
</script>

<!-- ---------- -->
<?php
}
else {
    $valid = false;
    ?>
    <!-- Javascript -->
    <script>
        document.getElementById('pseudoWrong').innerHTML="Veuillez rentrer un autre pseudo";
   

    </script>
    <!-- ---------- -->

    <?php
}

// 2.Les deux mots de passe sont-ils identiques ?

if (!empty($_POST['pass'])) { 
if ($_POST['pass']==$_POST['pass_2']) {
   ?>
   <!-- Javascript -->
   <script>  
    document.getElementById('pass').readOnly=true;
    document.getElementById('pass').style.backgroundColor="yellow";
    document.getElementById('pass_2').readOnly=true;
    document.getElementById('pass_2').style.backgroundColor="yellow";
   </script>
   <!-- ---------- -->
   <?php }
else {
    $valid = false;
    ?>
    <!-- Javascript -->
    <script>
        document.getElementById('passWrong').innerHTML="Veuillez rentrer à nouveau votre mot de passe";
    </script>

    <!-- ---------- -->


<?php }
}
else {
    ?>
    <!-- Javascript -->
    <script>
        document.getElementById('pass_2Wrong').innerHTML="Veuillez rentrer un mot de passe";
    </script>

    <!-- ---------- -->

    <?php
}
// L'adresse e-mail a-t-elle une forme valide ?    
 
if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
{
   ?>
   <!-- Javascript -->
   <script>
    document.getElementById('email').readOnly=true;
    document.getElementById('email').style.backgroundColor="yellow";
   </script>
   <!-- ---------- -->
   <?php
}
else {
    $valid = false;
    ?>
    <!-- Javascript -->
    <script>
        document.getElementById('emailWrong').innerHTML="Adresse email non valide";
    </script>

    <!-- ---------- -->


    <?php
}


if ($valid) { 


// Hachage du mot de passe
$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);


// Insertion
$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(?,?,?,CURDATE())');
$req->execute(array( $_POST ['pseudo'],$pass_hache,$_POST['email']));
?><br/><p class="compte_cree">Votre compte a bien été crée</p>

<!-- Javascript -------------------->
<script>
    document.getElementById('valider').style.display ="none";

</script>


<!-- ---------- -------------------->
<?php
  }

}



?>
<!-- Apparence -->



<p onclick="clic()" id="ampoule"><img src="images/ampoule.png" class="ampoule" alt="image" title="Apparence"/></p> 

<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style.css" or empty($_COOKIE['apparence'])) { ?>

<script>
function clic() { 

    document.cookie = "apparence = style2.css";


    document.getElementsByTagName('link')[0].setAttribute('href','inscriptionstyle2.css');
    document.getElementById('ampoule').setAttribute('onclick','clic2()'); }

function clic2() {

    document.cookie = "apparence = style.css"; 

    
    document.getElementsByTagName('link')[0].setAttribute('href','inscriptionstyle.css');
    document.getElementById('ampoule').setAttribute('onclick','clic()'); }

   
                
</script>

<?php } ?>

<?php if(isset($_COOKIE['apparence'])and $_COOKIE['apparence']=="style2.css") { ?>

<script>


    function clic() { 

    document.cookie = "apparence = style.css"; 

    document.getElementsByTagName('link')[0].setAttribute('href','inscriptionstyle.css');
    document.getElementById('ampoule').setAttribute('onclick','clic2()');}

function clic2() {

    document.cookie = "apparence = style2.css"; 
    
    document.getElementsByTagName('link')[0].setAttribute('href','inscriptionstyle2.css');
    document.getElementById('ampoule').setAttribute('onclick','clic()');}

</script>

<?php } ?>
         
<!-- --------- -->

</body>
</html>