<?php

    session_name("admin");
    session_start();

    require_once __DIR__ . ('../../../App/Utiltary/Log.php');
    require_once __DIR__. ('../../../App/models/Admin.php');
    require_once __DIR__. ('../../../App/models/Article.php');
    require_once __DIR__. ('../../../App/models/Categories.php');
    require_once __DIR__. ('../../../App/models/Cover.php');
    require_once __DIR__. ('../../../App/models/Paragraph.php');
    require_once __DIR__. ('../../../App/models/Media.php');

     // Créez une nouvelle instance de Category
    $category = new Category();

     // Récupérez toutes les catégories
    $allCategories = $category->findAllCategories();
    
     // Vérifiez si le formulaire a été soumis
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérez les données du formulaire

            $coverUploaded = false;

            if (isset($_FILES["imageCover"]["name"]) && $_FILES["imageCover"]["name"] != "" && $_FILES["imageCover"]["error"] == 0) {
                // Fichier cover bien reçu ?
                //die("Fichier bien reçu !");
                // créer le fichier de destination s'il n'existe pas

                $uploadDirectory = "../../assets/img/blog/";
                if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true); // Forcer la création des sous-dossiers 
                }

                $tempFile = $_FILES["imageCover"]["tmp_name"];
                $finalFile = $uploadDirectory . $_FILES["imageCover"]["name"];

                move_uploaded_file($tempFile, $finalFile);

                // Si le fichier a bien été conservé :
                $coverUploaded = true;
            }

            if ($coverUploaded) {

                $titleCover = $_POST['titleCover'];
                //$imageCover = $_FILES['imageCover']['name'];
                $title = $_POST['title'];
                $categories = intval($_POST['categories']);
    
                // Vérifiez si la catégorie existe
                $category = new Category();
                $category->setId($categories);
                $categoryResult = $category->findOneCategoryById();

                var_dump($categoryResult);
                var_dump($_POST, $_FILES);
                
                if (!$categoryResult) {
                    echo "La catégorie spécifiée n'existe pas.";
                    return;
                }

                // Assurez-vous que vous avez bien récupéré l'ID de l'administrateur
                $created_by = isset($_SESSION['admin_id']) && !is_null($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 1;
    
                // Créez un nouvel objet Article et enregistrez-le dans la base de données
                $article = new Article(null, $title, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $categoryResult["category_id"], $created_by);

                var_dump($article);
                //die();

                if ($articleResult = $article->createArticle()) {
                    // Créez un nouvel objet Cover avec l'ID de l'article nouvellement créé et enregistrez-le dans la base de données
                    $cover = new Cover(0, $titleCover, $finalFile, $article->getId());

                    var_dump($cover);
                    
                    $coverResult = $cover->createCover();
                    var_dump($coverResult);

                    // insérer les paragraphes dans la base de données

                    $paragraphs = $_POST['content'];
                    foreach ($paragraphs as $index => $paragraphContent) {
                        $paragraph = new Paragraph(null, $paragraphContent, $article->getId());
                            if (!$paragraph->createParagraph()) {
                                var_dump($paragraph);
                                    echo "Une erreur est survenue lors de la création du paragraphe.";
                                    return;
                            }
                        }

   // Insérer les images dans la base de données
if (isset($_FILES["url"]["name"])) {
    $uploadDirectory = "../../assets/img/blog/";
    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true); // Forcer la création des sous-dossiers 
    }

    for ($i = 0; $i < count($_FILES["url"]["name"]); $i++) {
        if ($_FILES["url"]["name"][$i] != "" && $_FILES["url"]["error"][$i] == 0) {
            $tempFile = $_FILES["url"]["tmp_name"][$i];
            $finalFile = $uploadDirectory . $_FILES["url"]["name"][$i];

            move_uploaded_file($tempFile, $finalFile);

            // Créez un nouvel objet Image avec l'ID de l'article nouvellement créé et enregistrez-le dans la base de données
            $image = new Media(null, $finalFile, $article->getId());
            if (!$image->createMedia()) {
                var_dump($image);
                echo "Une erreur est survenue lors de la création du média.";
                return;
            }
        } else {
            echo "Aucune image n'a été téléchargée.";
            return;
        }
    }
}

                
                    if ($articleResult && $coverResult){
                        echo "L'article et la couverture ont été créés avec succès.";
                    } else {
                        echo "Une erreur est survenue lors de la création de la couverture.";
                    }
                } else {
                    echo "Une erreur est survenue lors de la création de l'article.";
                }
                
            }
        }
    } catch (Exception $e) {
        echo 'Exception attrapée : ',  $e->getMessage(), "\n";
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../assets/styles/style.css">
    
</head>
<body class="body_form_article">

    <header class="dashboard">
        <a href="./dashboard.php"><img class="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet"></a>
        <a href="./dashboard.php"><img class="icon_logout" src="../../assets/icons/arrow-right-return.svg" alt=""></a> 
    </header>

    
    <h2 class="title_admin">Création d'article</h2>

    <div class="container_form_create_article">
        <form action="#" method="post" enctype="multipart/form-data">

                <label for="titleCover">Titre de couverture de l'article</label>
                <input class="input-title" type="text" name="titleCover" id="titleCover" autocomplete="titleCover" aria-label="votre titre" required />

                <label for="imageCover">Couverture image</label>
                <input class="input-image" type="file" id="imageCover" name="imageCover" accept="image/png, image/jpeg, image/webp "/>
                

                <label for="title">Titre de l'article</label>
                <input class="input-title" type="text" name="title" id="title" autocomplete="title" aria-label="votre titre d'article" required />
            
                <select class="select-categories" name="categories" id="categories">
                    <option value="">Séléctionner une catégorie</option>
                    <?php foreach ($allCategories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>">
                        <?php echo $category['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <div id="sections">
                    <section>
                        <label for="content">Contenu de l'article</label>
                        <textarea class="textarea-content-article" id="content" name="content[]"></textarea>

                        <label for="url">Image</label>
                        <input class="input-image" type="file" id="url" name="url[]" accept="image/png, image/jpeg, image/webp "/>
                    </section>
                </div>



                <button class="btn_add_article" type="button" id="add-section-btn">Ajouter une section</button>

                <button class="btn_submit_article">Envoyer</button>

            
        </form>
    </div>

    <script src="../../js/add-sections.js"></script>
</body>
</html>