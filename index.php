<?php
require_once __DIR__ . '/config/helpers.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Portfolio</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="<?php renderURL('assets/css/client/style.css') ?>">
</head>

<body>
<!-- spinner -->
<div id="spinner" class="spinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading..</span>
    </div>
</div>
<!-- spiner end -->

<!-- header start -->
<header class="header">
    <div class="navbar">
        <!-- logo -->
        <div class="text-logo">
            <a href="<?php renderURL('') ?>" class="navbar-logo">
                <h1 class="text-primary mobile-text-primary">ProMan</h1>
            </a>
        </div>

        <!-- menu start -->
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <!-- menu end -->
        <!-- link start -->
        <div class="link">
            <ul class="nav-links mobile-nav-links" id="nav-links">
                <li><a href="#Home">Home</a></li>
                <li><a href="#About">About</a></li>
                <li><a href="#Skills">Skills</a></li>
                <li><a href="#service">Services</a></li>
                <li><a href="#project">Projects</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <!-- link end  -->
        <!-- changement de theme start -->
        <div class="theme-toggle-container">
            <input type="checkbox" id="darkmode-toggle">
            <label for="darkmode-toggle" class="toggle-label">
            </label>
        </div>

        <!-- changement de theme end -->

    </div>


</header>

<!-- header end  -->

<!-- home start -->
<div class="containers" id="Home">
    <div class="container">
        <div class="row mobile-row">
            <div class="info">
                <h3 class="text-primary">Je m'appelle</h3>
                <h1 class="text-h1">kabiratou TANGBANDJA</h1>
                <div id="typed-text" class="typed-cursor">
                    Développeur d'applications
                </div>

                <div class="cv mobile-cv">
                    <a href="<?php renderURL("resumes/CV_kabiratou-TANGBANDJA.pdf") ?>" class="btn" download="CV_kabiratou-TANGBANDJA.pdf">Download
                        CV</a>
                </div>

            </div>

            <div class="image" data-aos="fade-up">
                <img src="<?php renderURL('assets/images/hiclipart.com (1).png') ?>" alt="">
            </div>
        </div>
    </div>
</div>

<!-- home end -->
<!-- site web de la cour constitutionnel -->
<!-- about start -->
<div class="About" id="About">
    <div class="container mobile-container">
        <div class="row flex-start-image mobile-flex-start-image">
            <div class="contenue mobile-contenue">
                <div class="div">
                    <div class="years" data-aos="fade-right">
                        <h1 class="h1">5</h1>
                        <h5 class="h5">Ans</h5>
                    </div>
                    <div class="text" data-aos="fade-left">
                        <h3 class="h3">d'expérience en tant que développeur d'applications.</h3>
                    </div>
                </div>
                <p class="p1">Développeur d'application, avec une expertise dans la coordination et le développement
                    d'applications web et
                    bureautiques. J'ai supervisé des projets IT pour des clients internationaux, tels que le Corps de la
                    Paix et
                    l'Ambassade du
                    Brésil, ainsi que le lancement du logiciel de contrôle biométrique Biosecur pour la Caisse de
                    Retraite du
                    Togo (CRT).
                    Compétent en analyse, rédaction de spécifications techniques, documentation, et tests. Fortes
                    capacités en
                    gestion
                    d'équipe et innovation technologique, avec un focus sur l'assistance technique continue et la
                    réussite des
                    projets.
                </p>
                <div class="circle">
                    <p class="p2"><i class="fa-regular fa-circle-check"></i>Compétences en gestion de projet</p>
                    <p class="p3"><i class="fa-regular fa-circle-check"></i> Expertise technique</p>
                    <p class="p4"><i class="fa-regular fa-circle-check"></i>Capacités d'innovation et de leadership</p>
                </div>
                <a class="btn" href="">Read more</a>
            </div>
            <div class="container1" data-aos="fade-up">
                <div class="image-contenue">
                    <div class="img1">
                        <img class="img"
                             src="<?php renderURL("assets/images/Réunion de gestion d'entreprise _ Vecteur Gratuite.jpeg") ?>"
                             alt="">
                    </div>
                    <div class="img2">
                        <img class="img"
                             src="<?php renderURL("assets/images/Vecteur de réunion de groupe d'affaires _ Vecteur Premium.jpeg") ?>"
                             alt="">
                    </div>
                </div>
                <div class="first">
                    <div class="one-text">
                        <h6 class="h6">Happy Clients | <span id="counter1">10</span></h6>
                    </div>
                    <p>
                        Stet no et lorem dolor et diam, amet duo ut dolore vero eos. No stet est diam rebum amet diam
                        ipsum. Clita clita labore, dolor duo nonumy clit
                    </p>
                </div>
                <div class="first">
                    <div class="one-text">
                        <h6 class="h6">Projects Completed | <span id="counter2">10</span></h6>
                    </div>
                    <p>
                        Stet no et lorem dolor et diam, amet duo ut dolore vero eos. No stet est diam rebum amet diam
                        ipsum. Clita clita labore, dolor duo nonumy clit
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about end -->

<!-- experience start -->
<div class="experience" id="Skills">
    <div class="container-exp mobile-container">
        <div class="row mobile-row">
            <div class="col-1">
                <h1 data-aos="fade-right">
                    Skills & Experience
                </h1>
                <p data-aos="fade-right">Expérience approfondie dans l'analyse, la conception, et le développement
                    d'applications
                    web, mobiles, et bureautiques avec des technologies telles que Spring Boot, JavaScript, et des
                    frameworks
                    modernes. Expertise en gestion de projet et supervision d'équipes techniques, en utilisant des
                    outils de
                    collaboration comme Github et Azure Devops, pour des projets internationaux et variés.</p>

                <h3 data-aos="fade-right">My Skill</h3>
                <div class="skill-content" data-aos="fade-right">
                    <div class="skill-1">
                        <div class="exp">
                            <div class="cont">
                                <h4>Système d'exploitation</h4>
                                <h4>50%</h4>
                            </div>
                            <div class="progress-container">
                                <div class="progress1"></div>
                            </div>
                        </div>
                        <div class="exp">
                            <div class="cont">
                                <h4>Langage de programmation
                                </h4>
                                <h4>85%</h4>
                            </div>
                            <div class="progress-container">
                                <div class="progress2"></div>
                            </div>
                        </div>
                        <div class="exp">
                            <div class="cont">
                                <h4>Frameworks</h4>
                                <h4>90%</h4>
                            </div>
                            <div class="progress-container">
                                <div class="progress3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="skill2">
                        <div class="exp">
                            <div class="cont">
                                <h4>Logiciels et outils</h4>
                                <h4>90%</h4>
                            </div>
                            <div class="progress-container">
                                <div class="progress4"></div>
                            </div>
                        </div>
                        <div class="exp">
                            <div class="cont">
                                <h4>Base de données</h4>
                                <h4>50%</h4>
                            </div>
                            <div class="progress-container">
                                <div class="progress5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="choix" data-aos="fade-left">
                    <ul>
                        <li class="liste-1">
                            <button class="link1 active" id="experienceBtn">Experience</button>
                        </li>

                        <li class="liste-2">
                            <button class="link2" id="educationBtn">Education</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="experienceContent" data-aos="fade-left">
                    <div class="tab-1">
                        <div class="row mobile-row-tab">
                            <!-- experience start -->
                            <div class="experience-container">

                                <div class="col-3">
                                    <h4>Chef de projet IT.</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">05/2023 - present
                                    </p>
                                    <h6> SEMFIELD | Lome, Togo, Directeur technique adjointe</h6>
                                </div>

                                <div class="col-3">
                                    <h4>Développeur d'applications.</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">05/2022 - present
                                    </p>
                                    <h6> SEMFIELD | Lome, Togo, Développeur web</h6>
                                </div>


                                <div class="col-3">
                                    <h4>Architecte logiciel.</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">11/2021 - 05/2022</p>
                                    <h6>Société des Postes du Togo (SPT) I Lomé, Togo,
                                        Stagiaire en développement d'applications Togo Postal</h6>
                                </div>

                                <div class="col-3">
                                    <h4>Développeur web.</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">01/2021 - 11/2021</p>
                                    <h6> MUSAIDA SOFTWARE I Lomé, Togo, Stagiaire en développement d'applications
                                        MUSAIDA</h6>
                                </div>

                            </div>
                            <!-- experience end -->
                        </div>
                    </div>
                </div>

                <!-- education start -->

                <div class="tab-content d-none" id="educationContent">
                    <div class="tab-2">
                        <div class="row">
                            <div class="education-container">
                                <div class="col-3">
                                    <h4>MASTER</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">10/2023 - 07/2023</p>
                                    <h6> Master en sciences et technologies, mention informatique, spécialité logiciel.,
                                        ESGIS</h6>
                                </div>

                                <div class="col-3">
                                    <h4>LICENCE</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">2000 - 2045</p>
                                    <h6>Licence en sciences et technologies, informatique, spécialisation en logiciels.,
                                        ESGIS
                                    </h6>
                                </div>
                                <div class="col-3">
                                    <h4>BAC2</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">2015 - 2016</p>
                                    <h6> CES LE SALUT</h6>
                                </div>
                                <div class="col-3">
                                    <h4>BAC1</h4>
                                    <hr class="text-primary">
                                    <p class="text-primary">2014 - 2015</p>
                                    <h6> CES LE SALUT</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- education end -->

            </div>

        </div>
    </div>
</div>

<!-- experience end -->


<!-- service start -->
<div class="service" id="service">
    <div class="container-3">
        <div class="contenue-0">
            <div class="my-service">
                <h6 data-aos="fade-right" class="my-service">Mes Services</h6>
            </div>
            <div class="hire-me">
                <button class="btn mobile-btn">
                    Hire Me
                </button>
            </div>
        </div>

        <div class="row">
            <div class="content-2">
                <!-- col-1 start-->
                <div class="col-4" data-aos="fade-up">
                    <!-- service items -->
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa-solid fa-crop-simple"></i>
                        </div>
                        <!-- contenue start-->
                        <div class="contenue-4">
                            <h4 class="h4-title">Développement d'applications web, mobiles et bureautiques</h4>
                            <h6 class="h6-text">Start from
                                <span class="text-primary">$199</span>
                            </h6>
                            <span> Création d'applications sur mesure pour la gestion de cours, la gestion comptable, la biométrie,
                  et plus encore, en utilisant des technologies telles que Spring Boot, JavaScript, etc.</span>
                        </div>

                        <!-- contenue end-->
                    </div>
                    <!-- service end -->
                </div>
                <!-- col-1 end -->

                <!-- col-2 start -->
                <div class="col-4" data-aos="fade-up">
                    <!-- service items -->
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa-solid fa-code-branch"></i>
                        </div>
                        <!-- contenue start-->
                        <div class="contenue-4">
                            <h4 class="h4-title">Supervision technique</h4>
                            <h6 class="h6-text">Start from
                                <span class="text-primary">$199</span>
                            </h6>
                            <span>Coordination d'équipes techniques et supervision de projets complexes, incluant l'installation
                  d'infrastructures réseau et la gestion de systèmes informatiques pour des organisations
                  internationales.</span>
                        </div>

                        <!-- contenue end-->
                    </div>
                    <!-- service end -->
                </div>
                <!-- col-2 end -->

                <!-- col-3 start -->
                <div class="col-4" data-aos="fade-up">
                    <!-- service items -->
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <!-- contenue start-->
                        <div class="contenue-4">
                            <h4 class="h4-title">Analyse et conception de solutions IT</h4>
                            <h6 class="h6-text">Start from
                                <span class="text-primary">$199</span>
                            </h6>
                            <span>Analyse des besoins des clients, rédaction de cahiers des charges, et conception de solutions
                  innovantes pour divers secteurs (éducation, microfinance, gestion communale, etc.).

                </span>
                        </div>

                        <!-- contenue end-->
                    </div>
                    <!-- service end -->
                </div>
                <!-- col-3 end -->

                <!-- col-4 start -->
                <div class="col-4" data-aos="fade-up">
                    <!-- service items -->
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <!-- contenue start-->
                        <div class="contenue-4">
                            <h4 class="h4-title">Gestion de sites web et interfaces utilisateurs</h4>
                            <h6 class="h6-text">Start from
                                <span class="text-primary">$199</span>
                            </h6>
                            <span> Développement, optimisation et gestion de sites web dynamiques, en respectant les normes
                  d'ergonomie et de design.</span>
                        </div>

                        <!-- contenue end-->
                    </div>

                </div>
                <!-- col-4 end -->
            </div>
        </div>
    </div>
</div>
<!-- service end -->

<!--projet start  -->
<div class="project" id="project">
    <div class="container">
        <div class="row">
            <div class="all-content">
                <div class="projet-contenue">
                    <div class="mon-projet">
                        <h1 data-aos="fade-right" class="my-service">My Projects</h1>
                    </div>
                </div>

                <div class="con-1">

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/Capture d’écran (68).png") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-1.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/Capture d’écran (69).png") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-2.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/project-3.jpg") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-3.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/project-4.jpg") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-4.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/project-5.jpg") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-5.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="im1" data-aos="fade-up">
                        <div class="portfolio-img">
                            <img src="<?php renderURL("assets/images/project-6.jpg") ?>" alt="">
                            <div class="portfolio-btn">
                                <a class="btn-square" href="<?php renderURL("assets/images/project-6.jpg") ?>">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="portfolio-btn" href="">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- projet end -->

<!--- team start -->

<div class="team" id="team">
    <div class="container">
        <div class="row">
            <div class="col-7">
                <h1 data-aos="fade-right">Team Members</h1>
            </div>
        </div>

        <div class="row">
            <div class="team-content">

                <div class="team-item" data-aos="fade-up">
                    <img src="<?php renderURL("assets/images/team-1.jpg") ?>" alt="">
                    <div class="team-text">
                        <div>
                            <h4>Full Name</h4>
                            <span>Designe</span>
                        </div>
                        <i class="fa-solid fa-arrow-right">
                        </i>
                    </div>
                </div>

                <div class="team-item" data-aos="fade-up">
                    <img src="<?php renderURL("assets/images/team-2.jpg") ?>" alt="">
                    <div class="team-text">
                        <div>
                            <h4>Full Name</h4>
                            <span>Designe</span>
                        </div>
                        <i class="fa-solid fa-arrow-right">
                        </i>
                    </div>
                </div>

                <div class="team-item" data-aos="fade-up">
                    <img src="<?php renderURL("assets/images/team-3.jpg") ?>" alt="">
                    <div class="team-text">
                        <div>
                            <h4>Full Name</h4>
                            <span>Designe</span>
                        </div>
                        <i class="fa-solid fa-arrow-right">
                        </i>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--- team start -->

<!-- contact start -->
<div class="contact" id="contact">
    <div class="contact-container">
        <div class="row">
            <div class="contact-content">
                <div class="col-9" data-aos="fade-right">
                    <h1>Let't Work Together</h1>
                </div>
                <div class="col-10">
                    <a class="btn-1" href=""> Say Hello</a>
                </div>
            </div>
        </div>

        <div class="row contact-details" data-aos="fade-right">
            <div class="col contact-info">
                <p>My office:</p>
                <h3>123 Street, New York, USA</h3>
                <hr>
                <p>Call me:</p>
                <h3>+228 70 05 28 58</h3>
                <hr>
                <p>Mail me:</p>
                <h3>kabiratoutangbandja2000@gmail.com</h3>
                <hr>
                <p>Follow me:</p>
                <div class="contact-icon">
                    <a class="btn-2" href=""><i class="fa-brands fa-twitter"></i></a>
                    <a class="btn-2" href=""><i class="fa-brands fa-facebook-f"></i></a>
                    <a class="btn-2" href=""><i class="fa-brands fa-youtube"></i></a>
                    <a class="btn-2" href=""><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>

            <div class="col contact-form" data-aos="fade-left">
                <p>The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in
                    a
                    few minutes. Just copy and paste the files, add a little code and you're done.
                    <a href="https://htmlcodex.com/contact-form">Download Now</a>.
                </p>

                <form>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="subject" placeholder="Subject">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" style="height: 100px;"
                                          placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- contact end -->


<!-- map start -->
<div class="container-xxl" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
    <div class="container-xxl pt-5 px-0">
        <div class="bg-dark">
            <iframe class="map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253863.1757992332!2d1.081873961720741!3d6.182637690051087!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e1c113185419%3A0x3224b5422caf411d!2zTG9tw6k!5e0!3m2!1sfr!2stg!4v1724424089587!5m2!1sfr!2stg"
                    width="1255" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
<!-- map end -->

<!-- copyright start-->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="copy-content">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    © <a class="text-secondary" href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Designed By <a class="border-bottom text-secondary" href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distributed By: <a class="bord" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- copyright end -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?php renderURL('assets/js/client/app.js') ?>"></script>
<script>
    AOS.init({
        duration: 500,
        easing: "ease-in-out",
        once: false,
        mirror: false,
    });
</script>
</body>
</html>