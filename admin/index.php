<!DOCTYPE html>

<html>

    <head>
        <!--Titre de l'onglet-->
        <title>Admin</title>
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
                <a href="../" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                <!--Titre-->
                <h1><strong>Liste des produits</strong>
                <!--Bouton-->
                <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
                </h1>
                <!--Bootstrap : Tableau-->
                <table class="table table-striped table-bordered">
                    <!--Entête-->
                    <thead>
                        <!--Ligne 1-->
                        <tr>
                            <!--Colonnes-->
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!--Tableau-->
                    <tbody>
                        <!--Récupération de la base de données-->
                        <?php
                            // Necessite le fichier database.php
                            require 'database.php';
                            // Connexion à la base de données
                            require '../identifiants.php';
                            $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
                            $connection = $db->connect();
                            // Sélection des données nécessaires depuis la base de données
                            $statement = $connection->query(
                                'SELECT
                                items.id,
                                items.name,
                                items.description,
                                items.price,
                                categories.name AS category_name
                                FROM items
                                LEFT JOIN categories
                                ON items.category = categories.id
                                ORDER BY items.id DESC;'
                            );

                            // Récupération de chaque ligne sélectionnée de la base de données
                            while($item = $statement->fetch()) {

                            // <!--Affichage html--->
                            echo '<tr>';
                                echo '<td>' . $item['name'] . '</td>';
                                echo '<td>' . $item['description'] . '</td>';
                                echo '<td>' . number_format((float)$item['price'], 2, '.', '') . '</td>';
                                echo '<td>' . $item['category_name'] . '</td>';
                                echo '<td width =300>';
                                    echo '<a href="view.php?id='. $item['id'] . '" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Voir</a> ';
                                    echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a> ';
                                    echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a> ';
                                echo '</td>';
                            echo '</tr>';

                            }

                            // Deconnexion de la base de données
                            $db->disconnect();

                        ?>

                    </tbody>
                <!--Bootstrap : fin Tableau-->
                </table>
            <!--Bootstrap : fin responsive - Ligne-->
            </div>
        <!--Bootstrap : fin container-->
        </div>

    </body>

</html>
