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
                        Exploitation Assainissement Liquide
                    </div>

                    <div class="search_form" >
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
                        Exploitation Assainissement Liquide
                    </div>
                    <div class="card-body">
                        <?php

                        include("DbConnect.php");
                        // section de tritement de données 

                        // Ajout d'une nouvelle ligne
                        if (isset($_POST['add'])) {
                            $N_Reclamations_T = $_POST['N_Reclamations_T_add'];
                            $N_Regars_cures = $_POST['N_Regars_cures_add'];
                            $quantit_dechets = $_POST['quantit_dechets_add'];
                            $Lineaire_Reseau = $_POST['Lineaire_Reseau_add'];
                            $Fosses_septiques_v = $_POST['Fosses_septiques_v_add'];
                            $date_e = $_POST['date_e_add'];

                            // Effectuer les opérations d'ajout dans la base de données ici
                            $sql = "INSERT INTO `exploitation`(`id`, `N_Reclamations_T`, `N_Regars_cures`, `quantit_dechets`, `Lineaire_Reseau`, `Fosses_septiques_v`, `date_e`) VALUES (null, '$N_Reclamations_T', '$N_Regars_cures', '$quantit_dechets', '$Lineaire_Reseau', '$Fosses_septiques_v', '$date_e')";

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
                            $N_Reclamations_T = $_POST['N_Reclamations_T'];
                            $N_Regars_cures = $_POST['N_Regars_cures'];
                            $quantit_dechets = $_POST['quantit_dechets'];
                            $Lineaire_Reseau = $_POST['Lineaire_Reseau'];
                            $Fosses_septiques_v = $_POST['Fosses_septiques_v'];
                            $date_e = $_POST['date_e'];


                            $sql = "UPDATE exploitation SET `N_Reclamations_T`='$N_Reclamations_T', `N_Regars_cures`='$N_Regars_cures', `quantit_dechets`='$quantit_dechets', `Lineaire_Reseau`='$Lineaire_Reseau', `Fosses_septiques_v`='$Fosses_septiques_v', `date_e`='$date_e' WHERE `id`='$id'";
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
                            $sql = "DELETE FROM exploitation WHERE id ='$id'";
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
                                    <th>Réclamations Traitées</th>
                                    <th>N_Regars Curés</th>
                                    <th>Quantité De Déchets</th>
                                    <th>Linéaire Du Réseau Débouches</th>
                                    <th>Fosses Septiques Vidangées</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Inclure le fichier de configuration de la base de données
                                include('DbConnect.php');
                                // Vérifier si les dates de recherche sont spécifiées
                                if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
                                    $startDate = $_POST['start-date'];
                                    $endDate = $_POST['end-date'];
                                    

                                    // Modifier la requête SQL pour inclure les dates de recherche
                                    $req = mysqli_query($con, "SELECT * FROM exploitation WHERE date_e BETWEEN '$startDate' AND '$endDate'");
                                } else {

                                    
                                    $req = mysqli_query($con, "SELECT * FROM exploitation");
                                }
                                // Vérifier s'il y a des résultats
                                if (mysqli_num_rows($req) == 0) {
                                    // S'il n'y a pas de données, afficher un message
                                    echo '<tr><td colspan="13">Il n\'y a pas encore de données</td></tr>';
                                } else {
                                    $totalReclamationsTraitees = 0;
                                    $totalNRegarsCures = 0;
                                    $totalQuantiteDechets = 0;
                                    $totalLineaireReseau = 0;
                                    $totalFossesSeptiquesVidangees = 0;
                                    // Sinon, afficher les données existantes
                                    while ($row = mysqli_fetch_assoc($req)) {
                                        $totalReclamationsTraitees += $row['N_Reclamations_T'];
                                        $totalNRegarsCures += $row['N_Regars_cures'];
                                        $totalQuantiteDechets += $row['quantit_dechets'];
                                        $totalLineaireReseau += $row['Lineaire_Reseau'];
                                        $totalFossesSeptiquesVidangees += $row['Fosses_septiques_v'];
                                        if (isset($_GET['id']) && $_GET['id'] == $row['id']) {
                                            // Si le paramètre N_lot est présent dans l'URL et correspond à la ligne en cours de traitement,
                                            // afficher le formulaire de modification
                                            echo '<form method="POST" action="">';
                                            echo '<tr>';
                                            echo '<td> <input type="text" name="id" value="' . $row['id'] . '"> </td>';
                                            echo '<td> <input type="text" name="date_e" value="' . $row['date_e'] . '"> </td>';
                                            echo '<td> <input type="text" name="N_Reclamations_T" value="' . $row['N_Reclamations_T'] . '"> </td>';
                                            echo '<td> <input type="text" name="N_Regars_cures" value="' . $row['N_Regars_cures'] . '"> </td>';
                                            echo '<td> <input type="text" name="quantit_dechets" value="' . $row['quantit_dechets'] . '"> </td>';
                                            echo '<td> <input type="text" name="Lineaire_Reseau" value="' . $row['Lineaire_Reseau'] . '"> </td>';
                                            echo '<td> <input type="text" name="Fosses_septiques_v" value="' . $row['Fosses_septiques_v'] . '"> </td>';
                                            echo '<td> <button  type="submit" name="update">Modifier</button> </td>';
                                            echo '<td> <button type="submit" name="delete">Supprimer</button> </td>';

                                            echo '</form>';
                                        } else {
                                            // Afficher les données existantes avec un lien pour la modification
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['date_e'] . '</td>';
                                            echo '<td>' . $row['N_Reclamations_T'] . '</td>';
                                            echo '<td>' . $row['N_Regars_cures'] . '</td>';
                                            echo '<td>' . $row['quantit_dechets'] . '</td>';
                                            echo '<td>' . $row['Lineaire_Reseau'] . '</td>';
                                            echo '<td>' . $row['Fosses_septiques_v'] . '</td>';

                                            echo '<td><a type="submit" name="update" href="?id=' . $row['id'] . '">Modifier</a></td>';
                                            echo '<td><a type="submit" name="delete" href="?id=' . $row['id'] . '">Supprimer</a></td>';

                                            echo '</tr>';
                                        }
                                    }
                                    // Afficher la ligne pour ajouter une nouvelle ligne
                                    echo '<form method="POST" action="" >';
                                    echo '<tr id="continte_table">';
                                    echo '<td></td>';
                                    echo '<td> <input type="date" name="date_e_add" placeholder="Date"> </td>';
                                    echo '<td> <input type="text" name="N_Reclamations_T_add" placeholder="Réclamations Traitées"> </td>';
                                    echo '<td> <input type="text" name="N_Regars_cures_add" placeholder="N_Regars Curés"> </td>';
                                    echo '<td> <input type="text" name="quantit_dechets_add" placeholder="Quantité De Déchets"> </td>';
                                    echo '<td> <input type="text" name="Lineaire_Reseau_add" placeholder="Linéaire Du Réseau Débouchés"> </td>';
                                    echo '<td> <input type="text" name="Fosses_septiques_v_add" placeholder="Fosses Septiques Vidangées"> </td>';
                                    echo '<td > <button  type="submit" name="add" style="width: 100%; ">Ajouter</button> </td>';
                                    echo '<td > <button type="reset" style="width: 100%; ">Effacer</button> </td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                    echo '</form>';

                                    // Afficher la ligne des totaux
                                    echo '<tr>';
                                    echo '<td colspan="2"><i class="fa-solid fa-ticket"></i> Total</td>';
                                    echo '<td>' . $totalReclamationsTraitees . '</td>';
                                    echo '<td>' . $totalNRegarsCures . '</td>';
                                    echo '<td>' . $totalQuantiteDechets . '</td>';
                                    echo '<td>' . $totalLineaireReseau . '</td>';
                                    echo '<td>' . $totalFossesSeptiquesVidangees . '</td>';
                                    echo '<td></td>';
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