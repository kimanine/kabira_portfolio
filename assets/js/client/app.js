const header = document.querySelector('.header');

window.addEventListener('scroll', function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let scrollPercentage = Math.min(scrollTop / 300, 1);

    // Rendre le header progressivement visible en fonction du scroll
    header.style.opacity = scrollPercentage;
    header.style.transform = `translateY(${(1 - scrollPercentage) * -50}px)`;
});
// Animation du type-text
var typed = new Typed('#typed-text', {
        strings: ["Ingénieur développeur"],
        cursorChar: "",
        typeSpeed: 60,
        backSpeed: 60,
        backDelay: 1000,
        startDelay: 1000,
        loop: true,
        showCursor: true,
        smartBackspace: false
    }
);

// Fonction pour incrémenter un compteur spécifique
function animateCounter(counterElement, start, end, duration) {
    let current = start;
    const increment = Math.ceil((end - start) / (duration / 50));

    // Utilisation de setInterval pour l'animation
    const timer = setInterval(() => {
        current += increment;
        if (current >= end) {
            current = end;
            clearInterval(timer);
        }
        counterElement.textContent = current;
    }, 50);
}

// Appelle l'animation lors du chargement de la page
window.onload = function () {
    // Animer le premier compteur
    const counter1 = document.getElementById('counter1');
    animateCounter(counter1, 50, 1234, 2000);

    // Animer le deuxième compteur
    const counter2 = document.getElementById('counter2');
    animateCounter(counter2, 50, 1234, 2000);
};

// Sélectionner les boutons et le contenu
const experienceBtn = document.getElementById('experienceBtn');
const educationBtn = document.getElementById('educationBtn');
const experienceContent = document.getElementById('experienceContent');
const educationContent = document.getElementById('educationContent');

// Fonction pour afficher l'expérience et masquer l'éducation
experienceBtn.addEventListener('click', () => {
    experienceContent.classList.remove("d-none");
    educationContent.classList.add("d-none");

    // Ajouter la classe active au bouton Experience
    experienceBtn.classList.add('active-button');
    educationBtn.classList.remove('active-button');
});

// Fonction pour afficher l'éducation et masquer l'expérience
educationBtn.addEventListener('click', function () {
    educationContent.classList.remove('d-none');
    experienceContent.classList.add('d-none');

    // Ajouter la classe active au bouton Education
    educationBtn.classList.add('active-button');
    experienceBtn.classList.remove('active-button');


});
// activer les couleurs une fois un choix selectionner 
const buttons = document.querySelectorAll('.choix button');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        // Retirer la classe 'active' de tous les boutons
        buttons.forEach(btn => btn.classList.remove('active'));

        // Ajouter la classe 'active' au bouton cliqué
        button.classList.add('active');

        // Logique supplémentaire pour afficher le contenu correspondant
        const contentId = button.id === 'experienceBtn' ? '#experienceContent' : '#educationContent';

        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none'; // Masquer tous les contenus
        });

        document.querySelector(contentId).style.display = 'block'; // Afficher le contenu correspondant
    });
});

// Initialisation : afficher l'expérience par défaut
document.querySelector('#experienceContent').style.display = 'block';

// navbar-menu
// Sélectionner les éléments nécessaires
const menuIcon = document.getElementById('menu-icon');
const navLinks = document.querySelector('.nav-links');

// Ajouter un écouteur d'événement sur l'icône de menu
menuIcon.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

const links = document.querySelectorAll('.nav-links a');
links.forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});


// Sélectionne l'input et le body
const toggle = document.getElementById('darkmode-toggle');
const body = document.body;

// Écoute le changement de l'input
toggle.addEventListener('change', () => {
    if (toggle.checked) {
        body.classList.add('darkmode');
    } else {
        body.classList.remove('darkmode');
    }
});
