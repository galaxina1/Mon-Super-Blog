<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>VIDEO</title>
</head>
<body>


<form action="videoEssai.php" method="post" enctype="multipart/form-data">
	
<input type="file" name="video">
<input type="submit" name="Ajouter">

</form>

<?php 

if(isset($_FILES)) {
	var_dump($_FILES);
}

?>


</body>
</html>