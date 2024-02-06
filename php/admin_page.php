<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

require_once "config.php";

if ($_SESSION["user_role_ID"] != 2) {
  header("location: profile.php");
  exit;
}
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
  afficherContenu();
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["reset_password"]) &&  isset($_GET["csrf_token"])) {
    include_once "admin_reset_password.php";
  } elseif (isset($_POST["modify"]) && isset($_GET["csrf_token"]) ) {
    include_once "admin_role.php";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["user_ID"]) && isset($_GET["csrf_token"])) {
    include_once "admin_delete.php";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["action"]) && $_GET["action"] == "deleteVideo" && isset($_GET["ID"]) && isset($_GET["type"]) && isset($_GET["title"]) && isset($_GET["csrf_token"])) {
    include_once "delete_video.php";
  }
}
$_SESSION["csrf_token"] = bin2hex(random_bytes(32));

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <title>Administration</title>
  <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
  <link href="../css/global.CSS" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body class="background bodyburger">
  <?php require_once "../includes/header.php";
  ?>

  <main>
    <div class="account_container">
      <div class="sub_container admin__container">
        <nav class="account_nav">
          <ul class="admin_nav">
            <li data-tab="adminUserTabContent" onclick="showTab('adminUserTabContent')">
              Administration des utilisateurs</li>
            <li data-tab="adminVideoTabContent" onclick="showTab('adminVideoTabContent')">Administration des
              vidéos</li>
            <li data-tab="adminSerieTabContent" onclick="showTab('adminSerieTabContent')">Administration des
              séries</li>
            <li data-tab="adminVideoDeleteTabContent" onclick="showTab('adminVideoDeleteTabContent')">Gestions des vidéos</li>
          </ul>
        </nav>
        <div id="adminUserTabContent" class="tab_content admin_content admin_user_tab_content">
          <h2>Administration des utilisateurs</h2>

          <?php
          // Requête SQL pour récupérer tous les utilisateurs
          $sql = "SELECT user_ID, username, user_role_ID FROM user";
          $result = mysqli_query($link, $sql);

          if ($result) {
            echo "<table>";
            echo "<tr><th>Nom</th><th>Role</th><th>Action</th><th>MDP</th><th>Supprimer</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . htmlspecialchars($row['user_role_ID']) . "</td>";

              // Formulaire pour modifier le statut
              echo "<td>
              <form method='post' action=''>
                <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                <input type='hidden' name='user_ID' value='{$row['user_ID']}'>
                <select name='new_role'>
                    <option value='1' " . ($row['user_role_ID'] == '1' ? 'selected' : '') . ">User</option>
                    <option value='2' " . ($row['user_role_ID'] == '2' ? 'selected' : '') . ">Admin</option>
                    <option value='2' " . ($row['user_role_ID'] == '3' ? 'selected' : '') . ">Démo</option>
                </select>
                <input type='submit' name='modify' value='Modifier'>
              </form>
            </td>";

              // Formulaire pour réinitialiser le mot de passe
              echo "<td>
        <form method='post' action=''>
          <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
          <input type='hidden' name='user_ID' value='{$row['user_ID']}'>
          <input type='submit' name='reset_password' value='Réinitialiser'>
        </form>
      </td>";

              // Lien pour supprimer l'utilisateur
              echo "<td>
        <a href='#' onclick='confirmDelete(\"?action=delete&user_ID={$row['user_ID']}&csrf_token={$_SESSION["csrf_token"]}\")'>
          <img src='../image/icon/delete.svg' alt='Supprimer' title='Supprimer'>
        </a>
      </td>";

              echo "</tr>";
            }
            echo "</table>";
          } else {
            echo "Erreur de requête : " . mysqli_error($link);
          }
          ?>

        </div>
        <div id="adminVideoTabContent" class="tab_content admin_content active_tab admin_video_tab_content">
          <h2>Administration des films</h2>
          <form id="uploadForm" action="upload_film.php" method="post" enctype="multipart/form-data">
            <div class="admin_video_first" id="">
              <div class="title_tags">
                <label for="film_title">Titre du film:</label>
                <input type="text" id="filmTitle" class="film_title" name="film_title" required>
                <label for="film_tags">Tags (séparés par des virgules):</label>
                <input type="text" id="filmTags" class="film_tags" name="film_tags">
              </div>
              <div class="div_synopsis">
                <label for="film_synopsis">Synopsis du film :</label>
                <textarea id="filmSynopsis" name="film_synopsis" required></textarea>
              </div>
            </div>
            <div class="form_cat">
              <div class="form_row row1">
                <label for="media_type">Catégorie principale :</label>
                <select id="filmCategoriesCrincipal" name="film_categories[]">
                  <option>Veuillez choisir:</option>
                  <option value="2">Film</option>
                  <option value="4">Spectacle</option>
                  <option value="1">Anime</option>
                </select>
              </div>

              <div class="form_row row2">
                <label for="categorie_1">Catégorie 2 :</label>
                <select id="filmCategoriesAnnexe" name="film_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>

              <div class="form_row row3">
                <label for="categorie_2">Catégorie 3 :</label>
                <select id="filmCategoriesAnnexeDeux" name="film_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>
            </div>

            <label for="fileUploadVideo">Fichier vidéo du film :</label>
            <input type="file" id="fileInputVideo" name="video" required>
            <label for="fileUploadImage">Affiche du film</label>
            <input type="file" id="fileInputImage" name="image" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" class="btn_upload_film" id="btnUploadFilm" value="Ajouter la vidéo">
          </form>
          <div class="restart_btn">
            <button class="btn_restart" id="btnRestart" disabled>Recommencer</button>
          </div>
          <?php 
          if (isset($_SESSION['error_message_film'])) {
            echo "<p>" . $_SESSION['error_message_film'] . "</p>"; 
            unset($_SESSION['error_message_film']); 
        }
        ?>
          <div class="progress_bar_container" id="progressBarContainer" style="display:none;">
            <label for="uploadProgress">Progression du téléchargement :</label>
            <progress id="uploadProgress" value="0" max="100"></progress>
          </div>
        </div>

        <div id="adminSerieTabContent" class="tab_content admin_content active_tab admin_serie_tab_content">
          <h2>Administration des séries</h2>
          <form id="uploadFormSerie" action="upload_serie.php" method="post" enctype="multipart/form-data">
            <div class="admin_video_first">
              <div class="title_tags">
                <label for="serie_title">Titre de la série</label>
                <input type="text" class="serie_title" id="serieTitle" name="serie_title" required>
                <label for="serie_tags">Tags (séparés par des virgules):</label>
                <input type="text" class="serie_tags" id="serieTags" name="serie_tags">
              </div>
              <div class="div_synopsis">
                <label for="serie_synopsis">Synopsis de la série</label>
                <textarea id="serieSynopsis" name="serie_synopsis" required></textarea>
              </div>
            </div>
            <div class="form_cat">
              <div class="saison_number" <label for="numero_saison">N°:</label>
                <select id="numeroSaison" name="numero_saison" required>
                  <?php for ($i = 1; $i <= 20; $i++) {
                    echo "<option value='$i'>Saison $i</option>";
                  } ?>
                </select>
              </div>

              <button class="list_btn_modal" id="openSaisonModal">Liste séries</button>
              <input class="serie_ID_input_btn" type="number" id="serieID" name="serie_ID">

              <div class="form_row row1">
                <label for="media_type">Catégorie 1 :</label>
                <select id="serieCategorieUn" name="serie_categories[]">
                  <option>Veuillez choisir :</option>
                  <option value="3">Série</option>
                  <option value="4">Spectacle</option>
                  <option value="1">Anime</option>
                </select>
              </div>

              <div class="form_row row2">
                <label for="categorie_1">Catégorie 2 :</label>
                <select id="serieCategorieDeux" name="serie_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>

              <div class="form_row row3">
                <label for="categorie_2">Catégorie 3 :</label>
                <select id="serieCategorieTrois" name="serie_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>
            </div>
            <label for="fileUploadVideoSerie">Fichiers vidéo de la série :</label>
            <input type="file" id="fileInputVideoSerie" name="video[]" multiple required>
            <label for="fileUploadImageSerie">Affiche de la série :</label>
            <input type="file" id="fileInputImageSerie" name="image" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" class="btn_upload_serie" id="btnUploadSerie" value="Ajouter la vidéo">
          </form>
          <div class="restart_btn">
            <button class="btn_restart_serie" id="btnRestartSerie" disabled>Recommencer</button>
          </div>
          <?php 
          if (isset($_SESSION['error_message_serie'])) {
            echo "<p>" . $_SESSION['error_message_serie'] . "</p>"; 
            unset($_SESSION['error_message_serie']); 
        }
        ?>
          <div class="progress_bar_container_serie" id="progressBarContainerSerie" style="display:none;">
            <label for="uploadProgressSerie">Progression du téléchargement :</label>
            <progress id="uploadProgressSerie" value="0" max="100"></progress>
          </div>
        </div>


        <div id="adminVideoDeleteTabContent" class="tab_content admin_content active_tab admin_video_delete_tab_content">
          <h2>Suppression des vidéos</h2>

          <?php
          function afficherContenu()
          {
            global $link;
            $filmsSeriesParPage = 5;

            $pageActuelle = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            $offset = ($pageActuelle - 1) * $filmsSeriesParPage;
            $sql = "SELECT film.film_ID, film.film_image_path, film.film_title AS title, NULL AS serie_ID, NULL AS serie_title, NULL AS serie_image_path, 'film' AS type
        FROM film
        GROUP BY film.film_ID
        UNION ALL
        SELECT NULL AS film_ID, NULL AS film_image_path, NULL AS film_title, serie.serie_ID, serie.serie_title AS title, serie.serie_image_path, 'serie' AS serie_type
        FROM serie
        GROUP BY serie.serie_ID
        ORDER BY title ASC
        LIMIT $filmsSeriesParPage OFFSET $offset";

            $resultat = mysqli_query($link, $sql);

            if ($resultat) {
              echo "<table id=\"videoList\">";
              echo "<tr><th>Affiche</th><th>Titre</th><th>Type</th><th>ID</th><th>Supprimer</th></tr>";
              while ($ligne = mysqli_fetch_assoc($resultat)) {
                $id = $ligne['type'] === 'film' ? $ligne['film_ID'] : $ligne['serie_ID'];
                $title = htmlspecialchars_decode($ligne['type'] === 'film' ? $ligne['title'] : $ligne['serie_title']);
                $titre = htmlspecialchars_decode($ligne['type'] === 'film' ? $ligne['title'] : $ligne['serie_title']);
                $titre = str_replace("_", " ", $titre);
                $cheminImage = $ligne['type'] === 'film' ? $ligne['film_image_path'] : $ligne['serie_image_path'];
                $type = $ligne['type'];

                echo "<tr>";
                echo "<td><img src='{$cheminImage}' alt='Affiche' style='width:50px;'></td>";
                echo "<td>" . htmlspecialchars($titre) . "</td>";
                echo "<td>" . htmlspecialchars($type) . "</td>";
                echo "<td>" . htmlspecialchars($id) . "</td>";
                echo "<td>
                <a href='#' onclick='confirmDeleteVideo(\"?action=deleteVideo&ID={$id}&type={$type}&type={$title}&csrf_token={$_SESSION["csrf_token"]}\")'>
                    <img src='../image/icon/delete.svg' alt='Supprimer' title='Supprimer'>
                </a>
            </td>";
                echo "</tr>";
              }
              echo "</table>";
            } else {
              echo "Erreur de requête : " . mysqli_error($link);
            }
          }

          function afficherpagination()
          {
            global $link;

            $sqlCount = 'SELECT COUNT(*) AS total FROM (
      SELECT film.film_ID FROM film GROUP BY film.film_ID
      UNION ALL
      SELECT serie.serie_ID FROM serie GROUP BY serie.serie_ID
  ) AS totalFilmsSeries ';

            $resultCount = mysqli_query($link, $sqlCount);

            if ($resultCount && mysqli_num_rows($resultCount) > 0) {
              $row = mysqli_fetch_assoc($resultCount);
              $totalFilmsSeries = $row['total'];
            } else {
              $totalFilmsSeries = 0;
            }
            // Définir le nombre de films/series par page
            $filmsSeriesParPage = 5;

            // Récupérer le numéro de page actuel depuis l'URL
            $pageActuelle = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            $totalPages = ceil($totalFilmsSeries / $filmsSeriesParPage);
            echo "<div class='pagination' id='paginationContainer'>";
            for ($i = 1; $i <= $totalPages; $i++) {
              $classeActive = $i === $pageActuelle ? 'active' : '';
              echo "<a class='page-link $classeActive' href='#' data-page='$i'>$i</a>";
            }
            echo "</div>";
          }

          if (!isset($_GET['ajax'])) {
            afficherContenu();
            afficherpagination();
          } else {
            afficherContenu();
          }
          ?>
        </div>

      </div>

      <div id="saisonModal" class="saison_modal" style="display:none">
        <div class="saison_modal_content">
          <span class="close_saison_modal" id="closeSaisonModal" onclick="closeModal()">&times;</span>
          <h2>Veuillez choisir une Série</h2>
          <div id="saisonContainer">
            <?php

            function getSeriesByCategoryAdmin($link)
            {
              $sql = "SELECT
              serie.serie_ID,
              serie.serie_title,
              serie.serie_tags,
              serie.serie_image_path,
              serie.serie_synopsis,
              saison.saison_ID,
              GROUP_CONCAT(DISTINCT saison.saison_number ORDER BY saison.saison_number ASC SEPARATOR ',') AS saisons,
              GROUP_CONCAT(DISTINCT categorie.categorie_ID ORDER BY categorie.categorie_ID ASC SEPARATOR ',') AS categories
              FROM
              serie
              INNER JOIN
              serie_categorie ON serie.serie_ID = serie_categorie.serieXcategorie_serie_ID
              INNER JOIN
              categorie ON serie_categorie.serieXcategorie_categorie_ID = categorie.categorie_ID
              INNER JOIN
              saison ON saison.saison_serie_ID = serie.serie_ID
              GROUP BY serie.serie_ID
              ORDER BY serie.serie_title ASC";
              if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $Series = array();
                if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    array_push($Series, $row);
                  }
                }
                mysqli_stmt_close($stmt);
                return $Series;
              } else {
                echo "Erreur de préparation de la requête : " . mysqli_error($link);
                return array();
              }
            }

            $GetSeries = getSeriesByCategoryAdmin($link);

            echo '<div class="container container_cat" id="adminContainer">';
            echo '<div class="box box_admin">';

            foreach ($GetSeries as $item) {
              $id = htmlspecialchars($item['serie_ID']);
              $title = htmlspecialchars($item['serie_title']);
              $title = str_replace('_', ' ',$title);
              $image_path = htmlspecialchars($item['serie_image_path']);
              $synopsis = htmlspecialchars($item['serie_synopsis']);
              $tags = htmlspecialchars($item['serie_tags']);
              $categories = htmlspecialchars($item['categories']);
              $saisons = htmlspecialchars($item['saisons']);


              $saisonsPrises = explode(",", $saisons); 
              $dataSaisonsDisponibles = implode(',', range(1, 20));
              $dataSaisonsPrises = implode(',', $saisonsPrises);

              $categories_ids = [];

              if (!empty($categories)) {
                $liste_categories = explode(",", $categories);

                $categories_ids = array_slice($liste_categories, 0, 3);
              }

              $categorie_un_id = isset($categories_ids[0]) ? trim($categories_ids[0]) : "";
              $categorie_deux_id = isset($categories_ids[1]) ? trim($categories_ids[1]) : "";
              $categorie_trois_id = isset($categories_ids[2]) ? trim($categories_ids[2]) : "";

              echo '<div class="box_div" onclick="fillFormData(this)" '.
              'data-id="'.$id.'" '.
              'data-title="'.$title.'" '.
              'data-synopsis="'.$synopsis.'" '.
              'data-tags="'.$tags.'" '.
              'data-image="'.$image_path.'" '.
              'data-serie_categorie_un_id="'.$categorie_un_id.'" '.
              'data-serie_categorie_deux_id="'.$categorie_deux_id.'" '.
              'data-serie_categorie_trois_id="'.$categorie_trois_id.'" '.
              'data-saisons-disponibles="'.$dataSaisonsDisponibles.'" '.
              'data-saisons-prises="'.$dataSaisonsPrises.'">'.
              '<img src="'.$image_path.'" alt="'.$title.'">'.
              '</div>';
     }
            ?>
          </div>
        </div>
      </div>

  </main>
  <script src="../js/progressBarSerie.js"></script>
  <script src="../js/burger.js"></script>
  <script src="../js/onglet.js"></script>
  <script src="../js/confirmDelete.js"></script>
  <script src="../js/confirmDeleteVideo.js"></script>
  <script src="../js/progressBarFilm.js"></script>
  <script src="../js/modaleSaison.js"></script>
  <script src="../js/pagination.js"></script>
</body>

</html>