<!DOCTYPE html>

<html>

    <head>
        <!--Titre de l'onglet-->
        <title>Burger Code</title>
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
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <!--Bootstrap : container-->
        <div class="container site">
            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>

            <?php

                // Necessite le fichier database.php
                require 'admin/database.php';

                // Connexion à la base de données
                require 'identifiants.php';
                $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
                $connection = $db->connect();
                // Récupération des données nécessaires depuis la base de données
                $statement = $connection->query("SELECT * FROM categories;");
                $categories = $statement->fetchAll();

                // <!--Bootstrap : Barre de navigation par onglets-->
                echo '<nav>';
                    // <!--Bootstrap : Liste des onglets-->
                    echo '<ul class="nav nav-pills">';
                    // <!--Bootstrap : Liens vers les onglets-->
                    foreach($categories as $category) {

                        if($category['id'] == '1') {

                            echo '<li role="presentation" class="active"><a href="#'. $category["id"] . '" data-toggle="tab">' . $category['name'] . '</a></li>';

                        } else {

                            echo '<li role="presentation"><a href="#'. $category["id"] . '" data-toggle="tab">' . $category['name'] . '</a></li>';

                        }
                    }
                    ?>
                    <li class="navbar-right"><a href="admin/index.php">Espace administrateur</a></li>'
                    <?php
                    echo '</ul>';
                echo '</nav>';

                // <!--Bootstrap : Onglets-->
                echo '<div class="tab-content">';

                // <!--Bootstrap : Onglet x-->
                foreach($categories as $category) {

                    if($category['id'] == '1') {

                        echo '<div class="tab-pane active" id="'. $category["id"] . '">';

                    } else {

                        echo '<div class="tab-pane" id="'. $category["id"] . '">';

                    }

                    // <!--Bootstrap : responsive - Ligne--->
                    echo '<div class="row">';

                    // Préparation de la sélection des données nécessaires depuis la base de données
                    $statement = $connection->prepare ('SELECT * FROM items WHERE items.category = ?');
                    // Insertion des données récupérées depuis la base de données
                    $statement->execute(array($category['id']));

                    while($item = $statement->fetch()) {

                        // <!--Bootstrap : responsive - Colonne--->
                        echo '<div class="col-sm-6 col-md-4">';
                            // <!--Bootstrap : responsive - vignette--->
                            echo '<div class="thumbnail">';
                                // <!--Image--->
                                echo '<img src="images/' . $item['image'] . '" alt="...">';
                                // <!--Prix--->
                                echo '<p class="price">' . number_format($item['price'], 2, '.', '') . ' €</p>';
                                // <!--Bootstrap : menu sous image--->
                                echo '<div class="caption">';
                                    // <!--Nom--->
                                    echo '<h4>' . $item['name'] . '</h4>';
                                    // <!--Description--->
                                    echo '<p>' . $item['description'] . '</p>';
                                    // <!--Bouton--->
                                    echo '<a href="#" class="btn btn-order" rol="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                                // <!--Bootstrap : fin menu sous image--->
                                echo '</div>';
                            // <!--Bootstrap : fin vignette--->
                            echo '</div>';
                        // <!--Bootstrap : fin responsive - Colonne--->
                        echo '</div>';
                    }

                    // <!--Bootstrap : fin responsive - Ligne--->
                    echo '</div>';
                // <!--Bootstrap : fin Onglet x-->
                echo '</div> ';

                }

                // Deconnexion de la base de données
                $db->disconnect();

                // <!--Bootstrap : fin Onglets-->
                echo '</div> ';

            ?>

            <!--Bootstrap : fin container-->
            </div>

    </body>

</html>
