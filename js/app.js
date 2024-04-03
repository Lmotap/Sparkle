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






const icons = document.querySelectorAll('.icon');
icons.forEach (icon => {  
icon.addEventListener('click', (event) => {
    icon.classList.toggle("open");
    });
});