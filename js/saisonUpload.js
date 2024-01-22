document.addEventListener('DOMContentLoaded', function() {
    // Récupérez la référence du menu déroulant "numero_saison"
    var numeroSaisonDropdown = document.getElementById('numero_saison');

    // Récupérez la référence de l'input de l'image
    var imageUploadInput = document.getElementById('fileInputImageSerie');

    // Écoutez les changements de sélection dans le menu déroulant
    numeroSaisonDropdown.addEventListener('change', function() {
        // Récupérez la valeur sélectionnée dans le menu déroulant
        var selectedValue = numeroSaisonDropdown.value;

        // Désactivez l'input de l'image si la saison n'est pas "Saison 1"
        if (selectedValue !== '1') {
            imageUploadInput.disabled = true;
        } else {
            imageUploadInput.disabled = false;
        }
    });

    // Vérifiez l'état initial lors du chargement de la page
    if (numeroSaisonDropdown.value !== '1') {
        imageUploadInput.disabled = true;
    }
});