<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

// Include config file
require_once "config.php";

// Check if the logged-in user is an admin
if ($_SESSION["statut"] != "admin") {
  header("location: profile.php");
  exit;
}

// Fonction pour modifier le mot de passe et le statut
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify"])) {
  // Protection CSRF
  if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Token CSRF invalide.");
  }

  // Récupérer les données du formulaire
  $user_id = $_POST["user_id"];
  $new_password = $_POST["new_password"];
  $new_statut = $_POST["new_statut"];

  // Valider le nouveau statut
  if (!in_array($new_statut, ['utilisateur', 'admin'])) {
    die("Choix de statut invalide.");
  }

  // Mettre à jour le mot de passe et le statut dans la base de données
  $update_sql = "UPDATE users SET password = ?, statut = ? WHERE id = ?";
  $update_stmt = mysqli_prepare($link, $update_sql);
  mysqli_stmt_bind_param($update_stmt, "ssi", password_hash($new_password, PASSWORD_DEFAULT), $new_statut, $user_id);
  mysqli_stmt_execute($update_stmt);
  mysqli_stmt_close($update_stmt);
}

// Fonction pour supprimer un utilisateur
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
  // Protection CSRF
  if (!isset($_GET["csrf_token"]) || $_GET["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Token CSRF invalide.");
  }

  $user_id_to_delete = $_GET["id"];

  // Supprimer l'utilisateur de la base de données
  $delete_sql = "DELETE FROM users WHERE id = ?";
  $delete_stmt = mysqli_prepare($link, $delete_sql);
  mysqli_stmt_bind_param($delete_stmt, "i", $user_id_to_delete);
  mysqli_stmt_execute($delete_stmt);
  mysqli_stmt_close($delete_stmt);

  // Rediriger vers la même page après la suppression
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

// Génération du token CSRF
$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon compte</title>
  <link href="/css/global.CSS" rel="stylesheet" />
</head>

<body class="background">
  <?php require_once "includes/header.php"; ?>

  <main>
    <div class="account__container">
      <div class="sub__container">
        <nav class="account__nav">
          <ul>
            <li class="test" data-tab="admin-user-tab-content" onclick="showTab('admin-user-tab-content')">
              Administration des utilisateurs</li>
            <li class="test" data-tab="video-tab-content" onclick="showTab('video-tab-content')">Administration des
              vidéos</li>
          </ul>
        </nav>
        <div id="admin-user-tab-content" class="tab__content">
          <h2>Administration des utilisateurs</h2>
          <?php
          // Requête SQL pour récupérer tous les utilisateurs
          $sql = "SELECT id, username, statut FROM users";
          $result = mysqli_query($link, $sql);

          if ($result) {
            echo "<table>";
            echo "<tr><th>Nom d'utilisateur</th><th>Statut</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . htmlspecialchars($row['statut']) . "</td>";
              echo "<td>
            <form method='post' action=''>
                <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                <input type='hidden' name='user_id' value='{$row['id']}'>
                <label for='new_statut'>Nouveau statut :</label>
                <select name='new_statut'>
                    <option value='utilisateur' " . ($row['statut'] == 'utilisateur' ? 'selected' : '') . ">Utilisateur</option>
                    <option value='admin' " . ($row['statut'] == 'admin' ? 'selected' : '') . ">Admin</option>
                </select>
                <input type='submit' name='modify' value='Modifier'>
            </form>
            |
            <a href='?action=delete&id={$row['id']}&csrf_token={$_SESSION["csrf_token"]}'>Supprimer</a>
        </td>";
              echo "</tr>";
            }
            echo "</table>";
          } else {
            echo "Erreur de requête : " . mysqli_error($link);
          }
          ?>
        </div>
      </div>
      <script src="js/account.js"></script>
    </div>
  </main>
</body>

</html>