<?php
ob_start();
session_start();
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../controllers/admin/ExperienceController.php';
require_once __DIR__ . '/../../services/ExperienceService.php';
require_once __DIR__ . '/../../models/Experience.php';
include_once __DIR__ . '/../partials/header.php';

$experienceService = new ExperienceService(new Experience());
$experienceController = new ExperienceController($experienceService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['experience_id'])) {
    $experienceId = (int)$_POST['experience_id'];

    if ($experienceController->deleteExperience($experienceId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Expérience supprimée avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression de l'expérience."
        ];
    }

    header("Location: /admin/experience/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$totalExperiences = $experienceController->getTotalExperiences();
$totalPages = ceil($totalExperiences / $limit);

$experiences = $experienceController->getAllExperiences($limit, $page);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Expériences</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les expériences</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/experience/add-experience.php') ?>" class="btn btn-primary mb-3">Ajouter une expérience</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Expériences</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Poste</th>
                    <th scope="col">Entreprise</th>
                    <th scope="col">Adresse Entreprise</th>
                    <th scope="col">Période</th>
                    <th scope="col">Description</th>
                    <th scope="col">Profil</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($experiences)): ?>
                    <?php foreach ($experiences as $experience): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($experience->job ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($experience->company_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($experience->company_address ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($experience->date_start, ENT_QUOTES | ENT_HTML5); ?> - <?php echo htmlspecialchars($experience->date_end, ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($experience->description ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($experience->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/experience/edit-experience.php?id='. $experience->id_experience) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $experience->id_experience; ?>" data-bs-name="<?php echo htmlspecialchars($experience->job, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Aucune expérience trouvée.</td>
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

    <!-- Modal de Confirmation de Suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer <strong id="experience-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="experience_id" id="experience-id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../partials/footer.php';
?>

<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const experienceId = button.getAttribute('data-bs-id');
        const experienceName = button.getAttribute('data-bs-name');

        const modalExperienceName = deleteModal.querySelector('#experience-name');
        const inputExperienceId = deleteModal.querySelector('#experience-id');

        modalExperienceName.textContent = experienceName;
        inputExperienceId.value = experienceId;
    });
</script>

<?php
ob_end_flush();
?>
