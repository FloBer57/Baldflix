<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poids = $_POST["poids"];
    $chevaux = $_POST["chevaux"];
    $vitesse = $_POST["vitesse"];
    $type_boite = $_POST["type_boite"];

    if (!empty($poids) && !empty($chevaux) && !empty($vitesse) && !empty($type_boite)) {
        echo "Le véhicule a bien été ajouté en base de données<br>";
        echo "Le poids est de $poids<br>";
        echo "Le nombre de chevaux est de $chevaux<br>";
        echo "La vitesse est de $vitesse<br>";
        echo "Le type de boite est $type_boite<br>";
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>