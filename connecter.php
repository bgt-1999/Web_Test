<?php
  
  session_start();

	require_once 'webpage.class.php';
	require_once 'myPDO.include.php' ;

	$p = new webpage();
	$p->setTitle('Inscrire');
	$p->appendCssUrl("css/bootstrap.min");

  $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');

  if ($_SESSION['id']!=0)
  {
    echo "<p>Vous êtes deja conneté</p>";
  } 

  else
  {
    $message='';

    if (empty($_POST['email']) || empty($_POST['mot_de_passe']) ) //Oublie d'un champ
    {
        $message = '<p>une erreur s\'est produite pendant votre identification.
        Vous devez remplir tous les champs</p>
        <p>Cliquez <a href="./connexion.php">ici</a> pour revenir</p>';
    }

    else //On check le mot de passe
    {
        $stmt=$bdd->prepare(<<<SQL
        SELECT id, prenom, nom, email, mot_de_passe, pseudo
        FROM membre 
        WHERE email = :email;
SQL
  ) ;
        $stmt->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
        $stmt->execute();
        $data=$stmt->fetch();

        if ($data['mot_de_passe'] == $_POST['mot_de_passe']) // Acces OK !
        {
            $_SESSION['pseudo'] = $data['pseudo'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $data['id'];
            $message = '<p>Bienvenue '.$data['pseudo'].', 
            vous êtes maintenant connecté!</p>
            <p>Cliquez <a href="./index.php">ici</a> 
            pour revenir à la page d accueil</p>';  
        }

        else // Acces pas OK !
        {
            $message = '<p>Une erreur s\'est produite 
            pendant votre identification.<br /> Le mot de passe ou le pseudo 
                  entré n\'est pas correcte.</p><p>Cliquez <a href="./connexion.php">ici</a> 
            pour revenir à la page précédente
            <br /><br />Cliquez <a href="./index.php">ici</a> 
            pour revenir à la page d accueil</p>';
        }
      $stmt->CloseCursor();
    }
    echo $message.'</div></body></html>';

}
	echo $p->toHTML();