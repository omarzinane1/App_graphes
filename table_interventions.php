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
                        Nombre D'intervetions
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
                        Nombre D'intervetions
                    </div>
                    <div class="card-body">
                        <?php

                        include("DbConnect.php");
                        // section de tritement de données 
                        //insertion
                        if (isset($_POST['add'])) {
                            $date_I_add = $_POST['date_I_add'];
                            $compteurs = $_POST['compteurs'];
                            $conduites = $_POST['conduites'];
                            $branchements = $_POST['branchements'];
                            $pieces = $_POST['pieces'];


                            // Effectuer les opérations d'ajout dans la base de données ici
                            $sql = "INSERT INTO `n_interventions`(`id`, `compteurs`, `conduites`, `branchements`, `pieces`, `date_I`) VALUES (null,'$compteurs','$conduites','$branchements','$pieces','$date_I_add')";

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
                            $compteurs = $_POST['compteurs'];
                            $conduites = $_POST['conduites'];
                            $branchements = $_POST['branchements'];
                            $pieces = $_POST['pieces'];
                            $date_I = $_POST['date_I'];



                            $sql = "UPDATE n_interventions SET `compteurs`='$compteurs', `conduites`='$conduites', `branchements`='$branchements', `pieces`='$pieces', `date_I`='$date_I' WHERE `id`='$id'";
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
                            $sql = "DELETE FROM n_interventions WHERE `id`='$id'";
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
                                    <th>Compteurs</th>
                                    <th>Conduites</th>
                                    <th>Branchements</th>
                                    <th>Piéces</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
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
                                    $req = mysqli_query($con, "SELECT * FROM n_interventions WHERE date_I BETWEEN '$startDate' AND '$endDate'");
                                    
                                } else {
                                    $req = mysqli_query($con, "SELECT * FROM n_interventions");
                                }

                                // Vérifier s'il y a des résultats
                                if (mysqli_num_rows($req) == 0) {
                                    // S'il n'y a pas de données, afficher un message
                                    echo '<tr><td colspan="13">Il n\'y a pas encore de données</td></tr>';
                                } else {
                                    $totalCompteurs = 0;
                                    $totalConduites = 0;
                                    $totalBranchements = 0;
                                    $totalPieces = 0;
                                    // Sinon, afficher les données existantes
                                    while ($row = mysqli_fetch_assoc($req)) {
                                        $totalCompteurs += $row['compteurs'];
                                        $totalConduites += $row['conduites'];
                                        $totalBranchements += $row['branchements'];
                                        $totalPieces += $row['pieces'];

                                        if (isset($_GET['id']) && $_GET['id'] == $row['id']) {
                                            // Si le paramètre N_lot est présent dans l'URL et correspond à la ligne en cours de traitement,
                                            // afficher le formulaire de modification
                                            echo '<form method="POST" action="">';
                                            echo '<tr>';
                                            echo '<td> <input type="number" name="id" value="' . $row['id'] . '"> </td>';
                                            echo '<td> <input type="date" name="date_I" value="' . $row['date_I'] . '"> </td>';
                                            echo '<td> <input type="text" name="compteurs" value="' . $row['compteurs'] . '"> </td>';
                                            echo '<td> <input type="text" name="conduites" value="' . $row['conduites'] . '"> </td>';
                                            echo '<td> <input type="text" name="branchements" value="' . $row['branchements'] . '"> </td>';
                                            echo '<td> <input type="text" name="pieces" value="' . $row['pieces'] . '"> </td>';
                                            echo '<td> <button type="submit" name="update">Modifier</button> </td>';
                                            echo '<td> <button type="submit" name="delete">Supprimer</button> </td>';


                                            echo '</form>';
                                        } else {
                                            // Afficher les données existantes avec un lien pour la modification
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['date_I'] . '</td>';
                                            echo '<td>' . $row['compteurs'] . '</td>';
                                            echo '<td>' . $row['conduites'] . '</td>';
                                            echo '<td>' . $row['branchements'] . '</td>';
                                            echo '<td>' . $row['pieces'] . '</td>';



                                            echo '<td><a type="submit" name="update" href="?id=' . $row['id'] . '">Modifier</a></td>';
                                            echo '<td><a type="submit" name="delete" href="?id=' . $row['id'] . '">Supprimer</a></td>';

                                            echo '</tr>';
                                        }
                                    }
                                    // Afficher la ligne pour ajouter une nouvelle ligne

                                    echo '<form method="POST" action="">';
                                    echo '<tr id="continte_table">';
                                    echo '<td></td>';
                                    echo '<td> <input type="date" name="date_I_add" placeholder="Date"> </td>';
                                    echo '<td> <input type="text" name="compteurs" placeholder="Compteurs"> </td>';
                                    echo '<td> <input type="text" name="conduites" placeholder="Conduites"> </td>';
                                    echo '<td> <input type="text" name="branchements" placeholder="Branchements"> </td>';
                                    echo '<td> <input type="text" name="pieces" placeholder="Piéces"> </td>';
                                    echo '<td> <button type="submit" name="add" style="width: 100%; ">Ajouter</button> </td>';
                                    echo '<td> <button type="reset" style="width: 100%; ">Effacer</button> </td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                    echo '</form>';
                                    //total
                                    echo '<tr>';
                                    echo '<td colspan="2"><i class="fa-solid fa-ticket"></i> Total</td>';
                                    echo '<td>' . $totalCompteurs . '</td>';
                                    echo '<td>' . $totalConduites . '</td>';
                                    echo '<td>' . $totalBranchements . '</td>';
                                    echo '<td>' . $totalPieces . '</td>';
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