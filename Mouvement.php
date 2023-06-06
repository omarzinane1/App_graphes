<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mouvement Des compteurs</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">RADEEJ</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar-->

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Accueil
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            graphiques
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="Interventions.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                    Nombre D'interventions
                                </a>
                            </nav>
                        </div>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="Exploitation.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                    Exploitation Assainissement Liquide
                                </a>
                            </nav>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">graphiques</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                        <li class="breadcrumb-item active">graphiques</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            Mouvement Des compteurs
                            <a target="_blank" href="#"></a>
                            .
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Graphique en aires
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                            <!-- Code PHP Chart -->
                            <?php
                            // Données du graphique
                            include("DbConnect.php");
                            // Requête SQL pour sélectionner les données de la table "compteurs"
                            $query = "SELECT * FROM compteurs";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $data = array();
                                $labels = array();
                                $compteurs_poses = array();
                                $B_I_D = array();
                                $casses = array();
                                $vieux = array();
                                $resiliations = array();

                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    $labels[] = $row['date'];
                                    $compteurs_poses[] = $row['compteurs_poses'];
                                    $B_I_D[] = $row['B_I_D'];
                                    $casses[] = $row['casses'];
                                    $vieux[] = $row['vieux'];
                                    $resiliations[] = $row['resiliations'];
                                }
                            } else {
                                echo "Aucune donnée trouvée dans la table 'compteurs'.";
                                exit();
                            }


                            // Génération du script JavaScript pour créer le graphique
                            echo "<script>
                                var ctx = document.getElementById('myChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: " . json_encode($labels) . ",
                                    datasets: [{
                                    label: 'Ventes mensuelles',
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                    }, {
                                    label: 'Compteurs posés',
                                    data: " . json_encode($compteurs_poses) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                    }, {
                                    label: 'B.I.D',
                                    data: " . json_encode($B_I_D) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                    }, {
                                    label: 'Casses',
                                    data: " . json_encode($casses) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                    }, {
                                    label: 'Vieux',
                                    data: " . json_encode($vieux) . ",
                                    backgroundColor: 'rgba(255, 0, 255, 0.5)'
                                    }, {
                                    label: 'Résiliations',
                                    data: " . json_encode($resiliations) . ",
                                    backgroundColor: 'rgba(0, 255, 255, 0.5)'
                                    }]
                                }
                                });
                            </script>";
                            ?>
                        </div>
                        <div class="card-footer small text-muted" id="updated-time">
                            <?php
                            date_default_timezone_set('Africa/Casablanca');
                            echo date('d/m/Y H:i:s');
                            ?>
                        </div>

                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Graphique à barres
                        </div>
                        <div class="card-body">
                            <canvas id="myChart1"></canvas>
                            <!-- Code PHP Chart -->
                            <?php
                            // Données du graphique
                            include("DbConnect.php");
                            // Requête SQL pour sélectionner les données de la table "compteurs"
                            $query = "SELECT * FROM compteurs";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $data = array();
                                $labels = array();
                                $compteurs_poses = array();
                                $B_I_D = array();
                                $casses = array();
                                $vieux = array();
                                $resiliations = array();

                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    $labels[] = $row['date'];
                                    $compteurs_poses[] = $row['compteurs_poses'];
                                    $B_I_D[] = $row['B_I_D'];
                                    $casses[] = $row['casses'];
                                    $vieux[] = $row['vieux'];
                                    $resiliations[] = $row['resiliations'];
                                }
                            } else {
                                echo "Aucune donnée trouvée dans la table 'compteurs'.";
                                exit();
                            }


                            // Génération du script JavaScript pour créer le graphique
                            echo "<script>
                                var ctx = document.getElementById('myChart1').getContext('2d');
                                var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: " . json_encode($labels) . ",
                                    datasets: [{
                                    label: 'Ventes mensuelles',
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                    }, {
                                    label: 'Compteurs posés',
                                    data: " . json_encode($compteurs_poses) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                    }, {
                                    label: 'B.I.D',
                                    data: " . json_encode($B_I_D) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                    }, {
                                    label: 'Casses',
                                    data: " . json_encode($casses) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                    }, {
                                    label: 'Vieux',
                                    data: " . json_encode($vieux) . ",
                                    backgroundColor: 'rgba(255, 0, 255, 0.5)'
                                    }, {
                                    label: 'Résiliations',
                                    data: " . json_encode($resiliations) . ",
                                    backgroundColor: 'rgba(0, 255, 255, 0.5)'
                                    }]
                                }
                                });
                            </script>";
                            ?>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        <?php
                        date_default_timezone_set('Africa/Casablanca');
                        echo date('d/m/Y H:i:s');
                        ?>
                    </div>
                   
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Graphique à barres
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                            <!-- Code PHP Chart -->
                            <?php
                            // Données du graphique
                            include("DbConnect.php");
                            // Requête SQL pour sélectionner les données de la table "compteurs"
                            $query = "SELECT * FROM compteurs";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $data = array();
                                $labels = array();
                                $compteurs_poses = array();
                                $B_I_D = array();
                                $casses = array();
                                $vieux = array();
                                $resiliations = array();

                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    $labels[] = $row['date'];
                                    $compteurs_poses[] = $row['compteurs_poses'];
                                    $B_I_D[] = $row['B_I_D'];
                                    $casses[] = $row['casses'];
                                    $vieux[] = $row['vieux'];
                                    $resiliations[] = $row['resiliations'];
                                }
                            } else {
                                echo "Aucune donnée trouvée dans la table 'compteurs'.";
                                exit();
                            }


                            // Génération du script JavaScript pour créer le graphique
                            echo "<script>
                                var ctx = document.getElementById('myChart2').getContext('2d');
                                var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: " . json_encode($labels) . ",
                                    datasets: [{
                                    label: 'Ventes mensuelles',
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                    }, {
                                    label: 'Compteurs posés',
                                    data: " . json_encode($compteurs_poses) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                    }, {
                                    label: 'B.I.D',
                                    data: " . json_encode($B_I_D) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                    }, {
                                    label: 'Casses',
                                    data: " . json_encode($casses) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                    }, {
                                    label: 'Vieux',
                                    data: " . json_encode($vieux) . ",
                                    backgroundColor: 'rgba(255, 0, 255, 0.5)'
                                    }, {
                                    label: 'Résiliations',
                                    data: " . json_encode($resiliations) . ",
                                    backgroundColor: 'rgba(0, 255, 255, 0.5)'
                                    }]
                                }
                                });
                            </script>";
                            ?>
                        </div>
                        
                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; RADEEJ WebApplication 2023</div>
                        <div>
                            <a href="#"></a>
                            &middot;
                            <a href="#"></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>