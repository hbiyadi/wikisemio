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

	//ouverture du fichier
	$fichier = fopen("questions.txt", "r") or die("Unable to open file!");
	while(!feof($fichier)) 
	{
	  //Lecture d'une ligne du fichier
	  $les_id[] = fgets($fichier);
	  $question[] = fgets($fichier);
	}
	fclose($myfile);

	//$question = file("questions.txt");
	$top = file("top.txt");
	$bottom = file("bottom.txt");
	$myfile = fopen("../dokuwiki/data/pages/start_fr.txt", "w+") or die("Unable to open file!");
	if($myfile)
	{
		for($i=0; $i<count($top); $i++){
			fputs($myfile,$top[$i]);
		}
		
		for($i=0; $i<count($question); $i++){
			if(trim($les_id[$i]) != "")
			{
				fputs($myfile,"{(rater>id=".$les_id[$i]."|name=".$question[$i]."| type=rate|trace=user|tracedetails=1)}");
			}
		}


		for($i=0; $i<count($bottom); $i++){
			fputs($myfile,$bottom[$i]);
		}
	}
	fclose($myfile);
	$evaluation = fopen("evaluation.txt", "w+") or die("Unable to open file!");
	if($evaluation)
	{
		for($i=0; $i<count($question); $i++)
		{
			$question[$i] = str_replace(array("é", "è"), "e", $question[$i]);
			$question[$i] = str_replace("?", "", $question[$i]);

			$keywords = preg_split("/[\s,]+/", trim($question[$i]));
			if(trim($les_id[$i]) != "")
			{
				$ligne = "rater_".trim($les_id[$i])."_";
				for($j = 0; $j < count($keywords); $j++)
				{
					$ligne = $ligne.lcfirst($keywords[$j])."_";
				}
				$ligne = $ligne."rate.rating";
				if ($i == count($question) - 1)
				{
						fputs($evaluation, $ligne);
				}
				else
				{
					fputs($evaluation, $ligne."\n");
				}
			}
		}
	}
	fclose($evaluation);
	header("location:../index1.php");
    exit;
}

else
    {
        header("location:index.php");
        exit;
    }

?>