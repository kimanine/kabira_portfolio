<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/SkillController.php';
require_once __DIR__ . '/../../services/SkillService.php';
require_once __DIR__ . '/../../models/Skill.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$skillService = new SkillService(new Skill());
$skillController = new SkillController($skillService);

$profilService = new ProfilService(new Profil());
$profilController = new ProfilController($profilService);

$profils = $profilController->getAllProfils();

$skill_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$skill = $skillController->getSkillById($skill_id);

if (!$skill) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Compétence non trouvée."
    ];
    header("Location: /admin/skill/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $color = trim($_POST['color'] ?? '');
    $percentage = trim($_POST['percentage'] ?? '');
    $profile_id = (int)($_POST['profile_id'] ?? 0);

    if (empty($name) || empty($color) || empty($percentage) || $profile_id <= 0) {
        showFlashMessage('error', "Tous les champs sont obligatoires.");
    } else {
        $skillData = [
            'name' => $name,
            'color' => $color,
            'percentage' => $percentage,
            'profils_id_profil' => $profile_id,
        ];

        if ($skillController->updateSkill($skill_id, $skillData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Compétence mise à jour avec succès."
            ];
            header("Location: /admin/skill/");
            exit();
        } else {
            showFlashMessage('error', "Une erreur est survenue lors de la mise à jour de la compétence.");
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

    <h1 class="mb-2">Modifier la compétence</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Compétences</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier une compétence</li>
        </ol>
    </nav>
</div>

<form action="" method="POST">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="skill_name" class="mb-1 fs-6 fw-semibold">Nom de la compétence</label>
                <input type="text" id="skill_name" name="name" class="form-control" value="<?php echo htmlspecialchars($skill->name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="skill_color" class="mb-1 fs-6 fw-semibold">Couleur</label>
                <input type="color" id="skill_color" name="color" class="form-control" value="<?php echo htmlspecialchars($skill->color ?? '#000000', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="skill_percentage" class="mb-1 fs-6 fw-semibold">Pourcentage</label>
                <input type="number" id="skill_percentage" name="percentage" class="form-control" min="0" max="100" value="<?php echo htmlspecialchars($skill->percentage ?? '', ENT_QUOTES); ?>">
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
                                <?php echo $skill->profils_id_profil == $profil->id_profil ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($profil->name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Aucun profil trouvé</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="d-flex my-4">
        <div class="col-lg-2 me-3">
            <button class="btn btn-primary py-2 w-100" type="submit" name="submit-update">
                <span class="btn-label">Mettre à jour</span>
            </button>
        </div>
        <div class="col-lg-2">
            <a href="/admin/skill/" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
