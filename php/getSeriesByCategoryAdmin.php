<?php

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}
if ($_SESSION["user_role_ID"] != 2) {
  header("location: profile.php");
  exit;
}
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

echo '<div class="container container_cat" id="adminContainer">';
echo '<div class="box box_admin">';

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

    echo "<pre>Categories: ";
    print_r($liste_categories);
    echo "</pre>";

    $categories_ids = array_slice($liste_categories, 0, 3);
  }

  $categorie_un_id = isset($categories_ids[0]) ? trim($categories_ids[0]) : "";
  $categorie_deux_id = isset($categories_ids[1]) ? trim($categories_ids[1]) : "";
  $categorie_trois_id = isset($categories_ids[2]) ? trim($categories_ids[2]) : "";

  echo '<div class="box_div" onclick="fillFormData(this)"
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
