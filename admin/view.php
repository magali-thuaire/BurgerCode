<?php

    // Necessite le fichier database.php
    require 'database.php';
    // Sécurité et nettoyage d'une valeur du GET
    if(!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }
    // Connexion à la base de données
    require '../identifiants.php';
    $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
    $connection = $db->connect();
    // Préparation de la sélection des données nécessaires depuis la base de données
    $statement = $connection->prepare("
    SELECT
    items.id,
    items.name,
    items.description,
    items.price,
    items.image,
    categories.name AS category_name
    FROM items
    LEFT JOIN categories
    ON items.category = categories.id
    WHERE items.id = ?;
    ");
    // Sélection des données nécessaires depuis la base de données
    $statement->execute(array($id));
    $item = $statement->fetch();
    // Déconnexion de la base de données
    $db->disconnect();

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
        <title>Admin(Voir)</title>
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
            <!--Bootstrap : responsive - Ligne-->
            <div class="row">
                <!--Bootstrap : responsive - Colonne 1/2-->
                <div class="col-sm-6">
                    <!--Titre-->
                    <h1><strong>Voir un produit</strong></h1>
                    <br>
                    <!--Formulaire-->
                    <form>
                        <div class="form-group">
                            <label>Nom :</label><?php echo ' ' . $item['name']; ?>
                        </div>
                        <div class="form-group">
                            <label>Description :</label><?php echo ' ' . $item['description']; ?>
                        </div>
                        <div class="form-group">
                            <label>Prix :</label><?php echo ' ' . number_format((float)$item['price'], 2, '.', '') . " €"; ?>

                        </div>
                        <div class="form-group">
                            <label>Catégorie :</label><?php echo ' ' . $item['category_name']; ?>
                        </div>
                        <div class="form-group">
                            <label>Image :</label><?php echo ' ' . $item['image']; ?>
                        </div>
                    <!--fin Formulaire-->
                    </form>
                    <br>
                    <div class="form-actions">
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                <!--Bootstrap : fin responsive - Colonne 1/2-->
                </div>

                <!--Bootstrap : responsive - Colonne 2/2-->
                <div class="col-sm-6 site">
                    <!--Bootstrap : vignette-->
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' . $item['image']; ?>">
                        <p class="price"><?php echo number_format((float)$item['price'], 2, '.', ''); ?> €</p>
                        <!--Bootstrap : menu sous image-->
                        <div class="caption">
                            <h4><?php echo $item['name']; ?></h4>
                            <p><?php echo $item['description']; ?></p>
                            <a href="#" class="btn btn-order" rol="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                        </div>
                    <!--Bootstrap : fin vignette-->
                    </div>
                <!--Bootstrap : fin responsive - Colonne 2/2-->
                </div>

            <!--Bootstrap : fin responsive - Ligne-->
            </div>
        <!--Bootstrap : fin container-->
        </div>

    </body>

</html>
