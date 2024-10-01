<?php
ob_start();
session_start();
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../controllers/admin/ServiceController.php';
require_once __DIR__ . '/../../services/ServiceService.php';
require_once __DIR__ . '/../../models/Service.php';
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

// Initialisation des services et des contrôleurs
$serviceService = new ServiceService(new Service());
$serviceController = new ServiceController($serviceService);

$profilService = new ProfilService(new Profil());
$profilController = new ProfilController($profilService);

$profils = $profilController->getAllProfils();

// Récupérer l'ID du service à partir de l'URL
$service_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$service = $serviceController->getServiceById($service_id);

if (!$service) {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'text' => "Service non trouvé."
    ];
    header("Location: /admin/service/");
    exit();
}

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $profile_id = (int)($_POST['profile_id'] ?? 0);

    if (empty($name) || empty($price) || empty($description) || $profile_id <= 0) {
        showFlashMessage('error', "Tous les champs sont obligatoires.");
    } else {
        $serviceData = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'profils_id_profil' => $profile_id,
        ];

        if ($serviceController->updateService($service_id, $serviceData)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => "Service mis à jour avec succès."
            ];
            header("Location: /admin/service/");
            exit();
        } else {
            showFlashMessage('error', "Une erreur est survenue lors de la mise à jour du service.");
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

    <h1 class="mb-2">Modifier le service</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier un service</li>
        </ol>
    </nav>
</div>

<form action="" method="POST">
    <div class="row">
        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="service_name" class="mb-1 fs-6 fw-semibold">Nom du service</label>
                <input type="text" id="service_name" name="name" class="form-control" value="<?php echo htmlspecialchars($service->name ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-6 my-4">
            <div class="form-group">
                <label for="service_price" class="mb-1 fs-6 fw-semibold">Prix du service</label>
                <input type="number" id="service_price" name="price" class="form-control" min="0" step="0.01" value="<?php echo htmlspecialchars($service->price ?? '', ENT_QUOTES); ?>">
            </div>
        </div>

        <div class="col-lg-12 my-4">
            <div class="form-group">
                <label for="service_description" class="mb-1 fs-6 fw-semibold">Description du service</label>
                <textarea id="service_description" name="description" class="form-control" rows="5"><?php echo htmlspecialchars($service->description ?? '', ENT_QUOTES); ?></textarea>
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
                                <?php echo $service->profils_id_profil == $profil->id_profil ? 'selected' : ''; ?>>
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
            <a href="/admin/service/" class="btn btn-secondary py-2 w-100">Annuler</a>
        </div>
    </div>
</form>

<?php
include_once __DIR__ . '/../partials/footer.php';
ob_end_flush();
?>
