<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    include "./config/db.php";
    // créer une connexion à la BD
    try {
        $db = new PDO(DBDRIVER . ': host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME .
            ';charset=' . DBCHARSET, DBUSER, DBPASS);
    } catch (Exception $e) {
        echo "Erreur";
        die();
    }
    include_once "Livre.php";
    include_once "LivreManager.php";

    $livreManager = new LivreManager($db);
    // $livresArray = $livreManager->selectAll();
    // var_dump ($livresArray);

    $livresObjetsArray = $livreManager->selectAll();

    var_dump($livresObjetsArray[5]);
    // effacer en envoyant un objet
    // $livreManager->delete ($livresObjetsArray[5]);
    // effacer en envoyant un id
    // $livreManager->deleteParId (9);

    $mesLivresFiltres = $livreManager->selectFiltres([
        'titre' => 'La guerre de Togo',
        'prix' => 18
    ]);
    // var_dump ($mesLivresFiltres);
    $mesLivresFiltresSansFiltres = $livreManager->selectFiltres();
    // var_dump ($mesLivresFiltresSansFiltres); 

    $nouvelLivreArray = [
        'titre' => 'Coucou 102',
        'prix' => 20,
        'description' => 'Kelly Kapowski',
        'date_publication' => '2000-09-29',
        'isbn' => '4235234523452345',
        'auteur_id' => 2
    ];

    // object livre à insèrer 
    $nouveauLivre = new Livre($nouvelLivreArray); // le livre à insèrer, n'a pas un id

    // chercher si un tel livre existe (les mêmes valeurs sauf l'id!)

    $livreTrouve = $livreManager->selectFiltres($nouvelLivreArray);
    if (!empty($livreTrouve)) { // si le select trouve le livre, l'array ne sera pas vide
        echo "<h5>Le livre est déjà dans la BD</h5>";
    } else {
        $livreManager->insert($nouveauLivre); // nouvel id dans la BD
    }

    // update d'un livre qu'on vient d'insèrer
    $nouveauLivre->setTitre("Vive les frites II");
    // var_dump ($nouveauLivre);
    $livreManager->update($nouveauLivre);
    // $livreManager->updateAuto($nouveauLivre);








    // $l1 = new Livre (1,"Coucou",45.... etc...)
    // $l1 = new Livre (,,45.... etc...) // non!
    // $l1 = new Livre([
    //     'id' => 1,
    //     'titre' => 'Coucou',
    //     'prix' => 22
    // ]);

    // $l2 = new Livre([
    //     'titre' => 'Coucou'
    // ]);

    // $l2->hydrate(['id' => 2,
    //         'prix' => 22]);

    // créer un objet
    // $l1 = new Livre([
    //     // 'id' => 1,
    //     'titre' => 'Coucou',
    //     'prix' => 22,
    //     'isbn' => '233242342344'
    // ]);
    // var_dump($l1);

    // $l1->setTitre("Lala");
    // $l1->setIsbn(324234234);
    // $l1->setPrix(22);
    // trop long!!!

    // si on veut changer un objet déjà créé
    // $l1->hydrate([
    //     'titre' => 'Lala',
    //     'prix' => 22
    // ]);






    ?>
</body>

</html>