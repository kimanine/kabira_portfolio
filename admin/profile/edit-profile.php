<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$profilService = new ProfilService(new Profil());
$profilController = new ProfilController($profilService);

$profil_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$profil = $profilController->getProfilById($profil_id);

if (!$profil) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Profil non trouvé."
    ];
    header("Location: /admin/profile/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $skill_description = trim($_POST['skill_description'] ?? '');

    $picture = $_FILES['picture'] ?? null;
    $cv = $_FILES['cv'] ?? null;

    if (empty($name) || empty($email) || empty($phone_number) || empty($address)) {
        showFlashMessage('error', "Tous les champs obligatoires doivent être remplis.");
    } else {
        $imageDir = __DIR__ . '/../../uploads/profils/images/';
        $cvDir = __DIR__ . '/../../uploads/profils/resumes/';

        if ((!is_dir($imageDir) && !mkdir($imageDir, 0755, true) && !is_dir($imageDir)) ||
            (!is_dir($cvDir) && !mkdir($cvDir, 0755, true) && !is_dir($cvDir))) {
            throw new \RuntimeException('Directory creation failed.');
        }

        $pictureName = $profil->picture;
        $cvName = $profil->cv;

        if (!empty($picture['name'])) {
            $validationResult = validateImage($picture);

            if ($validationResult !== true) {
                showFlashMessage('error', $validationResult);
            } else {
                $pictureExtension = strtolower(pathinfo($picture['name'], PATHINFO_EXTENSION));
                $newPictureName = uniqid('profil_', true) . '.' . $pictureExtension;

                if (move_uploaded_file($picture['tmp_name'], $imageDir . $newPictureName)) {
                    if (!empty($pictureName) && file_exists($imageDir . $pictureName)) {
                        unlink($imageDir . $pictureName);
                    }
                    $pictureName = $newPictureName;
                } else {
                    showFlashMessage('error', "Erreur lors de l'enregistrement de l'image.");
                }
            }
        }

        if (!empty($cv['name'])) {
            $cvExtension = strtolower(pathinfo($cv['name'], PATHINFO_EXTENSION));
            $allowedCVExtensions = ['pdf', 'doc', 'docx'];

            if (!in_array($cvExtension, $allowedCVExtensions)) {
                showFlashMessage('error', "Format de CV invalide.");
            } else {
                $newCVName = uniqid('cv_', true) . '.' . $cvExtension;

                if (move_uploaded_file($cv['tmp_name'], $cvDir . $newCVName)) {
                    if (!empty($cvName) && file_exists($cvDir . $cvName)) {
                        unlink($cvDir . $cvName);
                    }
                    $cvName = $newCVName;
                } else {
                    showFlashMessage('error', "Erreur lors de l'enregistrement du CV.");
                }
            }
        }

        $profilData = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'address' => $address,
            'description' => $description,
            'skill_description' => $skill_description,
            'picture' => $pictureName,
            'cv' => $cvName,
        ];

        if ($profilController->updateProfil($profil_id, $profilData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Profil mis à jour avec succès."
            ];

            header("Location: /admin/profile/");
            exit();
        } else {
            showFlashMessage('error', "Une erreur est survenue lors de la mise à jour du profil.");
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

    <h1 class="mb-2">Modifier un profil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Profils</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier un profil</li>
        </ol>
    </nav>
</div>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="name" class="mb-1 fs-6 fw-semibold">Nom</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($profil->name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="email" class="mb-1 fs-6 fw-semibold">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($profil->email ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="phone_number" class="mb-1 fs-6 fw-semibold">Téléphone</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($profil->phone_number ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="address" class="mb-1 fs-6 fw-semibold">Adresse</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($profil->address ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="form-group">
                <label for="description" class="mb-1 fs-6 fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"><?php echo htmlspecialchars($profil->description ?? '', ENT_QUOTES); ?></textarea>
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="form-group">
                <label for="skill_description" class="mb-1 fs-6 fw-semibold">Description des Compétences</label>
                <textarea id="skill_description" name="skill_description" class="form-control" rows="5"><?php echo htmlspecialchars($profil->skill_description ?? '', ENT_QUOTES); ?></textarea>
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="picture" class="mb-1 fs-6 fw-semibold">Photo de profil</label>
                <input type="file" id="picture" name="picture" class="form-control">
                <?php if ($profil->picture): ?>
                <p class="my-4">Image actuelle : <img src="/uploads/profils/images/<?php echo htmlspecialchars($profil->picture, ENT_QUOTES | ENT_HTML5); ?>" alt="Profil Image" width="100"></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="cv" class="mb-1 fs-6 fw-semibold">CV</label>
                <input type="file" id="cv" name="cv" class="form-control">
                <?php if ($profil->cv): ?>
                <p class="my-4"><a href="/uploads/profils/resumes/<?php echo htmlspecialchars($profil->cv, ENT_QUOTES | ENT_HTML5); ?>" target="_blank">Voir le CV</a></p>
                <?php endif; ?>
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
            <a href="/admin/profile/" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
