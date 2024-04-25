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
    const navMenu = document.querySelector ('.collapse');

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
icons.forEach (icon => {  
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
    fullImage.addEventListener("click", function() {
        fullImageView.style.display = "none";
    });
}


function returnAlinea() {
    const description = document.getElementById("description");
    const text = description.innerText;
    const newText = text.split(", ").join("<br>");
    description.innerHTML = newText;
}

returnAlinea();