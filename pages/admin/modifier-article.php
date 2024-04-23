<?php

    session_name("admin");
    session_start();

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Article</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../assets/styles/style.css">
    
</head>
<body class="body_form_article">

    <header class="dashboard">
        <a href="/index.html"><img class="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet"></a>
        <a href="./dashboard.php"><img class="icon_logout" src="../../assets/icons/arrow-right-return.svg" alt=""></a> 
    </header>

    
    <h2 class="title_admin">Modifier Article</h2>

    <div class="container_form_create_article">
        <form action="#" method="post">

                <label for="title">Titre de couverture de l'article</label>
                <input class="input-title" type="text" name="title" id="title" autocomplete="title" aria-label="votre titre" required />

                <label for="cover-image">Couverture image</label>
                <input class="input-image" type="file" id="cover-image" name="cover-image" accept="image/png, image/jpeg, image/webp "/>
                

                <label for="title-article">Titre de l'article</label>
                <input class="input-title" type="text" name="title-article" id="title-article" autocomplete="title-article" aria-label="votre titre d'article" required />
            
                <select class="select-categories" name="categories" id="categories">
                    <option value="">Séléctionner une catégorie</option>
                    <option value="Inspirations">Inspirations</option>
                    <option value="Style">Style</option>
                    <option value="Equipement">Equipement</option>
                    <option value="Lieux">Lieux</option>
                </select>

                <label for="content-article">Contenu de l'article</label>
                <textarea class="textarea-content-article" id="content-article" name="content-article"></textarea>

                <label for="cover-image">Image</label>
                <input class="input-image" type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp "/>

                <label for="content-article">Contenu de l'article</label>
                <textarea class="textarea-content-article" id="content-article" name="content-article"></textarea>

                <label for="cover-image">Image</label>
                <input class="input-image" type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp "/>

                <button class="btn_submit_article" type="submit">Envoyer</button>

            
        </form>
    </div>

</body>
</html>