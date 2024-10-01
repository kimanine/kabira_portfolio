<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/TeamController.php';
require_once __DIR__ . '/../../services/TeamService.php';
require_once __DIR__ . '/../../models/Team.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$profilService = new ProfilService(new Profil());
$teamService = new TeamService(new Team());
$profilController = new ProfilController($profilService);
$teamController = new TeamController($teamService);

$profils = $profilController->getAllProfils();
$member_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$member = $teamController->getTeamById($member_id);
if (!$member) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Membre non trouvé."
    ];
    header("Location: /admin/team/");
    exit();
}

$profile_id = $member->profils_id_profil;
$member_img = $member->picture;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = (int)$_POST['profile_id'];
    if ($profile_id <= 0) {
        showFlashMessage('error', "Veuillez sélectionner un profil valide.");
    } else {
        if (!empty($_FILES['member_img']['name'])) {
            $validationResult = validateImage($_FILES['member_img']);
            if ($validationResult !== true) {
                showFlashMessage('error', $validationResult);
            } else {
                $imgFile = $_FILES['member_img'];
                $fileExtension = strtolower(pathinfo($imgFile['name'], PATHINFO_EXTENSION));
                $uploadDir = __DIR__ . '/../../uploads/teams/';

                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
                }

                $newFileName = uniqid('member_', true) . '.' . $fileExtension;
                $uploadPath = $uploadDir . $newFileName;

                if (move_uploaded_file($imgFile['tmp_name'], $uploadPath)) {
                    if (!empty($member_img) && file_exists($uploadDir . $member_img)) {
                        unlink($uploadDir . $member_img);
                    }

                    $member_img = $newFileName;
                } else {
                    showFlashMessage('error', "Une erreur est survenue lors du téléchargement de l'image.");
                }
            }
        }

        $teamData = [
            'picture' => $member_img,
            'profils_id_profil' => $profile_id,
        ];

        if ($teamController->updateTeam($member_id, $teamData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Membre mis à jour avec succès."
            ];
            header("Location: /admin/team/");
            exit();
        }

        showFlashMessage('error', "Une erreur est survenue lors de la mise à jour du membre.");
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
    <h1 class="mb-2">Modifier le membre</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Equipe</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier un membre</li>
        </ol>
    </nav>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="col-lg-12 my-4">
        <div class="form-group">
            <label for="member_img" class="mb-1 fs-6 fw-semibold">Sélectionner la photo d'illustration (jpg, jpeg, png, webp uniquement)</label>
            <input type="file" id="member_img" name="member_img" class="w-100" accept="image/jpg, image/jpeg, image/png, image/webp">
            <?php if (!empty($member_img)): ?>
                <p class="my-4">Image actuelle : <img src="<?php renderURL('uploads/teams/' . $member_img); ?>" alt="Image actuelle" style="width: 100px; height: auto;"></p>
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
            <a href="<?php renderURL('admin/team/') ?>" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
