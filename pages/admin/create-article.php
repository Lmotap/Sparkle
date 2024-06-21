<?php

require_once __DIR__. ('../../../App/models/Admin.php');
require_once __DIR__. ('../../../App/models/Article.php');
require_once __DIR__. ('../../../App/models/Categories.php');
require_once __DIR__. ('../../../App/models/Cover.php');
require_once __DIR__. ('../../../App/models/Paragraph.php');
require_once __DIR__. ('../../../App/models/Media.php');

session_name("admin");
session_start();

if (!isset($_SESSION['adminId'])) {
    header('Location: connexion_form.php');
    exit;
}

$category = new Category();
$allCategories = $category->findAllCategories();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $coverUploaded = false;

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

        if ($coverUploaded) {
            $titleCover = $_POST['titleCover'];
            $title = $_POST['title'];
            $categories = intval($_POST['categories']);

            $category = new Category();
            $category->setId($categories);
            $categoryResult = $category->findOneCategoryById();

            if (!$categoryResult) {
                echo "La catégorie spécifiée n'existe pas.";
                return;
            }

            $created_by = isset($_SESSION['admin_id']) && !is_null($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 1;
            $article = new Article(null, $title, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $categoryResult["category_id"], $created_by);

            if ($articleResult = $article->createArticle()) {
                $cover = new Cover(0, $titleCover, $finalFile, $article->getId());
                $coverResult = $cover->createCover();

                $paragraphs = $_POST['content'];
                foreach ($paragraphs as $index => $paragraphContent) {
                    $paragraph = new Paragraph(null, $paragraphContent, $article->getId());
                    if (!$paragraph->createParagraph()) {
                        echo "Une erreur est survenue lors de la création du paragraphe.";
                        return;
                    }
                }

                if (isset($_FILES["url"]["name"])) {
                    $uploadDirectory = "../../assets/img/blog/";
                    if (!file_exists($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    for ($i = 0; $i < count($_FILES["url"]["name"]); $i++) {
                        if ($_FILES["url"]["name"][$i] != "" && $_FILES["url"]["error"][$i] == 0) {
                            $tempFile = $_FILES["url"]["tmp_name"][$i];
                            $finalFile = $uploadDirectory . $_FILES["url"]["name"][$i];
                            move_uploaded_file($tempFile, $finalFile);

                            $image = new Media(null, $finalFile, $article->getId());
                            if (!$image->createMedia()) {
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
        <form action="" method="post" enctype="multipart/form-data">
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