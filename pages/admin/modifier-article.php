<?php


require_once __DIR__ . ('../../../App/Utiltary/Log.php');
require_once __DIR__. ('../../../App/models/Admin.php');
require_once __DIR__. ('../../../App/models/Article.php');
require_once __DIR__. ('../../../App/models/Categories.php');
require_once __DIR__. ('../../../App/models/Cover.php');
require_once __DIR__. ('../../../App/models/Paragraph.php');
require_once __DIR__. ('../../../App/models/Media.php');

session_name("admin");
session_start();




$category = new Category();

$allCategories = $category->findAllCategories();

$articleId = $_GET['id'];



// Créez une nouvelle instance d'Article
$article = new Article();

// Récupérez toutes les informations de l'article
$fullArticle = $article->getFullArticle($articleId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Récupérez les valeurs du formulaire
    $title = isset($_POST['title']) ? $_POST['title'] : $fullArticle['article'][0]['title'];
    $category = isset($_POST['category']) ? $_POST['category'] : $fullArticle['article'][0]['category'];
    $created_by = isset($_POST['created_by']) ? $_POST['created_by'] : $fullArticle['article'][0]['created_by'];

    // Mettez à jour l'article
    $article->setTitre($title);
    $article->setCategory($category);
    $article->setAdmin($created_by);

    // Créez une nouvelle instance de Cover
    $cover = new Cover();

    // Définissez l'ID de l'article
    $article->setId($articleId);

    // Définissez l'ID de l'article pour Cover, Paragraph et Media
    $cover->setArticle($articleId);


    

    // Récupérez les paragraphes de l'article
$newContents = isset($_POST['content']) ? $_POST['content'] : array();

// Créez une nouvelle instance de Paragraph
$paragraph = new Paragraph();

// Récupérez les informations des paragraphes de l'article
$paragraphs = $paragraph->findParagraphsByArticleId($articleId);

// Parcourez chaque paragraphe
foreach ($paragraphs as $index => $paragraphData) {
    // Définissez l'ID de l'article
    $paragraph->setArticleId($articleId);

    // Définissez l'ID du paragraphe
    $paragraph->setParagraphId($paragraphData['paraph_id']);

    // Définissez le contenu du paragraphe
    $paragraph->setContent($newContents[$index]);

    // Mettez à jour le paragraphe
    $result = $paragraph->updateParagraph();
}

// Récupérez les médias de l'article
$newMedia = isset($_POST['media']) ? $_POST['media'] : array();

// Créez une nouvelle instance de Media
$media = new Media();

// Récupérez les informations des médias de l'article
$mediaItems = $media->findMediaByArticleId($articleId);

// Parcourez chaque média
foreach ($mediaItems as $index => $mediaData) {
    // Définissez l'ID de l'article
    $media->setArticleId($articleId);

    // Définissez l'ID du média
    $media->setMediaId($mediaData['media_id']);

    // Vérifiez si l'index existe dans le tableau
    if (isset($_FILES["url"]["name"][$index]) && $_FILES["url"]["name"][$index] != "" && $_FILES["url"]["error"][$index] == 0) {
        $uploadDirectory = "../../assets/img/media/";
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $tempFile = $_FILES["url"]["tmp_name"][$index];
        $finalFile = $uploadDirectory . $_FILES["url"]["name"][$index];

        move_uploaded_file($tempFile, $finalFile);

        // Définissez le contenu du média
        $media->setURL($finalFile);
    }

    // Mettez à jour le média
    $result = $media->updateMedia();
}

    // Récupérez les informations de la couverture pour l'article
    $coverInfo = $cover->findCoverByArticleId($articleId);

    // Définissez l'ID de la couverture
    $cover->setCoverId($fullArticle['cover']['cover_id']); 

    // Récupérez les valeurs du formulaire
    $titleCover = isset($_POST['titleCover']) ? $_POST['titleCover'] : $fullArticle['cover']['titleCover'];
    $imageCover = isset($_FILES['imageCover']) ? $_FILES['imageCover'] : null; // Vous devrez gérer le téléchargement du fichier séparément

    // Mettez à jour la couverture
    $cover->setTitreCover($titleCover);

    // Gérez le téléchargement du fichier de couverture
    if ($imageCover !== null) {
        $coverUploaded = false;

        $finalFile = $fullArticle['cover']['imageCover']; // Utilisez l'image de couverture existante par défaut

        if (isset($_FILES["imageCover"]["name"]) && $_FILES["imageCover"]["name"] != "" && $_FILES["imageCover"]["error"] == 0) {
            $uploadDirectory = "../../assets/img/blog/";
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
        
            $tempFile = $_FILES["imageCover"]["tmp_name"];
            $finalFile = $uploadDirectory . $_FILES["imageCover"]["name"];
        
            move_uploaded_file($tempFile, $finalFile);
            $coverUploaded = true;
        }
        
            $cover->setImageCover($finalFile);

            // Enregistrez les modifications
            $cover->updateCover();

            // Enregistrez les modifications
            $result = $article->updateArticle();  

            if ($result) {
                echo "L'article a été modifié avec succès.";
            } else {
                echo "Une erreur s'est produite lors de la modification de l'article.";
            }
    }
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

    <input type="hidden" name="articleId" value="<?php echo htmlspecialchars($articleId); ?>">



    
    <h2 class="title_admin">Modifier un article</h2>

    <div class="container_form_create_article">
        <form action="#" method="post" enctype="multipart/form-data">

                <label for="titleCover">Titre de couverture de l'article</label>
                <input class="input-title" type="text" name="titleCover" id="titleCover" autocomplete="titleCover" aria-label="votre titre" required value="<?php echo htmlspecialchars($fullArticle['cover']['titleCover']); ?>"/>

                <label for="imageCover">Couverture image</label>
                <input class="input-image" type="file" id="imageCover" name="imageCover" accept="image/png, image/jpeg, image/webp "/>
                

                <label for="title">Titre de l'article</label>
                <input class="input-title" type="text" name="title" id="title" autocomplete="title" aria-label="votre titre d'article" value="<?php echo htmlspecialchars($fullArticle['article'][0]['title']); ?>"/>
            
                <select class="select-categories" name="category" id="category">
                    <option value="">Sélectionner une catégorie</option>
                    <?php foreach ($allCategories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $fullArticle['article'][0]['category'] ? 'selected' : ''; ?>>
                        <?php echo $category['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                                <!-- Paragraphes de l'article -->
                <?php foreach ($fullArticle['paragraphs'] as $paragraph): ?>
                <section>
                    <label for="content">Contenu de l'article</label>
                    <textarea class="textarea-content-article" id="content" name="content[]"><?php echo htmlspecialchars($paragraph['content']); ?></textarea>
                </section>
                <?php endforeach; ?>

                        <label for="url">Image</label>
                        <input class="input-image" type="file" id="url" name="url[]" accept="image/png, image/jpeg, image/webp "/>
                    </section>
                

                <button class="btn_submit_article">Envoyer</button>

            
        </form>

        
</body>
</html>