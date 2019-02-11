<?php
session_start();
if (isset($_SESSION['connect']) AND $_SESSION['connect']==1)//On vérifie que le variable existe.
{
        $connect=$_SESSION['connect'];//On récupère la valeur de la variable de session.
}
else
{
        $connect=0;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0".
}
       
if ($connect == 1) // Si le visiteur s'est identifié.
{
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>REDIRECTION</title>
	<meta charset="UTF-8">
	<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="CARTIQ/style.css">
	<script type="text/javascript" src="./CONFIG/conf.js"></script>

</head>
		
<?php include './CONFIG/conf.php';?>


	<header>
		<div id=logo>
		<img class="logo" src="CARTIQ/IMG/logo.png"><img class="logo" src="CARTIQ/IMG/irstea.png">
		</div>
		<h1> WIKISEMIO </h1>
		<h2> <u>Projet:</u>&nbsp<?php echo $nameProject ?></h2>
	</header>
	<body>
		<div id=acceuil>
			<div id=acceuil_gauche>
				<iframe width="620" height="345" src="https://www.youtube.com/embed/C0DPdy98e4c"></iframe>
				<a download href="Modeles.zip">Télécharger les plugins QGIS de créations de modèles</a>
			</div>
			<form id='redirect_html'>

			  <div>
			    <input type="radio" id="fr" name="language" value="fr">
			    <label for="fr">Français</label><br><br>
			    <input type="radio" id="en"
			     name="language" value="en">
			    <label for="en">English</label><br /><br />
				<?php if (isset($_SESSION['statut']) AND $_SESSION['statut']=='admin')
					{
					?>
					 <a href="calcul.php">Résultat du vote</a><br /><br />
					 <a href="CONFIG/question.php">RESET</a>
					 <?php
					 } 
				?>
			  </div>
			</form>
		</div>
	</body>
	<script type="text/javascript" src="CARTIQ/script/changelanguage.js"></script>
</html>
<?php
    }


    else
    {
        header("location:index.php");
        exit;
    }
    ?>
