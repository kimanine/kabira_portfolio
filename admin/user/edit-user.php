<?php

use controllers\admin\UserController;

ob_start();
require_once __DIR__ . '/../../controllers/admin/UserController.php';
require_once __DIR__ . '/../../services/UserService.php';
require_once __DIR__ . '/../../models/User.php';
include_once __DIR__ . '/../partials/header.php';

$userService = new UserService(new User());
$userController = new UserController($userService);

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = $userController->getUserById($user_id);

if (!$user) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Utilisateur non trouvé."
    ];
    header("Location: /admin/user/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');

    if (empty($username) || empty($first_name) || empty($last_name)) {
        showFlashMessage('error', "Tous les champs obligatoires doivent être remplis.");
    } else {
        $userData = [
            'username' => $username,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];

        if ($userController->updateUser($user_id, $userData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Utilisateur mis à jour avec succès."
            ];

            header("Location: /admin/user/");
            exit();
        } else {
            showFlashMessage('error', "Une erreur est survenue lors de la mise à jour de l'utilisateur.");
        }
    }
}
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1 class="mb-2">Modifier un utilisateur</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Utilisateurs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier un utilisateur</li>
        </ol>
    </nav>
</div>

<form action="" method="POST">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="username" class="mb-1 fs-6 fw-semibold">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user->username ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="first_name" class="mb-1 fs-6 fw-semibold">Prénom</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user->first_name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="last_name" class="mb-1 fs-6 fw-semibold">Nom</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user->last_name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>
    </div>

    <div class="d-flex my-4">
        <div class="col-lg-2 me-3">
            <button class="btn btn-primary py-2 w-100" type="submit">
                <span class="btn-label">Mettre à jour</span>
            </button>
        </div>
        <div class="col-lg-2">
            <a href="<?php renderURL('admin/user/') ?>" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
