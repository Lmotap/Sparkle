/******************
* Menu hamburger *
*****************/
// Récupération des "boutons" responsives

const btnNavShow = document.querySelector("#nav-show");
const btnNavHide = document.querySelector("#nav-hide");


btnNavShow.addEventListener("click", afficherNavigation);
btnNavHide.addEventListener("click", cacherNavigation);


function afficherNavigation() {

    // Element à manipuler
    const navMenu = document.querySelector(btnNavShow.dataset.target);

    // Retirer la classe .hide de la liste des classes de l'élément
    navMenu.classList.remove("hide");

    // Cacher l'icône hamburger
    btnNavShow.classList.add("hide");

    // Et afficher l'icône "croix de fermeture"
    btnNavHide.classList.remove("hide");
}

function cacherNavigation() {

    // Element à manipuler
    const navMenu = document.querySelector(btnNavHide.dataset.target);

    // Ajouter la classe .hide à la liste des classes de l'élément
    navMenu.classList.add("hide");

    // Afficher l'icône hamburger
    btnNavShow.classList.remove("hide")

    // Et cacher l'icône "croix de fermeture"
    btnNavHide.classList.add("hide");

}



/* Menu déroulants * 
*******************/

const collapsableMenuItems = document.querySelectorAll(".collapsable-item");

collapsableMenuItems.forEach(element => {
    element.addEventListener("click", manageCollapsableMenuItem);
});

function manageCollapsableMenuItem(event) {
    let collapsable = document.querySelector(event.target.dataset.target);

    if (collapsable.classList.contains("hide")) {
        collapsable.classList.remove("hide");
    } else {
        collapsable.classList.add("hide");

    }
}




function manageCollapsableMenuItem() {
    let collapsable = document.querySelector(collapsableMenuItem.dataset.target);
    collapsable.classList.remove("hide");
}

function manageCollapsableMenuItem() {
    let collapsable = document.querySelector(collapsableMenuItem.dataset.target);

    if (collapsable.classList.contains("hide")) {
        collapsable.classList.remove("hide");
    } else {
        collapsable.classList.add("hide");
    }
}

let collection = [1, 2, 3];

collection.forEach(element => {

});


function updateNavDisplay() {
    // Je sélectionne l'élément qui permet de gérer le menu hamburger
    const navMenu = document.querySelector('.collapse');

    // Je crée une const qui me dit que si l'écran à une taille maximale de 820px me renvoie un booléen vrai ou faux
    const isSmallScreen = window.matchMedia('(max-width: 820px)').matches;

    // Je crée une condition qui fait si l'écran à une taille maximale de 820px, le menu hamburger est enlevé
    if (isSmallScreen) {
        navMenu.classList.add('hide');
        btnNavShow.classList.remove('hide');
        btnNavHide.classList.add('hide');
    } else {
        navMenu.classList.remove('hide');
        btnNavShow.classList.add('hide');
        btnNavHide.classList.add('hide');
    }
}

updateNavDisplay();

window.addEventListener('resize', updateNavDisplay);





const icons = document.querySelectorAll('.icon');
icons.forEach(icon => {
    icon.addEventListener('click', (event) => {
        icon.classList.toggle("open");
    });
});

function FullView(src) {
    // Récupère l'élément FullImageView
    const fullImageView = document.getElementById("FullImageView");
    // Récupère l'élément FullImage
    const fullImage = document.getElementById("FullImage");

    // Définit la source de l'image
    fullImage.src = src;
    // Affiche la div FullImageView
    fullImageView.style.display = "flex";
    // Ajoute un événement pour fermer la div FullImageView lors d'un clic sur l'image
    fullImage.addEventListener("click", function () {
        fullImageView.style.display = "none";
    });
}


function returnAlinea() {
    const description = document.getElementById("description");
    if (description) {
        const text = description.innerText;
        const newText = text.split(", ").join("<br>");
        description.innerHTML = newText;
    }
}

returnAlinea();


document.addEventListener('DOMContentLoaded', (event) => {
    let showHamburger = document.getElementById('show_hamburger');
    let closeHamburger = document.getElementById('close_hamburger');
    let dyslexicIcon = document.getElementById('dyslexic');

    if (showHamburger && dyslexicIcon) {
        showHamburger.addEventListener('click', function () {
            dyslexicIcon.style.display = 'none';
        });
    }

    if (closeHamburger && dyslexicIcon) {
        closeHamburger.addEventListener('click', function () {
            dyslexicIcon.style.display = 'block';
        });
    }
});

// document.addEventListener("DOMContentLoaded", start);

// function start() {
//     let dyslexic_link = document.querySelector("#dyslexic");

//     dyslexic_link.addEventListener("click", gerer_dyslexic);

//     if (localStorage.getItem("theme") == "Dyslexic") {

//         console.log("Préférence existante dans le local storage");

//         let dyslexic_style = document.createElement("style");
//         dyslexic_style.appendChild(document.createTextNode("@font-face { font-family: 'OpenDyslexic'; src: url('assets/fonts/OpenDyslexic/OpenDyslexic.ttf');}"));

//         document.head.appendChild(dyslexic_style);
//         let html_element = document.querySelector("html");

//         html_element.style.fontFamily = "OpenDyslexic";

//     }
// }


// function gerer_dyslexic() {
//     let html_element = document.querySelector("html");

//     if (!html_element || !html_element) {
//         console.error("Les éléments HTML ou BODY n'ont pas été trouvés");
//         return;
//     }

//     if (localStorage.getItem("theme") == "Dyslexic") {
//         localStorage.removeItem("theme");


//         // Ajoutez les polices "League Spartan" et "Libre Baskerville"
//         html_element.style.fontFamily = "'Libre Baskerville', 'League Spartan', sans-serif";

//     } else {
//         let dyslexic_style = document.createElement("style");

//         dyslexic_style.appendChild(document.createTextNode("@font-face { font-family: 'OpenDyslexic'; src: url('assets/fonts/OpenDyslexic/OpenDyslexic.ttf');}"));

//         document.head.appendChild(dyslexic_style);

//         html_element.style.fontFamily = "OpenDyslexic";

//         localStorage.setItem("theme", "Dyslexic");
//     }
// }







let page = 1;

function loadMoreArticles() {
    page++;
    fetch(`../App/controllers/load-more-articles.php?page=${page}`)
        .then(response => response.json())
        .then(articles => {
            // Créez des éléments HTML pour les nouveaux articles
            const newArticles = articles.map(article => {
                console.log(article.imageCover);  // Ajoutez cette ligne
                const imageCover = `http://lmota/Mes%20projets/Street%20photography%20portfolio/Sparkle/${article.imageCover.substring(6)}`;
                return `                    
                <div class="container_article">
                        <div class="img wrapper">
                            <a class="link_article" href="./article/article.html">
                                <img class="cover_img" src="${imageCover}" alt="">        
                            </a>
                            <span class="tag_article">${article.name}</span>
                        </div>
                        <h2 class="titre_article">${article.titleCover}</h2>
                    </div>
                `;
            });

            // Ajoutez les nouveaux articles à la page
            document.querySelector('footer').insertAdjacentHTML('beforebegin', newArticles.join(''));

            // Déplacez le bouton "Plus d'articles" après les nouveaux articles
            const buttonContainer = document.querySelector('.container_btn_more_article');
            document.querySelector('footer').insertAdjacentElement('beforebegin', buttonContainer);
        });
}

// Ajoutez un écouteur d'événements au bouton pour charger plus d'articles
document.querySelector('.btn_more_article').addEventListener('click', loadMoreArticles);