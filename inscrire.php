<?php
	require_once 'webpage.class.php';
	require_once 'myPDO.include.php' ;

	$p = new webpage();
	$p->setTitle('Inscrire');
	$p->appendCssUrl("css/bootstrap.min");

	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');

	$stmt=$bdd->prepare(<<<SQL
        SELECT email, mot_de_passe
        FROM membre 
        WHERE email = :email
        OR mot_de_passe = :mot_de_passe;
SQL
  ) ;
        $stmt->execute(array(":email" => $_POST['email'], ":mot_de_passe" => $_POST['mot_de_passe']));
        $exist=$stmt->fetch();

        if($exist != null)
        {
        	header('Location: inscription.html');
        }

        else
        {
        	$stmt = $bdd->prepare(<<<SQL
          INSERT INTO MEMBRE (nom, prenom, pseudo, email, age, mot_de_passe)
          VALUES(?, ?, ?, ?, ?, ?);
SQL
      ) ;
    $stmt->execute(array($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['email'], $_POST['age'], $_POST['mot_de_passe']));

        }

	
	echo $p->toHTML();
