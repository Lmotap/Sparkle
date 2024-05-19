/******************
* Menu hamburger *
*****************/

const btnNavShow = document.querySelector("#nav-show");
const btnNavHide = document.querySelector("#nav-hide");


btnNavShow.addEventListener("click", afficherNavigation);
btnNavHide.addEventListener("click", cacherNavigation);


function afficherNavigation() {

    const navMenu = document.querySelector(btnNavShow.dataset.target);

    navMenu.classList.remove("hide");

    btnNavShow.classList.add("hide");

    btnNavHide.classList.remove("hide");
}

function cacherNavigation() {

    const navMenu = document.querySelector(btnNavHide.dataset.target);

    navMenu.classList.add("hide");

    btnNavShow.classList.remove("hide")

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
    const navMenu = document.querySelector('.collapse');

    const isSmallScreen = window.matchMedia('(max-width: 820px)').matches;

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

function FullView(src) {

    const fullImageView = document.getElementById("FullImageView");

    const fullImage = document.getElementById("FullImage");

    fullImage.src = src;

    fullImageView.style.display = "flex";

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


let page = 1;

function loadMoreArticles() {
    page++;
    fetch(`../App/controllers/load-more-articles.php?page=${page}`)
        .then(response => response.json())
        .then(articles => {

            const newArticles = articles.map(article => {
                console.log(article.imageCover);  
                const imageCover = `http://lmota/Mes%20projets/Street%20photography%20portfolio/Sparkle/${article.imageCover.substring(6)}`;
                return `                    
                <div class="container_article">
                        <div class="img wrapper">
                            <a class="link_article" href="./article/article.php?id=${article.article_id}">
                                <img class="cover_img" src="${imageCover}" alt="">        
                            </a>
                            <span class="tag_article">${article.name}</span>
                        </div>
                        <h2 class="titre_article">${article.titleCover}</h2>
                    </div>
                `;
            });

            document.querySelector('footer').insertAdjacentHTML('beforebegin', newArticles.join(''));

            const buttonContainer = document.querySelector('.container_btn_more_article');
            document.querySelector('footer').insertAdjacentElement('beforebegin', buttonContainer);
        });
}

document.querySelector('.btn_more_article').addEventListener('click', loadMoreArticles);