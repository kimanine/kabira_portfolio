<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/ProjectController.php';
require_once __DIR__ . '/../../services/ProjectService.php';
require_once __DIR__ . '/../../models/Project.php';
include_once __DIR__ . '/../partials/header.php';

$projectService = new ProjectService(new Project());
$projectController = new ProjectController($projectService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    $projectId = (int)$_POST['project_id'];

    if ($projectController->deleteProject($projectId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Projet supprimé avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression du projet."
        ];
    }

    header("Location: /admin/project/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$totalProjects = $projectController->getTotalProjects();
$totalPages = ceil($totalProjects / $limit);

$projects = $projectController->getAllProjects($limit, $page);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Projets</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les projets</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/project/add-project.php') ?>" class="btn btn-primary mb-3">Ajouter un projet</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Projets</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Profil</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td>
                                <img src="<?php renderURL('uploads/projects/' . $project->picture) ?>" alt="Banner" style="width: 5rem; height: 2rem; object-fit: cover">
                            </td>
                            <td><?php echo htmlspecialchars($project->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/project/edit-project.php?id='. $project->id_project) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $project->id_project; ?>" data-bs-name="<?php echo htmlspecialchars($project->profil_name, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Aucun projet trouvé.</td>
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
                    Êtes-vous sûr de vouloir supprimer <strong id="project-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="project_id" id="project-id" value="">
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
        const projectId = button.getAttribute('data-bs-id');
        const projectName = button.getAttribute('data-bs-name');

        const modalProjectName = deleteModal.querySelector('#project-name');
        const deleteForm = deleteModal.querySelector('#delete-form');
        const inputProjectId = deleteModal.querySelector('#project-id');

        modalProjectName.textContent = projectName;
        inputProjectId.value = projectId;
    });
</script>

<?php
ob_end_flush();
?>
