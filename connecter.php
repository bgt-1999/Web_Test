<?php
	require_once 'webpage.class.php';
	require_once 'myPDO.include.php' ;

	$p = new webpage();
	$p->setTitle('Inscrire');
	$p->appendCssUrl("css/bootstrap.min");

	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');

	$stmt = $bdd->prepare(<<<SQL
          SELECT email, mot_de_passe
          FROM membre
          WHERE email = :email
          AND mot_de_passe = :mot_de_passe;
SQL
      ) ;
    if($stmt->execute(array(":email" => $_POST['email'], ":mot_de_passe" => $_POST['mot_de_passe'])) == null) {
        header('Location: connexion.html');
      }
    else
    {
    	header('Location: accueil.html');
    }
	echo $p->toHTML();