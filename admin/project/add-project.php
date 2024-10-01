<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ProjectController.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProjectService.php';
require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$projectService = new ProjectService(new Project());
$projectController = new ProjectController($projectService);

$profilService = new ProfilService(new Profil());
$profilController = new ProfilController($profilService);

$profils = $profilController->getAllProfils();
$project_img = null;
$profile_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = (int)($_POST['profile_id'] ?? 0);
    $imgFile = $_FILES['project_img'] ?? null;

    if ($profile_id <= 0 || !$imgFile || empty($imgFile['name'])) {
        showFlashMessage('error', "Tous les champs sont obligatoires.");
    } else {
        $validationResult = validateImage($imgFile);

        if ($validationResult !== true) {
            showFlashMessage('error', $validationResult);
        } else {
            $fileExtension = strtolower(pathinfo($imgFile['name'], PATHINFO_EXTENSION));
            $uploadDir = __DIR__ . '/../../uploads/projects/';

            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                throw new RuntimeException(sprintf('Le répertoire "%s" n\'a pas pu être créé', $uploadDir));
            }

            $newFileName = uniqid('project_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($imgFile['tmp_name'], $uploadPath)) {
                $projectData = [
                    'picture' => $newFileName,
                    'profils_id_profil' => $profile_id,
                ];

                if ($projectController->createProject($projectData)) {
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => "Projet ajouté avec succès."
                    ];

                    if (isset($_POST['submit-and-quit'])) {
                        header("Location: /admin/project/");
                        exit();
                    }

                    if (isset($_POST['submit-and-continue'])) {
                        header("Location: /admin/project/add-project.php");
                        exit();
                    }
                } else {
                    showFlashMessage('error', "Une erreur est survenue lors de l'ajout du projet.");
                }
            } else {
                showFlashMessage('error', "Une erreur est survenue lors du téléchargement de l'image.");
            }
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

    <h1 class="mb-2">Ajouter un projet</h1>
    <nav>
        <ol class="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Projets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ajouter un projet</li>
                </ol>
            </nav>
        </ol>
    </nav>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="col-lg-12 my-4">
        <div class="form-group">
            <label for="project_img" class="mb-1 fs-6 fw-semibold">Sélectionner la photo d'illustration (jpg, jpeg, png, webp uniquement)</label>
            <input type="file" id="project_img" name="project_img" class="w-100" accept="image/jpg, image/jpeg, image/png, image/webp">
        </div>
    </div>

    <div class="col-lg-6 my-4">
        <div class="form-group">
            <label for="profileSelect">Sélectionnez un profil</label>
            <select name="profile_id" id="profileSelect" class="form-control">
                <option value="">-- Sélectionnez un profil --</option>
                <?php if (!empty($profils)): ?>
                    <?php foreach ($profils as $profil): ?>
                        <option value="<?php echo htmlspecialchars($profil->id_profil, ENT_QUOTES | ENT_HTML5); ?>"
                            <?php echo isset($_POST['profile_id']) && $_POST['profile_id'] == $profil->id_profil ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($profil->name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Aucun profil trouvé</option>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="d-flex my-4">
        <div class="col-lg-2 me-3">
            <button class="btn btn-primary py-2 w-100" type="submit" name="submit-and-continue">
                <span class="btn-label">Ajouter et rester</span>
            </button>
        </div>
        <div class="col-lg-2">
            <button class="btn btn-primary py-2 w-100" type="submit" name="submit-and-quit">
                <span class="btn-label">Ajouter et quitter</span>
            </button>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
