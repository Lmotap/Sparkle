const addSectionBtn = document.querySelector("#add-section-btn");
const sections = document.querySelector("#sections");

addSectionBtn.addEventListener("click", addSection);

let sectionCounter = 0;


function addSection(paragraphId) {
    sectionCounter++;

    const label = document.createElement("label");
    const content = document.createElement("textarea");
    const file = document.createElement("input");

    label.classList.add("label-article");

    content.classList.add(("textarea-content-article"));
    content.setAttribute("name", `content[${sectionCounter}]`);
    content.setAttribute("id", `content${sectionCounter}`);

    const paragraphIdInput = document.createElement("input");
    paragraphIdInput.setAttribute("type", "hidden");
    paragraphIdInput.setAttribute("name", `paragraphId[${sectionCounter}]`);
    paragraphIdInput.setAttribute("value", paragraphId);
    

    file.classList.add("input-file");
    file.setAttribute("type", "file");
    file.setAttribute("name", `url[${sectionCounter}]`);
    file.setAttribute("id", `url${sectionCounter}`);

    const contentLabel = document.createElement("label");
    contentLabel.setAttribute("for", `content${sectionCounter}`);
    contentLabel.textContent = "Contenu de l'article";

    const imageLabel = document.createElement("label");
    imageLabel.setAttribute("for", `url${sectionCounter}`);
    imageLabel.textContent = "Image";

    const section = document.createElement("section");
    section.appendChild(paragraphIdInput);
    section.appendChild(contentLabel);
    section.appendChild(content);
    section.appendChild(imageLabel);
    section.appendChild(file);
    sections.appendChild(section);
}

addSectionBtn.addEventListener("click", addSection);

let paragraphId = getfindParagraphsByArticleId();