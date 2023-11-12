class Navbar {
    constructor(toggleButtonSelector, navbarLinksSelector) {
        this.toggleButton = document.querySelector(toggleButtonSelector);
        this.navbarLinks = document.querySelectorAll(navbarLinksSelector);
        this.addEventListeners();
    }

    addEventListeners() {
        this.toggleButton.addEventListener('click', () => {
            this.toggleNavbarLinks();
        });
    }

    toggleNavbarLinks() {
        this.navbarLinks.forEach(link => {
            link.classList.toggle('active');
        });
    }
}

class PageHighlighter {
    constructor(navbarLinksSelector) {
        this.navbarLinks = document.querySelectorAll(navbarLinksSelector);
        this.addEventListeners();
        this.highlightCurrentPage();
    }

    addEventListeners() {
        this.navbarLinks.forEach(link => {
            link.addEventListener("click", () => {
                this.highlightClickedPage(link);
            });
        });
    }

    highlightClickedPage(clickedLink) {
        this.navbarLinks.forEach(link => {
            link.classList.remove("current-page");
        });

        clickedLink.classList.add("current-page");
        localStorage.setItem("activeTab", clickedLink.textContent.toLowerCase());
    }

    highlightCurrentPage() {
        const activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            const activeLink = Array.from(this.navbarLinks).find(link => link.textContent.toLowerCase() === activeTab);
            if (activeLink) {
                activeLink.classList.add("current-page");
            }
        }
    }
}


// Użycie klasy Navbar
const navbar = new Navbar('.navbar-toggle', '.navbar-links');
// Użycie klasy PageHighlighter
const pageHighlighter = new PageHighlighter('.navbar-links a');
