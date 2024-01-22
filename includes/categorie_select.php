    <?php
    $sql = "SELECT categorie_id, categorie_nom FROM categorie";
    $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $categorie_id = $row['categorie_id'];
        $categorie_nom = $row['categorie_nom'];
    
        if ($categorie_nom != "Anime" && $categorie_nom != "Film" && $categorie_nom != "Spectacle" && $categorie_nom != "Serie") {
            echo '<option value="' . $categorie_id . '">' . $categorie_nom . '</option>';
        }
    }
