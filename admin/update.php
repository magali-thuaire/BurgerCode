<?php

    // Necessite le fichier database.php
    require 'database.php';

    // Sécurité et nettoyage d'une valeur du GET
    if(!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }

    $name = $description = $price = $category = $image = $nameError = $descriptionError = $priceError = $categoryError = $imageError = "";

    // Submit a été demandé => des valeurs sont présentes dans le POST
    if(!empty($_POST)) {
        $name               = checkInput($_POST['name']);
        $description        = checkInput($_POST['description']);
        $price              = checkInput($_POST['price']);
        $category           = checkInput($_POST['category']);
        $image              = checkInput($_FILES["image"]["name"]);
        $imagePath          = '../images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;

        // Vérification que le champ "nom" ne soit pas vide
        if(empty($name)) {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }

        // Vérification que le champ "description" ne soit pas vide
        if(empty($description)) {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }

        // Vérification que le champ "prix" ne soit pas vide
        if(empty($price)) {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }

        // Vérification que le champ "category" ne soit pas vide
        if(empty($category)) {
            $categoryError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }

        // Vérification du champ "image"
        // Lorsque l'image n'est pas modifiée
        if(empty($image)) {

            $isImageUpdated = false;

        // Lorsque l'image est modifiée
        } else {

            $isImageUpdated = true;
            $isUploadSuccess = true;

            // Vérification de l'extension de l'image
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) {

                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }

            // Vérification du nom de l'image
            if(file_exists($imagePath)) {

                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;

            }

            // Vérification de la taille de l'image
            if($_FILES["image"]["size"] > 500000) {

                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }

            // Vérification du téléchargement de l'image
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageError = "Il y a eu une erreur lors du téléchargement";
                    $isUploadSuccess = false;
                }
            }
        }

        // Si tous les champs sont valides et si le téléchargement de l'image modifiée a abouti
        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
            // Connexion à la base de données
            require '../identifiants.php';
            $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
            $connection = $db->connect();

            // Si l'image a été modifiée : mise à jour de toutes les données
            if($isImageUpdated) {
                $statement = $connection->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?;");
            // Insertion des données récupérées à la base de données
                $statement->execute(array($name,$description,$price,$category,$image,$id));

            // Si l'image n'a pas été modifiée : mise à jour de toutes les données hors images
            } else {
                $statement = $connection->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ? WHERE id = ?;");
            // Insertion des données récupérées à la base de données
                $statement->execute(array($name,$description,$price,$category,$id));
            }

            // Déconnexion de la base de données
            $db->disconnect();
            // Retour à la page index.php
            header("Location: index.php");

        }
        // Si tous les champs sont valides et si le téléchargement de l'image modifiée n'a pas abouti
        else if($isImageUpdated && !$isUploadSuccess) {
            // Connexion à la base de données
            require '../identifiants.php';
            $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
            $connection = $db->connect();
            // Préparation de la sélection des données nécessaires depuis la base de données
                $statement = $connection->prepare("SELECT image FROM items WHERE id = ?;");
            // Insertion des données récupérées depuis la base de données
                $statement->execute(array($id));
                $item = $statement->fetch();
                $image = $item['image'];
        }

    // Submit n'a pas été demandé => arrivée sur la page
    } else {

        // Connexion à la base de données
        require '../identifiants.php';
        $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
        $connection = $db->connect();

        // Préparation de la sélection des données nécessaires depuis la base de données
        $statement = $connection->prepare("SELECT * FROM items WHERE id= ?;");

        // Sélection des données nécessaires depuis la base de données
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name               = $item['name'];
        $description        = $item['description'];
        $price              = $item['price'];
        $category           = $item['category'];
        $image              = $item['image'];

        // Déconnexion de la base de données
        $db->disconnect();
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
        <title>Admin(Modifier)</title>
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
            <h1><strong>Modifier un produit</strong></h1>
            <br>
            <!--Bootstrap : responsive - Ligne-->
            <div class="row">
                <!--Bootstrap : responsive - Colonne 1/2-->
                <div class="col-sm-6">
                    <!--Formulaire-->
                    <form class="form" role="form" method ="post" action="<?php echo 'update.php?id='. $id;?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="price">Prix : (en €)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie:</label>
                            <select class="form-control" id="category" name="category">
                             <?php
                                // Connexion à la base de données
                                require '../identifiants.php';
                                $db = new Database($dbHost, $dbName, $dbUser, $dbUserPass);
                                $connection = $db->connect();
                                // Sélection des données nécessaires depuis la base de données
                                foreach($connection->query('SELECT * FROM categories;') as $row){

                                    if($row['id'] = $category) {
                                        echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }

                                }
                                // Déconnexion de la base de données
                                $db->disconnect();
                            ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image :</label>
                            <p><?php echo $image;?></p>
                            <label for="image">Sélectionner une image:</label>
                            <input type="file" id="image" name="image">
                            <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    <!--fin Formulaire-->
                    </form>
                <!--Bootstrap : fin responsive - Colonne 1/2-->
                </div>

                <!--Bootstrap : responsive - Colonne 2/2-->
                <div class="col-sm-6 site">
                    <!--Bootstrap : vignette-->
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' . $image; ?>">
                        <p class="price"><?php echo number_format((float)$price, 2, '.', ''); ?> €</p>
                        <!--Bootstrap : menu sous image-->
                        <div class="caption">
                            <h4><?php echo $name; ?></h4>
                            <p><?php echo $description; ?></p>
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
