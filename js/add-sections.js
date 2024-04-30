const addSectionBtn = document.querySelector("#add-section-btn");
const sections = document.querySelector("#sections");

addSectionBtn.addEventListener("click", addSection);

function addSection() {
    const label = document.createElement("label");
    const content = document.createElement("textarea");
    const file = document.createElement("input");

    label.classList.add("label-article");

    content.classList.add(("textarea-content-article"));
    content.setAttribute("name", "content[]");

    file.classList.add("input-file");
    file.setAttribute("type", "file");
    file.setAttribute("name", "image[]");

    const contentLabel = document.createElement("label");
    contentLabel.setAttribute("for", "content");
    contentLabel.textContent = "Contenu de l'article";

    const imageLabel = document.createElement("label");
    imageLabel.setAttribute("for", "image");
    imageLabel.textContent = "Image";

    const section = document.createElement("section");
    section.appendChild(contentLabel);
    section.appendChild(content);
    section.appendChild(imageLabel);
    section.appendChild(file);
    sections.appendChild(section);

}