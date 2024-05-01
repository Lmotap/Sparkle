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

//   // Récupérez toutes les catégories
$allCategories = $category->findAllCategories();

// Récupérez l'ID de l'article à partir de l'URL
$articleId = $_GET['id'];

// Créez une nouvelle instance d'Article
$article = new Article();

// Récupérez toutes les informations de l'article
$fullArticle = $article->getFullArticle($articleId);

// Affichez la valeur de $fullArticle pour le débogage
// echo "<pre>";
// var_dump($fullArticle);
// echo "</pre>";

if (isset($fullArticle['article'][0]['title'])) {
    echo "Titre de l'article : " . htmlspecialchars($fullArticle['article'][0]['title']) . "<br>";
}
if (isset($fullArticle['article'][0]['category'])) {
    echo "Catégorie de l'article : " . htmlspecialchars($fullArticle['article'][0]['category']) . "<br>";
}
if (isset($fullArticle['article'][0]['created_by'])) {
    echo "Créé par : " . htmlspecialchars($fullArticle['article'][0]['created_by']) . "<br>";
}
echo "Titre de la couverture : " . htmlspecialchars($fullArticle['cover']['titleCover']) . "<br>";
echo "Image de la couverture : " . htmlspecialchars($fullArticle['cover']['imageCover']) . "<br>";

foreach ($fullArticle['paragraphs'] as $paragraph) {
    echo "Contenu du paragraphe : " . htmlspecialchars($paragraph['content']) . "<br>";
}

foreach ($fullArticle['medias'] as $media) {
    echo "URL du média : " . htmlspecialchars($media['url']) . "<br>";
}

// Si le formulaire a été soumis, mettez à jour l'article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $article->updateFullArticle($articleId, $_POST);
}

// if (!isset($_SESSION['adminId'])) {
//     // Redirigez vers la page de connexion ou affichez un message d'erreur
//     header('Location: connexion_form.php');
//     exit;
// }

//   // Créez une nouvelle instance de Category
// $category = new Category();

//   // Récupérez toutes les catégories
// $allCategories = $category->findAllCategories();

// // Assurez-vous que l'ID de l'article est défini
// if (!isset($_GET['id'])) {
//     die("Erreur : ID de l'article non défini.");
// }

// // Récupérez l'ID de l'article à partir de l'URL
// $articleId = $_GET['id'];
// var_dump($articleId);

// // Créez une nouvelle instance d'Article et récupérez les informations de l'article
// $article = new Article();
// $articleInfo = $article->findArticleById($articleId);
// var_dump($articleInfo);


// if (!$articleInfo) {
//     die("Erreur : Aucun article trouvé avec l'ID $articleId.");
// }

// // Récupérez les informations de l'article à partir de la base de données
// $title = isset($articleInfo['title']) ? $articleInfo['title'] : '';
// $categoryResult = isset($articleInfo['category_id']) ? $articleInfo['category_id'] : 0;
// $created_by = isset($articleInfo['created_by']) ? $articleInfo['created_by'] : 1;

// // Mettez à jour l'article
// $article->setTitre($title);
// $article->setCategory($categoryResult);
// $article->setAdmin($created_by);
// $article->updateArticle();

// // Assurez-vous que le titre, la catégorie et l'auteur sont définis
// $title = isset($title) ? $title : '';
// $categoryResult = isset($categoryResult) ? $categoryResult : ['category_id' => 0];

// // Assurez-vous que vous avez bien récupéré l'ID de l'administrateur
// $created_by = isset($_SESSION['admin_id']) && !is_null($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 1;

// // Assurez-vous que le titre de la couverture et le fichier final sont définis
// $titleCover = isset($titleCover) ? $titleCover : '';
// $finalFile = isset($finalFile) ? $finalFile : '';


// // Récupérez les informations de la couverture de l'article
// $cover = new Cover(0, $titleCover, $finalFile, $articleId);
// $coverInfo = $cover->findCoverByArticleId($articleId);

// // Extraire l'ID de la couverture
// $coverId = isset($coverInfo['cover_id']) ? $coverInfo['cover_id'] : null;

// // Mettez à jour la couverture
// $cover->setTitreCover($titleCover);
// $cover->setImageCover($finalFile);
// $cover->updateCover();

// $paragraphContent = '';
// $paragraphContent = isset($paragraphContent) ? $paragraphContent : '';


// // Récupérez les paragraphes de l'article
// $paragraph = new Paragraph(null, $paragraphContent, $articleId);
// $paragraphsInfo = $paragraph->findParagraphsByArticleId($articleId);

// // var_dump($paragraphs);  

// // Parcourez chaque paragraphe
// foreach ($paragraphsInfo as $paragraphInfo) {
//     // Extraire l'ID du paragraphe
//     $paragraphId = isset($paragraphInfo['paragraph_id']) ? $paragraphInfo['paragraph_id'] : null;

//     // Créez une nouvelle instance de Paragraph avec l'ID extrait
//     $paragraph = new Paragraph($paragraphId, null, $article->getId());

//     // Mettez à jour le contenu du paragraphe
// if (isset($_POST['content'][$paragraphId])) {
//     $paragraph->setContent($_POST['content'][$paragraphId]);
// }

//     // Mettez à jour le paragraphe dans la base de données
//     $paragraph->updateParagraph();
// }

// $finalFile = isset($finalFile) ? $finalFile : '';

// // Récupérez les médias de l'article
// $media = new Media(null, $finalFile, $articleId);
// $mediasInfo = $media->findMediaByArticleId($articleId);
// // var_dump($medias); 

// // Parcourez chaque média
// foreach ($mediasInfo as $mediaInfo) {
//     // Extraire l'ID du média
//     $mediaId = isset($mediaInfo['media_id']) ? $mediaInfo['media_id'] : null;

//     // Créez une nouvelle instance de Media avec l'ID extrait
//     $media = new Media($mediaId, null, $article->getId());

//     // Mettez à jour le fichier du média
// if (isset($_POST['url'][$mediaId])) {
//     $media->setUrl($_POST['url'][$mediaId]);
// }

//     // Mettez à jour le média dans la base de données
//     $media->updateMedia();
// }

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

    
    <h2 class="title_admin">Modifier un article</h2>

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