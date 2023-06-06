<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/Tables.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div class="message-container">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<h4 class='message'>" . $_SESSION['message'] . '<button class="close-button" ><i class="fa-solid fa-xmark"></i></button></h4>';
            unset($_SESSION['message']);
        }
        ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4" id="titre">Tables</h1>
                <ol class="breadcrumb mb-4" id="btn_im&acc">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <button id="print-button" onclick="imprimerTable()">Imprimer la table</button>
                </ol>
                <div class="card mb-4" id="search">
                    <div class="card-body">
                        Mouvement Des Compteurs
                    </div>
                    <div class="search_form">
                        <!-- Add the search form -->
                        <form id="search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <label for="start-date">Date Début:</label>
                            <input type="date" name="start-date" id="start-date">
                            <label for="end-date">Date Fin:</label>
                            <input type="date" name="end-date" id="end-date">
                            <button id="btn_search" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>

                        Mouvement Des Compteurs
                    </div>
                    <div class="card-body">
                        <?php

                        include("DbConnect.php");
                        // section de tritement de données 
                        //insertion
                        if (isset($_POST['add'])) {
                            $date = $_POST['date'];
                            $compteurs_poses = $_POST['compteurs_poses'];
                            $B_I_D = $_POST['B_I_D'];
                            $casses = $_POST['casses'];
                            $vieux = $_POST['vieux'];
                            $resiliations = $_POST['resiliations'];


                            // Effectuer les opérations d'ajout dans la base de données ici
                            $sql = "INSERT INTO `compteurs`(`id`, `compteurs_poses`, `B_I_D`, `casses`, `vieux`, `resiliations`, `date`) VALUES (null,'$compteurs_poses','$B_I_D','$casses','$vieux','$resiliations','$date')";

                            if (mysqli_query($con, $sql)) {
                                $_SESSION['message'] = "La ligne a été ajoutée avec succès.";
                            } else {
                                $_SESSION['message'] = "Une erreur s'est produite lors de l'ajout de la ligne.";
                            }

                            // Rediriger l'utilisateur vers la page actuelle pour rafraîchir les données
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                        // modification

                        if (isset($_POST['update'])) {
                            $id = $_POST['id'];
                            $compteurs_poses = $_POST['compteurs_poses'];
                            $B_I_D = $_POST['B_I_D'];
                            $casses = $_POST['casses'];
                            $vieux = $_POST['vieux'];
                            $resiliations = $_POST['resiliations'];
                            $date_e = $_POST['date_e'];


                            $sql = "UPDATE compteurs SET `compteurs_poses`='$compteurs_poses', `B_I_D`='$B_I_D', `casses`='$casses', `vieux`='$vieux', `resiliations`='$resiliations', `date_e`='$date_e' WHERE `id`='$id'";
                            if (mysqli_query($con, $sql)) {
                                $_SESSION['message'] = "Les données ont été modifiées avec succès.";
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit();
                            } else {
                                $_SESSION['message'] = "Une erreur s'est produite lors de la modification des données.";
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit();
                            }
                        }
                        if (isset($_POST['delete'])) {
                            $id = $_POST['id'];
                            $sql = "DELETE FROM compteurs WHERE `id`='$id'";
                            if (mysqli_query($con, $sql)) {
                                $_SESSION['message'] = "Les données ont été supprimées avec succès.";
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit();
                            } else {
                                $_SESSION['message'] = "Une erreur s'est produite lors de la suppression des données.";
                                header("Location: " . $_SERVER['PHP_SELF']);
                                exit();
                            }
                        }
                        ?>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Date</th>
                                    <th>Compteurs posés</th>
                                    <th>Bloqués/illisible/douteaux</th>
                                    <th>Cassés</th>
                                    <th>Vieux</th>
                                    <th>Résiliations</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Inclure le fichier de configuration de la base de données
                                include('DbConnect.php');
                                if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
                                    $startDate = $_POST['start-date'];
                                    $endDate = $_POST['end-date'];


                                    // Modifier la requête SQL pour inclure les dates de recherche
                                    $req = mysqli_query($con, "SELECT * FROM compteurs WHERE date BETWEEN '$startDate' AND '$endDate'");
                                    
                                } else {
                                    $req = mysqli_query($con, "SELECT * FROM compteurs");
                                }

                                // Vérifier s'il y a des résultats
                                if (mysqli_num_rows($req) == 0) {
                                    // S'il n'y a pas de données, afficher un message
                                    echo '<tr><td colspan="13">Il n\'y a pas encore de données</td></tr>';
                                } else {
                                    $totalCompteursPoses = 0;
                                    $totalBID = 0;
                                    $totalCasses = 0;
                                    $totalVieux = 0;
                                    $totalResiliations = 0;
                                    // Sinon, afficher les données existantes
                                    while ($row = mysqli_fetch_assoc($req)) {
                                        $totalCompteursPoses += $row['compteurs_poses'];
                                        $totalBID += $row['B_I_D'];
                                        $totalCasses += $row['casses'];
                                        $totalVieux += $row['vieux'];
                                        $totalResiliations += $row['resiliations'];

                                        if (isset($_GET['id']) && $_GET['id'] == $row['id']) {
                                            // Si le paramètre N_lot est présent dans l'URL et correspond à la ligne en cours de traitement,
                                            // afficher le formulaire de modification
                                            echo '<form method="POST" action="">';
                                            echo '<tr>';
                                            echo '<td> <input type="text" name="id" value="' . $row['id'] . '"> </td>';
                                            echo '<td> <input type="text" name="date" value="' . $row['date'] . '"> </td>';
                                            echo '<td> <input type="text" name="compteurs_poses" value="' . $row['compteurs_poses'] . '"> </td>';
                                            echo '<td> <input type="text" name="B_I_D" value="' . $row['B_I_D'] . '"> </td>';
                                            echo '<td> <input type="text" name="casses" value="' . $row['casses'] . '"> </td>';
                                            echo '<td> <input type="text" name="vieux" value="' . $row['vieux'] . '"> </td>';
                                            echo '<td> <input type="text" name="resiliations" value="' . $row['resiliations'] . '"> </td>';
                                            echo '<td> <button type="submit" name="update">Modifier</button> </td>';
                                            echo '<td> <button type="submit" name="delete">Supprimer</button> </td>';

                                            echo '</form>';
                                        } else {
                                            // Afficher les données existantes avec un lien pour la modification
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['date'] . '</td>';
                                            echo '<td>' . $row['compteurs_poses'] . '</td>';
                                            echo '<td>' . $row['B_I_D'] . '</td>';
                                            echo '<td>' . $row['casses'] . '</td>';
                                            echo '<td>' . $row['vieux'] . '</td>';
                                            echo '<td>' . $row['resiliations'] . '</td>';


                                            echo '<td><a type="submit" name="update" href="?id=' . $row['id'] . '">Modifier</a></td>';
                                            echo '<td><a type="submit" name="delete" href="?id=' . $row['id'] . '">Supprimer</a></td>';

                                            echo '</tr>';
                                        }
                                    }
                                    echo '<form method="POST" action="">';
                                    echo '<tr id="continte_table">';
                                    echo '<td></td>';
                                    echo '<td> <input type="date" name="date" placeholder="Date"> </td>';
                                    echo '<td> <input type="text" name="compteurs_poses" placeholder="Compteurs"> </td>';
                                    echo '<td> <input type="text" name="B_I_D" placeholder="Conduites"> </td>';
                                    echo '<td> <input type="text" name="casses" placeholder="Branchements"> </td>';
                                    echo '<td> <input type="text" name="vieux" placeholder="Piéces"> </td>';
                                    echo '<td> <input type="text" name="resiliations" placeholder="Résiliations"> </td>';
                                    echo '<td> <button type="submit" name="add" style="width: 100%; ">Ajouter</button> </td>';
                                    echo '<td> <button type="reset" style="width: 100%; ">Effacer</button> </td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                    echo '</form>';
                                    //total
                                    echo '<tr>';
                                    echo '<td colspan="2"><i class="fa-solid fa-ticket"></i> Total</td>';
                                    echo '<td>' . $totalCompteursPoses . '</td>';
                                    echo '<td>' . $totalBID . '</td>';
                                    echo '<td>' . $totalCasses . '</td>';
                                    echo '<td>' . $totalVieux . '</td>';
                                    echo '<td>' . $totalResiliations . '</td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                }

                                echo '</table>';

                                mysqli_free_result($req);
                                mysqli_close($con);
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/files.js"></script>
</body>

</html>