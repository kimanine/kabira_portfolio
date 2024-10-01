<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ProfilController.php';
require_once __DIR__ . '/../../services/ProfilService.php';
require_once __DIR__ . '/../../models/Profil.php';
include_once __DIR__ . '/../partials/header.php';

$profilService = new ProfilService(new Profil());
$profilController = new ProfilController($profilService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_id'])) {
    $profilId = (int)$_POST['profil_id'];

    if ($profilController->deleteProfil($profilId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Profil supprimé avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression du profil."
        ];
    }

    header("Location: /admin/profile/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$offset = ($page - 1) * $limit;
$totalProfils = $profilController->getTotalProfils();
$totalPages = ceil($totalProfils / $limit);

$profils = $profilController->getAllProfils($limit, $page);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Profils</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les profils</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/profile/add-profile.php') ?>" class="btn btn-primary mb-3">Ajouter un profil</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Profils</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Photo</th>
                    <th scope="col">CV</th>
                    <th scope="col">Description</th>
                    <th scope="col">Compétences</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($profils)): ?>
                    <?php foreach ($profils as $profil): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($profil->name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($profil->email ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($profil->phone_number ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($profil->address ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td>
                                <?php if (!empty($profil->picture)): ?>
                                    <img src="<?php renderURL('uploads/profils/images/' . $profil->picture); ?>" alt="Profil Picture" style="width: 50px; height: auto;">
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($profil->cv)): ?>
                                    <a href="<?php renderURL('uploads/profils/resumes/' . $profil->cv); ?>" target="_blank">Voir le CV</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars(substr($profil->description, 0, 50) . '...', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars(substr($profil->skill_description, 0, 50) . '...', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/profile/edit-profile.php?id='. $profil->id_profil) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $profil->id_profil; ?>" data-bs-name="<?php echo htmlspecialchars($profil->name, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Aucun profil trouvé.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer <strong id="profil-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="profil_id" id="profil-id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '/../partials/footer.php';
?>

<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const profilId = button.getAttribute('data-bs-id');
        const profilName = button.getAttribute('data-bs-name');

        const modalProfilName = deleteModal.querySelector('#profil-name');
        const inputProfilId = deleteModal.querySelector('#profil-id');

        modalProfilName.textContent = profilName;
        inputProfilId.value = profilId;
    });
</script>

<?php
ob_end_flush();
?>
