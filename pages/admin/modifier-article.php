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



$article = new Article();

$fullArticle = $article->getFullArticle($articleId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $title = isset($_POST['title']) ? $_POST['title'] : $fullArticle['article'][0]['title'];
    $category = isset($_POST['category']) ? $_POST['category'] : $fullArticle['article'][0]['category'];
    $created_by = isset($_POST['created_by']) ? $_POST['created_by'] : $fullArticle['article'][0]['created_by'];

    $article->setTitre($title);
    $article->setCategory($category);
    $article->setAdmin($created_by);

    $cover = new Cover();

    $article->setId($articleId);

    $cover->setArticle($articleId);


    

$newContents = isset($_POST['content']) ? $_POST['content'] : array();

$paragraph = new Paragraph();

$paragraphs = $paragraph->findParagraphsByArticleId($articleId);

foreach ($paragraphs as $index => $paragraphData) {

    $paragraph->setArticleId($articleId);

    $paragraph->setParagraphId($paragraphData['paraph_id']);

    $paragraph->setContent($newContents[$index]);

    $result = $paragraph->updateParagraph();
}

$newMedia = isset($_POST['media']) ? $_POST['media'] : array();

$media = new Media();

$mediaItems = $media->findMediaByArticleId($articleId);

foreach ($mediaItems as $index => $mediaData) {

    $media->setArticleId($articleId);

    $media->setMediaId($mediaData['media_id']);

    if (isset($_FILES["url"]["name"][$index]) && $_FILES["url"]["name"][$index] != "" && $_FILES["url"]["error"][$index] == 0) {
        $uploadDirectory = "../../assets/img/media/";
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $tempFile = $_FILES["url"]["tmp_name"][$index];
        $finalFile = $uploadDirectory . $_FILES["url"]["name"][$index];

        move_uploaded_file($tempFile, $finalFile);

        $media->setURL($finalFile);
    }

    $result = $media->updateMedia();
}

    $coverInfo = $cover->findCoverByArticleId($articleId);

    $cover->setCoverId($fullArticle['cover']['cover_id']); 

    $titleCover = isset($_POST['titleCover']) ? $_POST['titleCover'] : $fullArticle['cover']['titleCover'];
    $imageCover = isset($_FILES['imageCover']) ? $_FILES['imageCover'] : null; 

    $cover->setTitreCover($titleCover);

    if ($imageCover !== null) {
        $coverUploaded = false;

        $finalFile = $fullArticle['cover']['imageCover']; 

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

            $cover->updateCover();

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
                <input class="input-title" type="text" name="titleCover" id="titleCover" autocomplete="titleCover" aria-label="votre titre" required value="<?php echo ($fullArticle['cover']['titleCover']); ?>"/>

                <label for="imageCover">Couverture image</label>
                <input class="input-image" type="file" id="imageCover" name="imageCover" accept="image/png, image/jpeg, image/webp "/>
                

                <label for="title">Titre de l'article</label>
                <input class="input-title" type="text" name="title" id="title" autocomplete="title" aria-label="votre titre d'article" value="<?php echo isset($fullArticle['article']['title']) ? $fullArticle['article']['title'] : ''; ?>"/>

                //
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
                    <textarea class="textarea-content-article" id="content" name="content[]"><?php echo ($paragraph['content']); ?></textarea>
                </section>
                <?php endforeach; ?>

                        <label for="url">Image</label>
                        <input class="input-image" type="file" id="url" name="url[]" accept="image/png, image/jpeg, image/webp "/>
                    </section>
                

                <button class="btn_submit_article">Envoyer</button>

            
        </form>

        
</body>
</html>