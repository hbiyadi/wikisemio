<?php
session_start();
$idpseudo = 'pseudo2';
$var=0;
if (isset($_SESSION['id']) && $_SESSION['id'] == 'pseudo3')
{
  $idpseudo = 'pseudo3';
  $var=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Teletiq</title>
<link rel="stylesheet" type="text/css" href="CARTIQ/css.css" />
</head>

<body>
<!--<div class="center-div">-->
<form method="post" action="CONFIG/connect.php">
    <div class="header">
      <h1>Teletiq</h1>
    </div>
    <!--<h1>Teletiq</h1>-->
    <div class="row">
          <div class="column" style="background-color:#ADD8E6;">
            <h2>Connexion</h2>
                <p class="statut"><label for="statut">Statut :</label></p>
                    
                      <input type="radio" id="admin" name="statut" value="admin" required />Administrateur
                	    <input type="radio" id="user" name="statut" value="user" required />Utilisateur  
                     
                            
                  
                  <p><label for="pseudo">Login :</label></p>
                   <input type="text" name="pseudo" id="pseudo" required="required" onblur="verif(this)" />
                   

                   <p><label for="pass">Mot de passe :</label></p>
                   <input type="password" name="pass" id="pass" required="required" onblur="verif(this)" />
                   
                   <p><input type="submit" value="Je me connecte" id="submit" /></p>
               </p>
         </div>
</form>

          <div class="column" style="background-color:#87CEFA;"><h2>Inscription</h2>
            <form method="post" action="CONFIG/register.php">
           <p><label for="pseudo2">Saisissez votre login :</label></p>
                   <input type="text"  onblur="verif(this)" name="pseudo2" id=<?php echo $idpseudo ?>  required />
                   <?php if ($var)
                   {
                      ?>
                   
                   <br /><span class="message">Login déjà existant. Veuillez insérer un nouveau.</span>
                   <?php
                    }
                   ?>   
                   

                   <p><label for="pass">Saisissez votre mot de passe :</label></p>
                   <input type="password" name="pass2" id="pass2" required onblur="verif(this)"/>
                   
                   <p><label for="pass">Confirmez votre mot de passe :</label></p>
                   <input type="password" name="pass3" id="pass3" required onkeyup="verifMdp2(this)" onblur="verif(this)"/>


                   <p><input type="submit" value="Je m'inscris" id="submit"/></p></div>
                 </form>
    </div>

<div class="footer"></div>
<!--</div>-->
</body>
</html>

<script type="text/javascript">
function surligne(champ, erreur)
{
   if(erreur)
      champ.style.borderColor = "#FF0000";
    else
      champ.style.borderColor = "#0000FF"; 
}
 
function verifMdp2(champ)
{
   if(champ.value != document.getElementById('pass2').value)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verif(champ)
{
   if(champ.value == "")
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

</script>


<?php
$_SESSION = array();
?>
