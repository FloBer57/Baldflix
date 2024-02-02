<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}
if ($_SESSION["user_role_ID"] != 2) {
  header("location: profile.php");
  exit;
}

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
