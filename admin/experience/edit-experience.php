<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ExperienceController.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ExperienceService.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Experience.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$experienceService = new ExperienceService(new Experience());
$profilService = new ProfilService(new Profil());

$profilController = new ProfilController($profilService);
$experienceController = new ExperienceController($experienceService);

$experience_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$experience = $experienceController->getExperienceById($experience_id);

if (!$experience) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Expérience non trouvée."
    ];
    header("Location: /admin/experience/");
    exit();
}

$profils = $profilController->getAllProfils();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job = trim($_POST['job'] ?? '');
    $date_start = trim($_POST['date_start'] ?? '');
    $date_end = trim($_POST['date_end'] ?? '');
    $company_name = trim($_POST['company_name'] ?? '');
    $company_address = trim($_POST['company_address'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $profile_id = (int)($_POST['profile_id'] ?? 0);

    if (empty($job) || empty($date_start) || empty($date_end) || empty($company_name) || empty($company_address) || $profile_id <= 0) {
        showFlashMessage('error', "Tous les champs obligatoires doivent être remplis.");
    } else {
        $currentDate = date('Y-m-d');
        if ($date_end >= $currentDate) {
            $date_end = "Present";
        }

        $experienceData = [
            'job' => $job,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'description' => $description,
            'profils_id_profil' => $profile_id,
        ];

        if ($experienceController->updateExperience($experience_id, $experienceData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Expérience mise à jour avec succès."
            ];

            header("Location: /admin/experience/");
            exit();
        }

        showFlashMessage('error', "Une erreur est survenue lors de la mise à jour de l'expérience.");
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

    <h1 class="mb-2">Modifier une expérience</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Expériences</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier une expérience</li>
        </ol>
    </nav>
</div>

<form action="" method="POST">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="job" class="mb-1 fs-6 fw-semibold">Poste</label>
                <input type="text" id="job" name="job" class="form-control" value="<?php echo htmlspecialchars($experience->job ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="company_name" class="mb-1 fs-6 fw-semibold">Nom de l'entreprise</label>
                <input type="text" id="company_name" name="company_name" class="form-control" value="<?php echo htmlspecialchars($experience->company_name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="company_address" class="mb-1 fs-6 fw-semibold">Adresse de l'entreprise</label>
                <input type="text" id="company_address" name="company_address" class="form-control" value="<?php echo htmlspecialchars($experience->company_address ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-3 my-4">
            <div class="form-group">
                <label for="date_start" class="mb-1 fs-6 fw-semibold">Date de début</label>
                <input type="date" id="date_start" name="date_start" class="form-control" value="<?php echo htmlspecialchars($experience->date_start ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-3 my-4">
            <div class="form-group">
                <label for="date_end" class="mb-1 fs-6 fw-semibold">Date de fin</label>
                <input type="date" id="date_end" name="date_end" class="form-control" value="<?php echo $experience->date_end === 'Present' ? '' : htmlspecialchars($experience->date_end ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="form-group">
                <label for="description" class="mb-1 fs-6 fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"><?php echo htmlspecialchars($experience->description ?? '', ENT_QUOTES); ?></textarea>
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
                                <?php echo $experience->profils_id_profil == $profil->id_profil ? 'selected' : ''; ?>>
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
            <button class="btn btn-primary py-2 w-100" type="submit">
                <span class="btn-label">Mettre à jour</span>
            </button>
        </div>
        <div class="col-lg-2">
            <a href="/admin/experience/" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
