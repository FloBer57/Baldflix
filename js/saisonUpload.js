document.addEventListener('DOMContentLoaded', function() {
    // Récupérez la référence du menu déroulant "numero_saison"
    var numeroSaisonDropdown = document.getElementById('numeroSaison');

    // Récupérez la référence de l'input de l'image
    var imageUploadInput = document.getElementById('fileInputImageSerie');
    var titleInput = document.getElementById('serieTitle');
    var tagsInput = document.getElementById('serieTags');
    var synopsisInput = document.getElementById('serieSynopsis');
    var serieIdInput = document.getElementById('serieID');
    var categoriesInputUn = document.getElementById('serieCategorieUn');
    var categoriesInputDeux = document.getElementById('serieCategorieDeux');
    var categoriesInputTrois = document.getElementById('serieCategorieTrois');

    // Écoutez les changements de sélection dans le menu déroulant
    numeroSaisonDropdown.addEventListener('change', function() {
        // Récupérez la valeur sélectionnée dans le menu déroulant
        var selectedValue = numeroSaisonDropdown.value;

        // Désactivez l'input de l'image si la saison n'est pas "Saison 1"
        if (selectedValue !== '1') {
            imageUploadInput.disabled = true;
            titleInput.disabled = true;
            tagsInput.disabled = true;
            synopsisInput.disabled = true;
            serieIdInput.disabled = true;
            categoriesInputDeux.disabled = true;
            categoriesInputTrois.disabled = true;
            categoriesInputUn.disabled = true;
        } else {
            imageUploadInput.disabled = false;
            titleInput.disabled = false;
            tagsInput.disabled = false;
            synopsisInput.disabled = false;
            serieIdInput.disabled = false;
            categoriesInputDeux.disabled = false;
            categoriesInputTrois.disabled = false;
            categoriesInputUn.disabled = false;
        }
    });

    // Vérifiez l'état initial lors du chargement de la page
    if (numeroSaisonDropdown.value !== '1') {
        imageUploadInput.disabled = true;
    }
});