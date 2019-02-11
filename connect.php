
<?php include '../CONFIG/conf.php'; ?>

<?php
session_start();

    
   try
    {
        $bdd = new PDO("pgsql:dbname=$dbnameDB;host=$hostDB; port=$portDB", $userDB , $passwordDB );//";charset=utf8"
        $bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch(Exception $e)
    {
        die("Une erreur a été trouvée : " . $e->getMessage());
    }

        
if (!empty($_POST['pass']) AND !empty($_POST['pseudo']) AND isset($_POST['statut']))    
{
        $login = htmlspecialchars($_POST['pseudo']);
        $mdp = htmlspecialchars($_POST['pass']);
        $mdp = sha1($mdp);
        $statut = $_POST['statut'];


                //  Récupération de l'utilisateur et de son pass hashé
                $req = $bdd->prepare('SELECT mdp FROM connect WHERE login = :login AND statut = :statut');
                $req->execute(array('login' => $login, 'statut' => $statut));
                $resultat = $req->fetch();


                // Comparaison du pass envoyé via le formulaire avec la base
                $isPasswordCorrect = ($mdp == $resultat['mdp']);

                if ($isPasswordCorrect) {
                    
                    $_SESSION['connect']=1;
                    if ($statut == 'admin')
                    {
                        $_SESSION['statut']='admin';
                    }
                    header("location:../index1.php");
                    exit();
                }
        
                else
    	       {
    			$_SESSION = array();
    			session_destroy();
            	header("location:../index.php");
        		exit();
    	       }
}
else
{
        $_SESSION = array();
        session_destroy();
        header("location:../index.php");
        exit();
}
?>

