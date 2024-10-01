<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/TeamController.php';
require_once __DIR__ . '/../../services/TeamService.php';
require_once __DIR__ . '/../../models/Team.php';
include_once __DIR__ . '/../partials/header.php';

$teamService = new TeamService(new Team());
$teamController = new TeamController($teamService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_id'])) {
    $memberId = (int)$_POST['member_id'];

    if ($teamController->deleteTeam($memberId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Membre supprimé avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression du membre."
        ];
    }

    header("Location: /admin/team/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$totalMembers = $teamController->getTotalTeams();
$totalPages = ceil($totalMembers / $limit);

$members = $teamController->getAllTeams($limit, $page);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Equipes</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les membres de l'équipe</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/team/add-team.php') ?>" class="btn btn-primary mb-3">Ajouter un membre</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Membres</h5>
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
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td>
                                <img src="<?php renderURL('uploads/teams/' . $member->picture) ?>" alt="Banner" style="width: 5rem; height: 2rem; object-fit: cover">
                            </td>
                            <td><?php echo htmlspecialchars($member->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/team/edit-team.php?id='. $member->id_team) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $member->id_team; ?>" data-bs-name="<?php echo htmlspecialchars($member->profil_name, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Aucun membre trouvé.</td>
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
                    Êtes-vous sûr de vouloir supprimer <strong id="member-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="member_id" id="member-id" value="">
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
        const memberId = button.getAttribute('data-bs-id');
        const memberName = button.getAttribute('data-bs-name');

        const modalMemberName = deleteModal.querySelector('#member-name');
        const deleteForm = deleteModal.querySelector('#delete-form');
        const inputMemberId = deleteModal.querySelector('#member-id');

        modalMemberName.textContent = memberName;
        inputMemberId.value = memberId;
    });
</script>

<?php
ob_end_flush();
?>
