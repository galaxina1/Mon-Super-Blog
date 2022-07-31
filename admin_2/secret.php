<?php

if (isset ($_POST['password']) AND $_POST ['password'] == "fred5fk")

{
header('Location: adminfred3fk.php');
}

else 

{
header('Location:formulaire.php');
}



?>