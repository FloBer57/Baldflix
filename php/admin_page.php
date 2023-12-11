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
  $new_statut = $_POST["new_statut"];

  // Valider le nouveau statut
  if (!in_array($new_statut, ['utilisateur', 'admin'])) {
    die("Choix de statut invalide.");
  }

  // Mettre à jour le statut dans la base de données
  $update_sql = "UPDATE users SET statut = ? WHERE id = ?";
  $update_stmt = mysqli_prepare($link, $update_sql);
  mysqli_stmt_bind_param($update_stmt, "si", $new_statut, $user_id);
  mysqli_stmt_execute($update_stmt);
  mysqli_stmt_close($update_stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
  // Récupérer les données du formulaire
  $user_id = $_POST["user_id"];

  function generateRandomPassword($length = 12)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    $charactersLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
      $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
  }

  $new_password = generateRandomPassword();
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

  // Ajoutez une déclaration préparée pour la réinitialisation du mot de passe
  $reset_password_sql = "UPDATE users SET password = ? WHERE id = ?";
  $reset_password_stmt = mysqli_prepare($link, $reset_password_sql);
  mysqli_stmt_bind_param($reset_password_stmt, "ss", $hashed_password, $user_id);
  mysqli_stmt_execute($reset_password_stmt);
  mysqli_stmt_close($reset_password_stmt);

  // Récupérer l'adresse e-mail de l'utilisateur depuis la base de données
  $user_email_query = "SELECT email FROM users WHERE id = ?";
  $user_email_stmt = mysqli_prepare($link, $user_email_query);
  mysqli_stmt_bind_param($user_email_stmt, "i", $user_id);
  mysqli_stmt_execute($user_email_stmt);
  mysqli_stmt_bind_result($user_email_stmt, $user_email);

  // Vérifier s'il y a une ligne de résultat
  if (mysqli_stmt_fetch($user_email_stmt)) {
    // Utiliser l'adresse e-mail récupérée pour envoyer l'e-mail
    $to = $user_email;
    $subject = 'Reinitialisation du mot de passe';
    $message = 'Bonjour! Votre nouveau mot de passe est : ' . $new_password;
    $headers = 'From: baldflix.florentbernar@noreply.fr' . "\r\n" .
      'Reply-To: baldflix.florentbernar@noreply.fr' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

    // Utilisation de la fonction mail() pour envoyer l'e-mail
    mail($to, $subject, $message, $headers);

    // Fermer la déclaration préparée
    mysqli_stmt_close($user_email_stmt);
  } else {
    // Gérer le cas où l'adresse e-mail n'est pas trouvée
    echo "Erreur: Adresse e-mail non trouvée pour l'utilisateur.";
  }

  // Rediriger vers la même page après la réinitialisation
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
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

  // Répondre avec un statut JSON
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <title>Administration</title>
  <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
  <link href="../css/global.CSS" rel="stylesheet" />
</head>

<body class="background bodyburger">
  <?php require_once "../includes/header.php";
  ?>

  <main>
    <div class="account__container">
      <div class="sub__container admin__container">
        <nav class="account__nav">
          <ul class="admin__nav">
            <li class="test" data-tab="admin-user-tab-content" onclick="showTab('admin-user-tab-content')">
              Administration des utilisateurs</li>
            <li class="test" data-tab="video-tab-content" onclick="showTab('video-tab-content')">Administration des
              vidéos</li>
          </ul>
        </nav>
        <div id="admin-user-tab-content" class="tab__content admin__content">
          <h2>Administration des utilisateurs</h2>
          <?php
          // Requête SQL pour récupérer tous les utilisateurs
          $sql = "SELECT id, username, email, statut FROM users";
          $result = mysqli_query($link, $sql);

          if ($result) {
            echo "<table>";
            echo "<tr><th>Nom</th><th class='small-screen'>Email</th><th>Statut</th><th>Action</th><th>MDP</th><th>Supprimer</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td class='small-screen'>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['statut']) . "</td>";

              // Formulaire pour modifier le statut
              echo "<td>
                      <form method='post' action=''>
                        <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                        <input type='hidden' name='user_id' value='{$row['id']}'>
                        <select name='new_statut'>
                            <option value='utilisateur' " . ($row['statut'] == 'utilisateur' ? 'selected' : '') . ">Utilisateur</option>
                            <option value='admin' " . ($row['statut'] == 'admin' ? 'selected' : '') . ">Admin</option>
                        </select>
                        <input type='submit' name='modify' value='Modifier'>
                      </form>
                    </td>";

              // Formulaire pour réinitialiser le mot de passe
              echo "<td>
              <form method='post' action=''>
                <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                <input type='hidden' name='user_id' value='{$row['id']}'>
                <input type='submit' name='reset_password' value='Réinitialiser'>
              </form>
            </td>";

              // Lien pour supprimer l'utilisateur
              echo "<td>
              <a href='#' onclick='confirmDelete(\"?action=delete&id={$row['id']}&csrf_token={$_SESSION["csrf_token"]}\")'>
                <img src='../image/delete.svg' alt='Supprimer' title='Supprimer'>
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
      </div>
      <script src="../js/account.js"></script>
    </div>
  </main>
</body>

</html>