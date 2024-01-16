<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

// Inclure le fichier de configuration
require_once "config.php";

// Vérifier si l'utilisateur connecté est un administrateur
if ($_SESSION["user_role_id"] != 2) {
  header("location: profile.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["reset_password"])) {
    include_once "admin_reset_password.php";
  } elseif (isset($_POST["modify"])) {
    include_once "admin_role.php";
  }
  // Vous pouvez ajouter d'autres conditions ici si nécessaire
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["user_id"])) {
    include_once "admin_delete.php";
  }
  // Ajoutez d'autres conditions GET ici si nécessaire
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
          $sql = "SELECT user_id, username, user_role_id FROM user";
          $result = mysqli_query($link, $sql);

          if ($result) {
            echo "<table>";
            echo "<tr><th>Nom</th><th>Role</th><th>Action</th><th>MDP</th><th>Supprimer</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . htmlspecialchars($row['user_role_id']) . "</td>";

              // Formulaire pour modifier le statut
              echo "<td>
              <form method='post' action=''>
                <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                <select name='new_role'>
                    <option value='1' " . ($row['user_role_id'] == '1' ? 'selected' : '') . ">User</option>
                    <option value='2' " . ($row['user_role_id'] == '2' ? 'selected' : '') . ">Admin</option>
                </select>
                <input type='submit' name='modify' value='Modifier'>
              </form>
            </td>";

              // Formulaire pour réinitialiser le mot de passe
              echo "<td>
        <form method='post' action=''>
          <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
          <input type='hidden' name='user_id' value='{$row['user_id']}'>
          <input type='submit' name='reset_password' value='Réinitialiser'>
        </form>
      </td>";

              // Lien pour supprimer l'utilisateur
              echo "<td>
        <a href='#' onclick='confirmDelete(\"?action=delete&user_id={$row['user_id']}&csrf_token={$_SESSION["csrf_token"]}\")'>
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
                <select id="film_categories" name="film_categories[]">
                  <option>Veuillez choisir:</option>
                  <option value="27">Film</option>
                  <option value="34">Spectacle</option>
                  <option value="6">Anime</option>
                </select>
              </div>

              <div class="form-row row2">
                <label for="categorie_1">Catégorie 2 :</label>
                <select id="film_categories" name="film_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie.php";

                  ?>
                </select>
              </div>

              <div class="form-row row3">
                <label for="categorie_2">Catégorie 3 :</label>
                <select id="film_categories" name="film_categories[]">
                  <option>Veuillez choisir :</option>
                  <?php

                  include "../includes/categorie.php";

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
              <div class="form-cat">
                <div class="saison_number" <label for="numero_saison">Numéro de saison:</label>
                  <select id="numero_saison" name="numero_saison" required>
                    <?php for ($i = 1; $i <= 20; $i++) {
                      echo "<option value='$i'>Saison $i</option>";
                    } ?>
                  </select>
                </div>

                <div class="form-row row1">
                  <label for="media_type">Catégorie 1 :</label>
                  <select id="serie_categories" name="serie_categories[]">
                    <option>Veuillez choisir:</option>
                    <option value="26">Série</option>
                    <option value="34">Spectacle</option>
                    <option value="6">Anime</option>
                  </select>
                </div>

                <div class="form-row row2">
                  <label for="categorie_1">Catégorie 2 :</label>
                  <select id="serie_categories" name="serie_categories[]">
                    <option>Veuillez choisir :</option>
                    <?php

                    include "../includes/categorie.php";

                    ?>
                  </select>
                </div>

                <div class="form-row row3">
                  <label for="categorie_2">Catégorie 3 :</label>
                  <select id="serie_categories" name="serie_categories[]">
                    <option>Veuillez choisir :</option>
                    <?php

                    include "../includes/categorie.php";

                    ?>
                  </select>
                </div>
              </div>
              <div class="fileUploadSerie">
                <label for="fileUploadVideoSerie">Fichiers vidéo de la série :</label>
                <input type="file" id="fileInputVideoSerie" name="video[]" multiple required>
                <label for="fileUploadImageSerie">Affiche de la série :</label>
                <input type="file" id="fileInputImageSerie" name="image" required>
                <input type="submit" id="btnUploadSerie" value="Ajouter les vidéos">
                <button id="btnRestart" disabled>Recommencer</button>
              </div>

          </form>
          <div id="progressBarContainer" style="display:none;">
            <label for="uploadProgress">Progression du téléchargement :</label>
            <progress id="uploadProgress" value="0" max="100"></progress>
          </div>
        </div>

        <script src="../js/account.js"></script>
        <script src="../js/burger.js"></script>
        <script>
          document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', this.action, true);

            // Afficher la barre de progression
            document.getElementById('progressBarContainer').style.display = 'block';

            xhr.upload.onprogress = function (e) {
              if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                document.getElementById('uploadProgress').value = percentComplete;
                if (percentComplete === 100) {
                  document.getElementById('btnRestart').disabled = false;
                  document.getElementById('btnUpload').disabled = true;
                }
              }
            };

            xhr.onload = function () {
              if (xhr.status === 200) {
                // Traiter la réponse ici...
              } else {
                alert("Une erreur s'est produite lors du téléchargement.");
              }
            };

            xhr.send(formData);
          });

          document.getElementById('btnRestart').addEventListener('click', function () {
            // Réinitialiser le formulaire
            document.getElementById('uploadForm').reset();
            document.getElementById('uploadProgress').value = 0;
            document.getElementById('progressBarContainer').style.display = 'none';
            this.disabled = true;
            document.getElementById('btnUpload').disabled = false;
          });
        </script>
      </div>

    </div>
  </main>
</body>

</html>