<?php

session_start();
if ((isset($_SESSION['connect']) AND $_SESSION['connect']==1) AND (isset($_SESSION['statut']) AND $_SESSION['statut']=='admin'))//On vérifie que le variable existe.
{
        $connect=$_SESSION['connect'];//On récupère la valeur de la variable de session.
}
else
{
        $connect=0;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0".
}
       
if ($connect == 1) // Si le visiteur s'est identifié.
{
	$resultats = array();
	$nb_question = 0;

	$mon_fichier = fopen("evaluation.txt", "r") or die ("Unable to open file!");
	while (!feof($mon_fichier))
	{
			$question = fgets($mon_fichier);
			if(trim($question) != "")
			{
				$myfile = fopen("../dokuwiki/data/meta/".trim($question), "r") or die("Unable to open file!");



				$nb_votes = 0;
				$ma_liste = array();
				$i = 0;
				// Output one line until end-of-file
				while(!feof($myfile)) 
				{
				  $ma_liste[$i] = fgets($myfile);
				  if(trim($ma_liste[$i]) != "")
				  	$nb_votes++;
				  //echo fgets($myfile);
				  $i++;
				}
				fclose($myfile);
				$somme = 0;
				for ($j = 0; $j < $nb_votes; $j++) 
				{
				    $somme = $somme + $ma_liste[$j][0];
				}
				
				if($nb_votes != 0)
					$resultats[] = $somme/$nb_votes;
				else
					$resultats[] = 0;

				$nb_question++;
			}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>RESULTATS</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style2-4.css">


</head>

<body>
	<a href=javascript:history.go(-1) class="retour"><img src="../CARTIQ/IMG/image1.png" alt="" class="image1" />Retour</a>

	<h1> Résultats </h1>
	<table>
		<tr>
			<th> Questions </th>
			<th> Nombre moyen de votes </th>
		</tr>
<?php 
	for($i = 0; $i < $nb_question; $i++)
	{
?>
		<tr>
			<td> <?php echo "Question ".($i+1); ?> </td>
			<td> <?php echo round($resultats[$i],2); ?> </td>
		</tr>
<?php
	}
?>
	</table>

</body>
</html>
<?php
    }
    
    else
    {
        header("location:../index.php");
        exit;
    }
    ?>
