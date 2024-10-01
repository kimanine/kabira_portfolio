<?php
session_start();
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../services/UserService.php';
redirectToLoginIfNotAuthenticated();

$user = getAuthenticatedUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Kabira</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" href="">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php renderURL('assets/css/admin/core.css') ?>">
    <link rel="stylesheet" href="<?php renderURL('assets/css/admin/style.css') ?>">
</head>

<body>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo">
            <!--            <img src="" alt="Logo">-->
            <h1>ProMan</h1>
        </a>
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="fa-regular fa-bars toggle-sidebar-btn"></i>
        </a>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2 text-header">
                            <?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name, ENT_QUOTES | ENT_HTML5); ?>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a href="<?php renderURL('admin/auth/logout.php') ?>" class="dropdown-item d-flex align-items-center">
                            <i class="fa-regular fa-right-from-bracket"></i>
                            <span>Déconnexion</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item active">
            <a class="nav-link " href="<?php renderURL('admin') ?>">
                <i class="fa-solid fa-grid-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Cms (Gestion des pages du front-end)</li>
        <li class="nav-heading">GENERAL</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/education.php') ?>">
                <i class="fa-duotone fa-solid fa-chalkboard"></i>
                <span>Educations</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/experience.php') ?>">
                <i class="fa-sharp fa-solid fa-link"></i>
                <span>Expériences</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/project/') ?>">
                <i class="fa-solid fa-briefcase-blank"></i>
                <span>Projets</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/service/') ?>">
                <i class="fa-solid fa-chart-mixed"></i>
                <span>Services</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/skill/') ?>">
                <i class="fa-solid fa-file"></i>
                <span>Compétences</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/team/') ?>">
                <i class="fa-solid fa-file"></i>
                <span>Equipes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/profile') ?>">
                <i class="fa-sharp fa-solid fa-user-tie"></i>
                <span>Profiles</span>
            </a>
        </li>

        <li class="nav-heading">Administration</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php renderURL('admin/user.php') ?>">
                <i class="fa-duotone fa-solid fa-chalkboard"></i>
                <span>Utilisateurs</span>
            </a>
        </li>
    </ul>
</aside>

<main id="main" class="main">