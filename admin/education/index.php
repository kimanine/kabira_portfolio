<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/EducationController.php';
require_once __DIR__ . '/../../services/EducationService.php';
require_once __DIR__ . '/../../models/Education.php';
include_once __DIR__ . '/../partials/header.php';

$educationService = new EducationService(new Education());
$educationController = new EducationController($educationService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['education_id'])) {
    $educationId = (int)$_POST['education_id'];

    if ($educationController->deleteEducation($educationId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Éducation supprimée avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression de l'éducation."
        ];
    }

    header("Location: /admin/education/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$totalEducations = $educationController->getTotalEducations();
$totalPages = ceil($totalEducations / $limit);

$educations = $educationController->getAllEducations($limit, $page);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Éducations</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les éducations</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/education/add-education.php') ?>" class="btn btn-primary mb-3">Ajouter une éducation</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Éducations</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Diplôme</th>
                    <th scope="col">Institution</th>
                    <th scope="col">Adresse Institution</th>
                    <th scope="col">Période</th>
                    <th scope="col">Description</th>
                    <th scope="col">Profil</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($educations)): ?>
                    <?php foreach ($educations as $education): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($education->degree ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($education->institution_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($education->institution_address ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($education->date_start, ENT_QUOTES | ENT_HTML5); ?> - <?php echo htmlspecialchars($education->date_end, ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($education->description ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($education->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/education/edit-education.php?id='. $education->id_education) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $education->id_education; ?>" data-bs-name="<?php echo htmlspecialchars($education->degree, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Aucune éducation trouvée.</td>
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
                    Êtes-vous sûr de vouloir supprimer <strong id="education-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="education_id" id="education-id" value="">
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
        const educationId = button.getAttribute('data-bs-id');
        const educationName = button.getAttribute('data-bs-name');

        const modalEducationName = deleteModal.querySelector('#education-name');
        const inputEducationId = deleteModal.querySelector('#education-id');

        modalEducationName.textContent = educationName;
        inputEducationId.value = educationId;
    });
</script>

<?php
ob_end_flush();
?>
