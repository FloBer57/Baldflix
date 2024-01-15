<!DOCTYPE html>
<html>
<head>
    <title>Enregistrement d'un véhicule</title>
</head>
<body>
    <h2>Formulaire d'enregistrement de véhicule</h2>
    <form action="enregistrer_vehicule.php" method="post">
        <label for="poids">Poids :</label>
        <input type="number" id="poids" name="poids" required><br><br>

        <label for="chevaux">Chevaux :</label>
        <input type="number" id="chevaux" name="chevaux" required><br><br>

        <label for="vitesse">Vitesse de pointe :</label>
        <input type="number" id="vitesse" name="vitesse" required><br><br>

        <label for="type_boite">Type de boite :</label>
        <input type="text" id="type_boite" name="type_boite" required><br><br>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>