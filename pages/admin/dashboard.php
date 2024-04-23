<?php

    session_name("admin");
    session_start();

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../assets/styles/style.css">
    
</head>
<body>
    <header class="dashboard">

        <img class="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet">
        <button class="btn_create_article"><a href="create-article.php">+ Créer article</a></button>
        <!-- <a href="./blog.html"><img class="icon_logout" src="../assets/icons/logout.svg" alt="Icone pour se déconnecter"></a> -->
        
    </header>

    <div class="container_total_article_btn_search">
        
        <h2 class="title_total_article"><img class="icon_article" src="../../assets/icons/articles.svg" alt="">Total des articles</h2>

        <form action="/recherche" method="get">
            <div class="search-container">
                <input type="text" name="search-bar" placeholder="Rechercher..." class="search-input">
                <button type="submit" class="search-button"><img class="search-icon" src="../../assets/icons/search-alt.svg" alt=""></button>
            </div>
        </form>
    </div>

    <div class="separateur"></div>

    <div class="container_table">
        <table>
            <thead>
                <tr>
                    <th scope="col">Article ( titre )</th>
                    <th scope="col">ID</th>
                    <th scope="col">Category</th>
                    <th scope="col">Modifier / Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Voilà pourquoi le Fujifilm-TX-30 II est excellent</td>
                    <td>1</td>
                    <td>Style</td>
                    <td class="icon_delete_update"><a href="./modifier-article.php"><img class="icon_dashboard" src="../../assets/icons/pen.svg" alt=""><img class="icon_dashboard" src="../../assets/icons/bin-delete.svg" alt=""></a></td>
                </tr>
                <tr>
                    <td>Fujifilm-TX-30 II</td>
                    <td>2</td>
                    <td>Equipement</td>
                    <td class="icon_delete_update"><a href="./modifier-article.php"><img class="icon_dashboard" src="../../assets/icons/pen.svg" alt=""><img class="icon_dashboard" src="../../assets/icons/bin-delete.svg" alt=""></a></td>                </tr>
                <tr>
                    <td>Fujifilm-TX-30 II</td>
                    <td>3</td>
                    <td>Style</td>
                    <td class="icon_delete_update"><a href="./modifier-article.php"><img class="icon_dashboard" src="../../assets/icons/pen.svg" alt=""><img class="icon_dashboard" src="../../assets/icons/bin-delete.svg" alt=""></a></td>                </tr>
                <tr>
                    <td>Fujifilm-TX-30 II</td>
                    <td>4</td>
                    <td>Lieux</td>
                    <td class="icon_delete_update"><a href="./modifier-article.php"><img class="icon_dashboard" src="../../assets/icons/pen.svg" alt=""><img class="icon_dashboard" src="../../assets/icons/bin-delete.svg" alt=""></a></td>                </tr> 
            </tbody>
        </table>
    </div>
</body>
</html>