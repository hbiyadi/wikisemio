<?php
//ouverture du fichier
$myfile = fopen("../CONFIG/zones.txt", "r") or die("Unable to open file!");
$i = 0;
while(!feof($myfile)) 
{
  $vdvb[$i] = trim(fgets($myfile));
  	if ($vdvb[$i] != ""){
  //Lecture d'une ligne du fichier
  $les_noms[] = $vdvb[$i];
  $ma_liste[] = fgets($myfile);
  $ma_cle[] = fgets($myfile);
  $i++;
  }
}
fclose($myfile);
?>
