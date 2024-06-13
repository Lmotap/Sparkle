<?php

require_once __DIR__ . '/../../App/models/Article.php';
require_once __DIR__ . '/../../App/models/Paragraph.php';
require_once __DIR__ . '/../../App/models/Media.php';

if (!isset($_GET['id'])) {
    // Si aucun ID n'est fourni, redirigez vers la page d'accueil
    header('Location: ../index.html');
    exit;
}

$id = $_GET['id'];
$article = new Article();
$articleInfo = $article->findArticleById($id);

$title = $articleInfo['title'] ?? '';
$dateCreated = $articleInfo['date_created'] ?? '';
$dateCreated = date('Y-m-d', strtotime($dateCreated));
$category = $articleInfo['category'] ?? '';

$paragraphs = $article->findParagraphsByArticleId($id);

foreach ($paragraphs as &$paragraph) {
    $paragraph['item_id'] = $paragraph['paraph_id'];
}

$medias = $article->findMediaByArticleId($id);
foreach ($medias as &$media) {
    $media['item_id'] = $media['media_id'];
}

$items = array_merge($paragraphs, $medias);

$items = [];
while (!empty($paragraphs) || !empty($medias)) {
    if (!empty($paragraphs)) {
        $items[] = array_shift($paragraphs);
    }
    if (!empty($medias)) {
        $items[] = array_shift($medias);
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Article Générique </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../assets/styles/style.css">

</head>

<body>

    <!-- Début du header -->

    <!-- Début du header -->
    <header>
        <a href="../index.html">
            <img id="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet">
        </a>
        <nav>
            <ul>
                <li id="show_hamburger">
                    <span id="nav-show" data-target=".collapse"><img id="icon_hamburger" src="../../assets/icons/burger-list.svg" alt="Icône de burger"></span>
                </li>
                <li id="close_hamburger">
                <span id="nav-hide" data-target=".collapse" class="hide"><img id="icon_cross_ham" src="../../assets/icons/cross-burger.svg" alt="Icône de fermeture"></span>
                </li>
                <div class="collapse hide">
                    
                <div class="container-nav">
                    <li class="link_nav"><a href="./category_photos.html">Portfolio</a></li>
                    <li class="link_nav"><a href="./contact.html">Contact</a></li>
                </div>
                
                </div>
            </ul>
        </nav>
    </header>

    <div class="container-article">
    <h1 class="title_article"><?php echo $title; ?></h1>

    <div class="wrapper_category_date">
        <div class="category"><?php echo $category; ?></div>
        <span class="separateur_text">/</span>
        <div class="date_created"><?php echo $dateCreated; ?></div>
    </div>
</div>

<?php foreach ($items as $item): ?>
    <?php if (isset($item['content'])): ?>
        <div class="wraper_content">
            <p class="content_article">
                <?php echo $item['content']; ?>
            </p>
        </div>
    <?php elseif (isset($item['url'])): ?>
        <div class="container_img">
            <img class="img_article" src="<?php echo $item['url']; ?>" alt="">
        </div>
    <?php endif; ?>
<?php endforeach; ?>

    <div class="container_icon_article">
        <a href="../blog.php"><img class="return_arrow" src="../../assets/icons/arrow-circle-left-light.svg" alt=""></a>
    </div>

    <div class="container_separation">
        <div class="separation_article"></div>
    </div>


<!-- Début du Footer -->

<footer class="footer">
    <ul class="container_icon">
        <img src="../../assets/icons/instagram_icon.svg" alt="Icône d'instagram">
        <img src="../../assets/icons/twitter-x.svg" alt="Icône X">
    </ul>

    <ul class="nav_footer_center">
        <li class="link_footer">Lucas Mota</li>
    </ul>

    <ul class="nav_footer_right">
        <li class="link_footer wth_link">Mentions <br>légales</li>
        <div class="diese">&</div>
        <li class="link_footer wth_link">Politique de <br>confidentialités</li>
    </ul>
</footer>

<script src="../../js/app.js"></script>
</body>
</html>