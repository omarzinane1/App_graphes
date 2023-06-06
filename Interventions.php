<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Nombre D'interventions</title>
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
    <!-- Navbar Search-->

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
                <a class="nav-link" href="Mouvement.php">
                  <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                  Mouvement Des compteurs
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
            <li class="breadcrumb-item"><a href="index.php">Accuiel</a></li>
            <li class="breadcrumb-item active">graphiques</li>
          </ol>
          <div class="card mb-4">
            <div class="card-body">
              Nombre D'interventions
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
              <canvas id="Area"> </canvas>

              <?php
              // Données du graphique
              include("DbConnect.php");
              // Requête SQL pour sélectionner les données de la table "compteurs"
              $query = "SELECT * FROM n_interventions";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                $data = array();
                $labels = array();
                $compteurs = array();
                $conduites = array();
                $branchements = array();



                while ($row = mysqli_fetch_assoc($query_run)) {
                  $labels[] = $row['date_I'];
                  $compteurs[] = $row['compteurs'];
                  $conduites[] = $row['conduites'];
                  $branchements[] = $row['branchements'];
                }
              }

              // Génération du script JavaScript pour créer le graphique
              echo "<script>
                            var ctx = document.getElementById('Area').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                labels: " . json_encode($labels) . ",
                                datasets: [{
                                    fill: false,
                              lineTension: 0,
                                    
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                }, {
                                    label: 'Compteurs',
                                    data: " . json_encode($compteurs) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                }, {
                                    label: 'Conduites',
                                    data: " . json_encode($conduites) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                }, {
                                    label: 'Branchements',
                                    data: " . json_encode($branchements) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                }]
                                },
                                options: {
                                    legend: {display: false},
                                    scales: {
                                      yAxes: [{ticks: {min: 6, max:16}}],
                                    }
                                  }
                            });
                            </script>";
              ?>

            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>

          </div>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-chart-area me-1"></i>
              Graphique en aires
            </div>
            <div class="card-body">
              <canvas id="myBarChart" width="100%" height="50"></canvas>
              <?php
              // Données du graphique
              include("DbConnect.php");
              // Requête SQL pour sélectionner les données de la table "compteurs"
              $query = "SELECT * FROM n_interventions";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                $data = array();
                $labels = array();
                $compteurs = array();
                $conduites = array();
                $branchements = array();



                while ($row = mysqli_fetch_assoc($query_run)) {
                  $labels[] = $row['date_I'];
                  $compteurs[] = $row['compteurs'];
                  $conduites[] = $row['conduites'];
                  $branchements[] = $row['branchements'];
                }
              }

              // Génération du script JavaScript pour créer le graphique
              echo "<script>
                            var ctx = document.getElementById('myBarChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                labels: " . json_encode($labels) . ",
                                datasets: [{
                                    fill: false,
                              lineTension: 0,
                                    
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                }, {
                                    label: 'Compteurs',
                                    data: " . json_encode($compteurs) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                }, {
                                    label: 'Conduites',
                                    data: " . json_encode($conduites) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                }, {
                                    label: 'Branchements',
                                    data: " . json_encode($branchements) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                }]
                                },
                                options: {
                                    legend: {display: false},
                                    scales: {
                                      yAxes: [{ticks: {min: 6, max:16}}],
                                    }
                                  }
                            });
                            </script>";
              ?>

            </div>
          </div>


          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-chart-pie me-1"></i>
              Graphique circulaire
            </div>
            <div class="card-body">
              <canvas id="myPieChart" width="100%" height="50"></canvas>


              <?php
              // Données du graphique
              include("DbConnect.php");
              // Requête SQL pour sélectionner les données de la table "compteurs"
              $query = "SELECT * FROM n_interventions";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                $data = array();
                $labels = array();
                $compteurs = array();
                $conduites = array();
                $branchements = array();



                while ($row = mysqli_fetch_assoc($query_run)) {
                  $labels[] = $row['date_I'];
                  $compteurs[] = $row['compteurs'];
                  $conduites[] = $row['conduites'];
                  $branchements[] = $row['branchements'];
                }
              }

              // Génération du script JavaScript pour créer le graphique
              echo "<script>
                            var ctx = document.getElementById('myPieChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                labels: " . json_encode($labels) . ",
                                datasets: [{
                                    fill: false,
                              lineTension: 0,
                                    
                                    data: " . json_encode($data) . ",
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)'
                                }, {
                                    label: 'Compteurs',
                                    data: " . json_encode($compteurs) . ",
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)'
                                }, {
                                    label: 'Conduites',
                                    data: " . json_encode($conduites) . ",
                                    backgroundColor: 'rgba(0, 255, 0, 0.5)'
                                }, {
                                    label: 'Branchements',
                                    data: " . json_encode($branchements) . ",
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)'
                                }]
                                },
                                options: {
                                    legend: {display: false},
                                    scales: {
                                      yAxes: [{ticks: {min: 6, max:16}}],
                                    }
                                  }
                            });
                            </script>";
              ?>

            </div>

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
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="assets/demo/chart-pie-demo.js"></script>
</body>

</html>