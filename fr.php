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
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>WIKISEMIO</title>
	<!-- <meta name="robots" content="noindex,follow" /> -->
	<link rel="stylesheet" type="text/css" href="CARTIQ/style.css">
	</head>
	<?php include './CONFIG/conf.php';?>
	
		<div id="contenu">
			<frameset cols="63%,37%">
				<frame src="CARTIQ/index_fr.php" name='CARTIQ'>
				<frame src="dokuwiki/index.php" name='WIKITIQ' target="WIKITIQ">
			</frameset>
		</div>
</html>
<?php
    }


    else
    {
        header("location:index.php");
        exit;
    }
    ?>

    

