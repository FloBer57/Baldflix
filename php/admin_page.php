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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["reset_password"])) {
    include_once "admin_reset_password.php";
  } elseif (isset($_POST["modify"])) {
    include_once "admin_role.php";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["user_ID"])) {
    include_once "admin_delete.php";
  }
}

$_SESSION["csrf_token"] = bin2hex(random_bytes(32));

/// TEST
if(isset($_SESSION['duree_brute'])) {
  echo "Durée brute: " . $_SESSION['duree_brute'] . " secondes<br>";
}

if(isset($_SESSION['duree_arrondie'])) {
  echo "Durée arrondie: " . $_SESSION['duree_arrondie'] . " secondes<br>";
}

if(isset($_SESSION['duree_formattee'])) {
  echo "Durée formatée: " . $_SESSION['duree_formattee'] . "<br>";
}

echo "bonjour";
// FIN TEST

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
    <div class="account__container">
      <div class="sub__container admin__container">
        <nav class="account__nav">
          <ul class="admin__nav">
            <li data-tab="admin-user-tab-content" onclick="showTab('admin-user-tab-content')">
              Administration des utilisateurs</li>
            <li data-tab="admin-video-tab-content" onclick="showTab('admin-video-tab-content')">Administration des
              vidéos</li>
            <li data-tab="admin-serie-tab-content" onclick="showTab('admin-serie-tab-content')">Administration des
              séries</li>
          </ul>
        </nav>
        <div id="admin-user-tab-content" class="tab__content admin__content">
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
        <div id="admin-video-tab-content" class="tab__content admin__content active-tab">
          <h2>Administration des films</h2>
          <form id="uploadForm" action="upload_film.php" method="post" enctype="multipart/form-data">
            <div class="admin_video_first">
              <div class="title_tags">
                <label for="film_title">Titre du film:</label>
                <input type="text" id="film_title" name="film_title" required>
                <label for="film_tags">Tags (séparés par des virgules):</label>
                <input type="text" id="film_tags" name="film_tags">
              </div>
              <div class="div_synopsis">
                <label for="film_synopsis">Synopsis du film :</label>
                <textarea id="film_synopsis" name="film_synopsis" required></textarea>
              </div>
            </div>
            <div class="form-cat">
              <div class="form-row row1">
                <label for="media_type">Catégorie principale :</label>
                <select id="film_categories_principal" name="film_categories[]">
                  <option>Veuillez choisir:</option>
                  <option value="2">Film</option>
                  <option value="4">Spectacle</option>
                  <option value="1">Anime</option>
                </select>
              </div>

              <div class="form-row row2">
                <label for="categorie_1">Catégorie 2 :</label>
                <select id="film_categories_annexe" name="film_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>

              <div class="form-row row3">
                <label for="categorie_2">Catégorie 3 :</label>
                <select id="film_categories_annexe_deux" name="film_categories[]">
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
            <input type="submit" id="btnUpload" value="Ajouter la vidéo">
          </form>
          <div class="restartbtn">
            <button id="btnRestart" disabled>Recommencer</button>
          </div>
          <div id="progressBarContainer" style="display:none;">
            <label for="uploadProgress">Progression du téléchargement :</label>
            <progress id="uploadProgress" value="0" max="100"></progress>
          </div>
        </div>

        <div id="admin-serie-tab-content" class="tab__content admin__content active-tab">
          <h2>Administration des séries</h2>
          <form id="uploadFormSerie" action="upload_serie.php" method="post" enctype="multipart/form-data">
            <div class="admin_video_first">
              <div class="title_tags">
                <label for="serie_title">Titre de la série</label>
                <input type="text" id="serie_title" name="serie_title" required>
                <label for="serie_tags">Tags (séparés par des virgules):</label>
                <input type="text" id="serie_tags" name="serie_tags">
              </div>
              <div class="div_synopsis">
                <label for="serie_synopsis">Synopsis de la série</label>
                <textarea id="serie_synopsis" name="serie_synopsis" required></textarea>
              </div>
            </div>
            <div class="form-cat">
              <div class="saison_number" <label for="numero_saison">N°:</label>
                <select id="numero_saison" name="numero_saison" required>
                  <?php for ($i = 1; $i <= 20; $i++) {
                    echo "<option value='$i'>Saison $i</option>";
                  } ?>
                </select>
              </div>

              <button type="button" id="openSaisonModal">+</button>
              <input type="number" id="serie_ID" name="serie_ID" >

              <div class="form-row row1">
                <label for="media_type">Catégorie 1 :</label>
                <select id="serie_categorie_un" name="serie_categories[]">
                  <option>Veuillez choisir :</option>
                  <option value="3">Série</option>
                  <option value="4">Spectacle</option>
                  <option value="1">Anime</option>
                </select>
              </div>

              <div class="form-row row2">
                <label for="categorie_1">Catégorie 2 :</label>
                <select id="serie_categorie_deux" name="serie_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie_select.php";

                  ?>
                </select>
              </div>

              <div class="form-row row3">
                <label for="categorie_2">Catégorie 3 :</label>
                <select id="serie_categorie_trois" name="serie_categories[]">
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
            <input type="submit" id="btnUploadSerie" value="Ajouter la vidéo">
          </form>
          <div class="restartbtn">
            <button id="btnRestartSerie" disabled>Recommencer</button>
          </div>
          <div id="progressBarContainerSerie" style="display:none;">
            <label for="uploadProgressSerie">Progression du téléchargement :</label>
            <progress id="uploadProgressSerie" value="0" max="100"></progress>
          </div>
        </div>
      </div>
    </div>

    <div id="saisonModal" class="saisonModal" style="display:none">
      <div class="saisonModalContent">
        <span class="closeSaisonModal" onclick="closeModal()">&times;</span>
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
            saison.saison_number,
            GROUP_CONCAT(DISTINCT categorie.categorie_ID ORDER BY categorie.categorie_ID ASC SEPARATOR ',') AS categories
            FROM
            serie
            INNER JOIN
            serie_categorie ON serie.serie_ID = serie_categorie.serieXcategorie_serie_ID
            INNER JOIN
            categorie ON serie_categorie.serieXcategorie_categorie_ID = categorie.categorie_ID
            INNER JOIN
            saison ON saison.saison_serie_ID = serie.serie_ID
            GROUP BY saison.saison_ID
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

          echo '<div class="container container_cat" id="admin_container">';
          echo '<div class="box box-admin">';

          foreach ($GetSeries as $item) {
            $id = htmlspecialchars($item['serie_ID']);
            $title = htmlspecialchars($item['serie_title']);
            $image_path = htmlspecialchars($item['serie_image_path']);
            $synopsis = htmlspecialchars($item['serie_synopsis']);
            $tags = htmlspecialchars($item['serie_tags']);
            $categories = htmlspecialchars($item['categories']);
        
            $categories_ids = [];
        
            if (!empty($categories)) {
                $liste_categories = explode(",", $categories); 
                
                echo "<pre>Categories: "; print_r($liste_categories); echo "</pre>";
                
                $categories_ids = array_slice($liste_categories, 0, 3);
            }
        
            $categorie_un_id = isset($categories_ids[0]) ? trim($categories_ids[0]) : ""; 
            $categorie_deux_id = isset($categories_ids[1]) ? trim($categories_ids[1]) : "";
            $categorie_trois_id = isset($categories_ids[2]) ? trim($categories_ids[2]) : "";
        
            echo '<div class="box-div" onclick="fillFormData(this)"
            data-id="' . $id . '"
            data-title="' . $title . '"
            data-synopsis="' . $synopsis . '"
            data-tags="' . $tags . '"
            data-image="' . $image_path . '"
            data-serie_categorie_un_id="' . $categorie_un_id . '"
            data-serie_categorie_deux_id="' . $categorie_deux_id . '"
            data-serie_categorie_trois_id="' . $categorie_trois_id . '">
            <img src="' . $image_path . '" alt="' . $title . '">
            </div>';
        }
          //// PROBLEME AVEC MON PHP ////

          ?>
        </div>
      </div>
    </div>

  </main>
  <script src="../js/progressBarSerie.js"></script>
  <script src="../js/burger.js"></script>
  <script src="../js/onglet.js"></script>
  <script src="../js/confirmDelete.js"></script>
  <script src="../js/progressBarFilm.js"></script>
  <script src="../js/saisonUpload.js"></script>
  <script src="../js/modaleSaison.js"></script>
</body>

</html>