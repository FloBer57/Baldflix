<?php
          function afficherContenu() {
            global $link;
          // Définir le nombre de films/series par page
          $filmsSeriesParPage = 5;

          // Récupérer le numéro de page actuel depuis l'URL
          $pageActuelle = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

          // Calculer la valeur OFFSET pour la requête SQL
          $offset = ($pageActuelle - 1) * $filmsSeriesParPage;

          // Requête SQL pour récupérer les films et séries en fonction de la pagination
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
                <a href='#' onclick='confirmDeleteVideo(\"?action=deleteVideo&ID={$id}&type={$type}&csrf_token={$_SESSION["csrf_token"]}\")'>
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

        function afficherpagination() {
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
        echo "<div class='pagination' id='pagination-container'>";
        for ($i = 1; $i <= $totalPages; $i++) {
          $classeActive = $i === $pageActuelle ? 'active' : '';
          echo "<a class='page-link $classeActive' href='#' data-page='$i'>$i</a>";
        }
        echo "</div>";
      }