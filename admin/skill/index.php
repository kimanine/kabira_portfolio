<?php
ob_start();
require_once __DIR__ . '/../../controllers/admin/SkillController.php';
require_once __DIR__ . '/../../services/SkillService.php';
require_once __DIR__ . '/../../models/Skill.php';
include_once __DIR__ . '/../partials/header.php';

$skillService = new SkillService(new Skill());
$skillController = new SkillController($skillService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill_id'])) {
    $skillId = (int)$_POST['skill_id'];

    if ($skillController->deleteSkill($skillId)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Compétence supprimée avec succès."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => "Une erreur est survenue lors de la suppression de la compétence."
        ];
    }

    header("Location: /admin/skill/");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 25;
$offset = ($page - 1) * $limit;
$totalSkills = $skillController->getTotalSkills();
$totalPages = ceil($totalSkills / $limit);

$skills = $skillController->getAllSkills($limit, $offset);
?>

<div class="pagetitle">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        showFlashMessage($flash['type'], $flash['text']);
        unset($_SESSION['flash_message']);
    }
    ?>

    <h1>Compétences</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Les compétences</li>
        </ol>
    </nav>
</div>

<a href="<?php renderURL('admin/skill/add-skill.php') ?>" class="btn btn-primary mb-3">Ajouter une compétence</a>

<section class="col-lg-12 d-flex">
    <div class="card card-custom flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Compétences</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Couleur</th>
                    <th scope="col">Pourcentage</th>
                    <th scope="col">Profil</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($skills)): ?>
                    <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($skill->name, ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><span style="background-color: <?php echo htmlspecialchars($skill->color, ENT_QUOTES | ENT_HTML5); ?>; padding: 5px 10px; border-radius: 5px; color: #fff;"><?php echo htmlspecialchars($skill->color, ENT_QUOTES | ENT_HTML5); ?></span></td>
                            <td><?php echo htmlspecialchars($skill->percentage, ENT_QUOTES | ENT_HTML5); ?>%</td>
                            <td><?php echo htmlspecialchars($skill->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td><?php echo htmlspecialchars($skill->profil_name ?? 'N/A', ENT_QUOTES | ENT_HTML5); ?></td>
                            <td class="actions d-md-table-cell">
                                <div class="d-flex gap-3">
                                    <a href="<?php renderURL('admin/skill/edit-skill.php?id='. $skill->id_competence) ?>" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="<?php echo $skill->id_competence; ?>" data-bs-name="<?php echo htmlspecialchars($skill->name, ENT_QUOTES | ENT_HTML5); ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucune compétence trouvée.</td>
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
                    Êtes-vous sûr de vouloir supprimer <strong id="skill-name"></strong> ?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="POST" action="">
                        <input type="hidden" name="skill_id" id="skill-id" value="">
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
        const skillId = button.getAttribute('data-bs-id');
        const skillName = button.getAttribute('data-bs-name');

        const modalSkillName = deleteModal.querySelector('#skill-name');
        const inputSkillId = deleteModal.querySelector('#skill-id');

        modalSkillName.textContent = skillName;
        inputSkillId.value = skillId;
    });
</script>

<?php
ob_end_flush();
?>
