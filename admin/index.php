<?php
require_once '../config/helpers.php';
include_once './partials/header.php';
?>
    <div class="pagetitle">
        <h1>Conteneur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Liste des conteneur de PIA</li>
            </ol>
        </nav>
    </div>

    <section class="col-lg-12 d-flex">
        <div class="card card-custom flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Exemple</h5>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Numéro</th>
                        <th scope="col">Type</th>
                        <th scope="col">Navire</th>
                        <th scope="col">ATP</th>
                        <th scope="col">Date</th>
                        <th scope="col">Terminal</th>
                        <th scope="col">consignataire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>MSDU1548456</td>
                        <td>40</td>
                        <td>MSC TARANTO</td>
                        <td>258796</td>
                        <td>28/02/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>MSCF4785632</td>
                        <td>20</td>
                        <td>MSC VILDAS</td>
                        <td>412845</td>
                        <td>03/03/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>MSDU1548456</td>
                        <td>40</td>
                        <td>MSC TARANTO</td>
                        <td>258796</td>
                        <td>28/02/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>MSCF4785632</td>
                        <td>20</td>
                        <td>MSC VILDAS</td>
                        <td>412845</td>
                        <td>03/03/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>MSDU1548456</td>
                        <td>40</td>
                        <td>MSC TARANTO</td>
                        <td>258796</td>
                        <td>28/02/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>MSCF4785632</td>
                        <td>20</td>
                        <td>MSC VILDAS</td>
                        <td>412845</td>
                        <td>03/03/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td>MSDU1548456</td>
                        <td>40</td>
                        <td>MSC TARANTO</td>
                        <td>258796</td>
                        <td>28/02/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td>MSCF4785632</td>
                        <td>20</td>
                        <td>MSC VILDAS</td>
                        <td>412845</td>
                        <td>03/03/2024</td>
                        <td>PIA</td>
                        <td>MSC</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav><!-- End Pagination with icons -->
        </div>

    </section>
<?php
include_once './partials/footer.php';
?>