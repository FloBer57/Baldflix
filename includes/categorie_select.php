    <?php
    $sql = "SELECT categorie_id, categorie_nom FROM categorie";
    $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $categorie_id = $row['categorie_id'];
        $categorie_nom = $row['categorie_nom'];
        if ($categorie_id != 1 || $categorie_id != 2 || $categorie_id != 3|| $categorie_id != 4 ) {
            echo '<option value="' . $categorie_id . '">' . $categorie_nom . '</option>';
        }
    }   
