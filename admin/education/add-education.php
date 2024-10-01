<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/EducationController.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/EducationService.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Education.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$educationService = new EducationService(new Education());
$profilService = new ProfilService(new Profil());

$profilController = new ProfilController($profilService);
$educationController = new EducationController($educationService);

$profils = $profilController->getAllProfils();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $degree = trim($_POST['degree'] ?? '');
    $date_start = trim($_POST['date_start'] ?? '');
    $date_end = trim($_POST['date_end'] ?? '');
    $institution_name = trim($_POST['institution_name'] ?? '');
    $institution_address = trim($_POST['institution_address'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $profile_id = (int)($_POST['profile_id'] ?? 0);

    if (empty($degree) || empty($date_start) || empty($date_end) || empty($institution_name) || empty($institution_address) || $profile_id <= 0) {
        showFlashMessage('error', "Tous les champs obligatoires doivent être remplis.");
    } else {
        $currentDate = date('Y-m-d');
        if ($date_end >= $currentDate) {
            $date_end = "Present";
        }

        $educationData = [
            'degree' => $degree,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'institution_name' => $institution_name,
            'institution_address' => $institution_address,
            'description' => $description,
            'profils_id_profil' => $profile_id,
        ];

        if ($educationController->createEducation($educationData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Éducation ajoutée avec succès."
            ];

            if (isset($_POST['submit-and-quit'])) {
                header("Location: /admin/education/");
                exit();
            }

            if (isset($_POST['submit-and-continue'])) {
                header("Location: /admin/education/add-education.php");
                exit();
            }
        } else {
            showFlashMessage('error', "Une erreur est survenue lors de l'ajout de l'éducation.");
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

    <h1 class="mb-2">Ajouter une éducation</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Éducation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajouter une éducation</li>
        </ol>
    </nav>
</div>

<form action="" method="POST">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="degree" class="mb-1 fs-6 fw-semibold">Diplôme</label>
                <input type="text" id="degree" name="degree" class="form-control" value="<?php echo htmlspecialchars($_POST['degree'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="institution_name" class="mb-1 fs-6 fw-semibold">Nom de l'institution</label>
                <input type="text" id="institution_name" name="institution_name" class="form-control" value="<?php echo htmlspecialchars($_POST['institution_name'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="institution_address" class="mb-1 fs-6 fw-semibold">Adresse de l'institution</label>
                <input type="text" id="institution_address" name="institution_address" class="form-control" value="<?php echo htmlspecialchars($_POST['institution_address'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-3 my-4">
            <div class="form-group">
                <label for="date_start" class="mb-1 fs-6 fw-semibold">Date de début</label>
                <input type="date" id="date_start" name="date_start" class="form-control" value="<?php echo htmlspecialchars($_POST['date_start'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-3 my-4">
            <div class="form-group">
                <label for="date_end" class="mb-1 fs-6 fw-semibold">Date de fin</label>
                <input type="date" id="date_end" name="date_end" class="form-control" value="<?php echo htmlspecialchars($_POST['date_end'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="form-group">
                <label for="description" class="mb-1 fs-6 fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"><?php echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES); ?></textarea>
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
