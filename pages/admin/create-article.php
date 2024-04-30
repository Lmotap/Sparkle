<?php

    session_name("admin");
    session_start();

    require_once __DIR__ . ('../../../App/Utiltary/Log.php');
    require_once __DIR__. ('../../../App/models/Admin.php');
    require_once __DIR__. ('../../../App/models/Article.php');
    require_once __DIR__. ('../../../App/models/Categories.php');
    require_once __DIR__. ('../../../App/models/Cover.php');

     // Créez une nouvelle instance de Category
    $category = new Category();

     // Récupérez toutes les catégories
    $allCategories = $category->findAllCategories();
    
     // Vérifiez si le formulaire a été soumis
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérez les données du formulaire
            $titleCover = $_POST['titleCover'];
            $imageCover = $_FILES['imageCover']['name'];
            $title = $_POST['title'];
            $categories = intval($_POST['categories']);
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];

            // Vérifiez si la catégorie existe
            $category = new Category();
            $category->setId($categories);
            $categoryResult = $category->findOneCategoryById();
            var_dump($categoryResult);
            
            if (!$categoryResult) {
                echo "La catégorie spécifiée n'existe pas.";
                return;
            }
            // Créez un nouvel objet Article et enregistrez-le dans la base de données
            $article = new Article(0, $title, $content, $image, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            $articleResult = $article->createArticle();
            var_dump($articleResult);

            // Vérifiez si la création de l'article a réussi
            if ($articleResult['success']) {
                // Créez un nouvel objet Cover avec l'ID de l'article nouvellement créé et enregistrez-le dans la base de données
                $cover = new Cover(0, $titleCover, $imageCover, $articleResult['id']);
                $coverResult = $cover->createCover();
                var_dump($coverResult);;
    
            
                    if ($coverResult['success']) {
                        echo "L'article et la couverture ont été créés avec succès.";
                    } else {
                        echo "Une erreur est survenue lors de la création de la couverture.";
                    }
                } else {
                    echo "Une erreur est survenue lors de la création de l'article.";
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

                <label for="content">Contenu de l'article</label>
                <textarea class="textarea-content-article" id="content" name="content"></textarea>

                <label for="image">Image</label>
                <input class="input-image" type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp "/>

                <label for="content">Contenu de l'article</label>
                <textarea class="textarea-content-article" id="content" name="content"></textarea>

                <label for="image">Image</label>
                <input class="input-image" type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp "/>

                <button class="btn_submit_article" type="submit">Envoyer</button>

            
        </form>
    </div>

</body>
</html>