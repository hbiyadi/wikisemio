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
    if ($bdd)
    {
        $conn = pg_pconnect("host=".$hostDB." port=".$portDB." dbname=".$dbnameDB." user=".$userDB." password=".$passwordDB); 
    }
    

        
if (!empty($_POST['pass2']) AND !empty($_POST['pseudo2']) AND !empty($_POST['pass3']))
{
    if ($_POST['pass2'] == $_POST['pass3'])
    {

        $login = htmlspecialchars($_POST['pseudo2']);
        $mdp = htmlspecialchars($_POST['pass2']);
        $mdp=sha1($mdp);
        $statut = 'user';

        $query_rd = "SELECT * FROM connect WHERE login = '$login'";
        $result = pg_query($conn,$query_rd);
        $rows = pg_num_rows($result);
        $var=0;

        if ($rows < 1)
        {
            $req = $bdd->prepare('INSERT INTO connect (login,mdp,statut) VALUES (:login,:mdp,:statut)');
            $req->execute(array('login' => $login,'mdp' => $mdp ,'statut' => $statut));
        }
        else
        {
            $var=1;
        }
    
    }          
}

if ($var == 1)
{
    $_SESSION['id']='pseudo3';    
}
else
{
    $_SESSION['id']='pseudo2';   
}


header("Location:../index.php");
exit();
 

?>