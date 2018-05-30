<?php

    // Necessite le fichier database.php
    require 'database.php';
    // Sécurité et nettoyage d'une valeur du GET
    if(!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }

    // Si des valeurs sont présentes dans le POST
    if(!empty($_POST)) {
        $id = checkInput($_POST['id']);

        // Connexion à la base de données
        require '../identifiants.php';
        $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
        $connection = $db->connect();
        // Préparation de la sélection des données à supprimer dans la base de données
//---------- LIGNES DESACTIVEES POUR LA DEMO ----------
        $statement = $connection->prepare("DELETE FROM items WHERE id = ?;");
        // Suppression des données de la base de données
        $statement->execute(array($id));
        // Déconnexion de la base de données
        $db->disconnect();
        // Retour à la page index.php
        header("Location: index.php");
    }

    // Fonction de nettoyage d'une valeur
    function checkInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>

<html>

    <head>
        <!--Titre de l'onglet-->
        <title>Admin(Supprimer)</title>
        <!--Utilisation de l'unicode-->
        <meta charset="utf-8">
        <!--Utilisation du responsive!-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Utilisation de la police d'écriture Holtwood+One+SC!-->
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
        <!--Utilisation du CSS de bootstrap!-->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <!--Utilisation du jQuery!-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!--Utilisation JS de bootstrap!-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--Utilisation CSS local!-->
        <link href="../css/style.css" rel="stylesheet" type="text/css">
    </head>

       <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
        <!--Bootstrap : container-->
        <div class="container admin">
            <!--Titre-->
            <h1><strong>Supprimer un produit</strong></h1>
            <br>
            <!--Formulaire-->
            <form class="form" role="form" method ="POST" action="delete.php">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <p class="alert alert-warning">Etes-vous sûr de vouloir supprimer</p>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning">Oui</button>
                    <a class="btn btn-default" href="index.php">Non</a>
               </div>
            <!--fin Formulaire-->
            </form>
        <!--Bootstrap : fin container-->
        </div>
    </body>
</html>
