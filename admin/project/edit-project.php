<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ProjectController.php';
require_once __DIR__ . '/../../services/ProjectService.php';
require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$profilService = new ProfilService(new Profil());
$projectService = new ProjectService(new Project());
$profilController = new ProfilController($profilService);
$projectController = new ProjectController($projectService);

$profils = $profilController->getAllProfils();
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$project = $projectController->getProjectById($project_id);
if (!$project) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Projet non trouvé."
    ];
    header("Location: /admin/project/");
    exit();
}

$profile_id = $project->profils_id_profil;
$project_img = $project->picture;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = (int)$_POST['profile_id'];
    if ($profile_id <= 0) {
        showFlashMessage('error', "Veuillez sélectionner un profil valide.");
    } else {
        if (!empty($_FILES['project_img']['name'])) {
            $validationResult = validateImage($_FILES['project_img']);
            if ($validationResult !== true) {
                showFlashMessage('error', $validationResult);
            } else {
                $imgFile = $_FILES['project_img'];
                $fileExtension = strtolower(pathinfo($imgFile['name'], PATHINFO_EXTENSION));
                $uploadDir = __DIR__ . '/../../uploads/projects/';

                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
                }

                $newFileName = uniqid('project_', true) . '.' . $fileExtension;
                $uploadPath = $uploadDir . $newFileName;

                if (move_uploaded_file($imgFile['tmp_name'], $uploadPath)) {
                    if (!empty($project_img) && file_exists($uploadDir . $project_img)) {
                        unlink($uploadDir . $project_img);
                    }

                    $project_img = $newFileName;
                } else {
                    showFlashMessage('error', "Une erreur est survenue lors du téléchargement de l'image.");
                }
            }
        }

        $projectData = [
            'picture' => $project_img,
            'profils_id_profil' => $profile_id,
        ];

        if ($projectController->updateProject($project_id, $projectData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Projet mis à jour avec succès."
            ];
            header("Location: /admin/project/");
            exit();
        }

        showFlashMessage('error', "Une erreur est survenue lors de la mise à jour du projet.");
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
    <h1 class="mb-2">Modifier le projet</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Projets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier un projet</li>
        </ol>
    </nav>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="col-lg-12 my-4">
        <div class="form-group">
            <label for="project_img" class="mb-1 fs-6 fw-semibold">Sélectionner la photo d'illustration (jpg, jpeg, png, webp uniquement)</label>
            <input type="file" id="project_img" name="project_img" class="w-100" accept="image/jpg, image/jpeg, image/png, image/webp">
            <?php if (!empty($project_img)): ?>
                <p class="my-4">Image actuelle : <img src="<?php renderURL('uploads/projects/' . $project_img); ?>" alt="Image actuelle" style="width: 100px; height: auto;"></p>
            <?php endif; ?>
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
                            <?php echo $profile_id == $profil->id_profil ? 'selected' : ''; ?>>
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
            <button class="btn btn-primary py-2 w-100" type="submit" name="submit-update">
                <span class="btn-label">Mettre à jour</span>
            </button>
        </div>
        <div class="col-lg-2">
            <a href="<?php renderURL('admin/project/') ?>" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
