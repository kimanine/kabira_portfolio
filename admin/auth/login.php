<?php
session_start();

require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../services/UserService.php';
require_once __DIR__ . '/../../models/User.php';

redirectToDashboardIfAuthenticated();

$userService = new UserService(new User());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs.";
    } else {
        $user = $userService->getUserByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->user_id;

            header("Location: /admin/");
            exit();
        }

        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Kabira Portfolio</title>

    <link rel="apple-touch-icon" href="#">
    <link rel="shortcut icon" href="#">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php renderURL('assets/css/admin/core.css') ?>">
    <link rel="stylesheet" href="<?php renderURL('assets/css/admin/style.css') ?>">
</head>

<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: hsl(0, 0%, 96%)">
<main class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-5 mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body py-5 px-md-5">
                    <form action="" method="post">
                        <div class="text-center">
                            <h1>Logo</h1>
                        </div>

                        <h3 class="my-4">Connectez-vous</h3>

                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error_message, ENT_QUOTES); ?>
                            </div>
                        <?php endif; ?>

                        <div class="p-0 mb-4">
                            <label class="form-label" for="username">Nom d'utilisateur</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>"/>
                        </div>

                        <div class="p-0 mb-4">
                            <label class="form-label" for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control"/>
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
