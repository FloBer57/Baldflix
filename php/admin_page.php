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
          </ul>
          <ul class="prev">
            <li data-tab="prev_video">
              <p>Preview Image</p><a href=""><img src="https://picsum.photos/240/320?random=2" alt=""></a>
            </li>
            <li data-tab="prev_image">
              <p>Preview Film</p><a href=""><img src="https://picsum.photos/320/240?random=2" alt=""></a>
            </li>
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
          <h2>Administration des vidéos</h2>
          <form id="uploadForm" action="upload_film.php" method="post" enctype="multipart/form-data">

            <label for="film_title">Titre du film:</label>
            <input type="text" id="film_title" name="film_title" required><br><br>

            <label for="film_synopsis">Synopsis:</label>
            <textarea id="film_synopsis" name="film_synopsis" required></textarea><br><br>

            <label for="film_tags">Tags (séparés par des virgules):</label>
            <input type="text" id="film_tags" name="film_tags"><br><br>

            <div class="form-row">
              <label for="media_type">Catégorie 1 :</label>
              <select id="film_categories" name="film_categories[]">
                <option>Veuillez choisir:</option>
                <option value="film">Film</option>
                <option value="serie">Série</option>
                <option value="spectacle">Spectacle</option>
                <option value="anime">Anime</option>
                <option value="bald">Bald</option>
              </select>
            </div>

            <div class="form-row">
              <label for="categorie_1">Catégorie 2 :</label>
              <select id="film_categories" name="film_categories[]">
                <option>Veuillez choisir:</option>
                <option value="5">Action</option>
                <option value="7">Comédies</option>
                <option value="8">Courts-Métrages</option>
                <option value="9">Documentaires</option>
                <option value="10">Drames</option>
                <option value="12">Fantastique</option>
                <option value="13">Français</option>
                <option value="14">Horreur</option>
                <option value="15">Indépendants</option>
                <option value="16">International</option>
                <option value="17">Jeunesse et famille</option>
                <option value="18">Musique et comédies musicales</option>
                <option value="19">Noël</option>
                <option value="20">Policier</option>
                <option value="21">Primés</option>
                <option value="22">Romance</option>
                <option value="23">SF</option>
                <option value="24">Thriller</option>
                <option value="25">Audiodescription</option>
              </select>
            </div>

            <div class="form-row">
              <label for="categorie_2">Catégorie 3 :</label>
              <select id="film_categories" name="film_categories[]">
                <option>Veuillez choisir:</option>
                <option value="5">Action</option>
                <option value="7">Comédies</option>
                <option value="8">Courts-Métrages</option>
                <option value="9">Documentaires</option>
                <option value="10">Drames</option>
                <option value="12">Fantastique</option>
                <option value="13">Français</option>
                <option value="14">Horreur</option>
                <option value="15">Indépendants</option>
                <option value="16">International</option>
                <option value="17">Jeunesse et famille</option>
                <option value="18">Musique et comédies musicales</option>
                <option value="19">Noël</option>
                <option value="20">Policier</option>
                <option value="21">Primés</option>
                <option value="22">Romance</option>
                <option value="23">SF</option>
                <option value="24">Thriller</option>
                <option value="25">Audiodescription</option>
              </select>
            </div>

            <label for="video">Fichier vidéo:</label>
            <input type="file" id="fileInput" name="video" required><br><br>

            <label for="image">Image de couverture:</label>
            <input type="file" id="fileInput" name="image" required><br><br>

            <input type="submit" id="btnUpload" value="Ajouter la vidéo">
          </form>
          <button id="btnRestart" disabled>Recommencer</button>
          <div id="progressBarContainer" style="display:none;">
            <label for="uploadProgress">Progression du téléchargement :</label>
            <progress id="uploadProgress" value="0" max="100"></progress>
          </div>

          <ul class="prev">
            <li data-tab="prev_img">
              <p>Preview Image</p>
              <img id="previewImage" src="" alt="Preview img">
            </li>
            <li data-tab="prev_miniature">
              <p>Preview Miniature</p>
              <img id="previewMiniature" src="" alt="Preview miniature">
            </li>
            <li data-tab="prev_video">
              <p>Preview Film</p>
              <img id="previewVideo" src="" alt="Preview film">
            </li>
          </ul>
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
        <script>
          document.getElementById('fileInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
              return;
            }

            const imgPreview = document.getElementById('previewImage');
            const videoPreview = document.getElementById('previewVideo');
            const videoSource = document.getElementById('videoSource');

            // Cache les prévisualisations au début
            imgPreview.hidden = true;
            videoPreview.hidden = true;

            if (file.type.startsWith('image/')) {
              imgPreview.hidden = false;
              videoPreview.hidden = true;
              imgPreview.src = URL.createObjectURL(file);
            } else if (file.type.startsWith('video/')) {
              imgPreview.hidden = true;
              videoPreview.hidden = false;
              videoSource.src = URL.createObjectURL(file);
              videoPreview.load();
            }
          });

        </script>
      </div>
    </div>
  </main>
</body>

</html>