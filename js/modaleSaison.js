const btnOpenSaisonModal = document.getElementById("openSaisonModal");
const saisonModal = document.getElementById("saisonModal");
const btnCloseSaisonModal = document.getElementById("closeSaisonModal");
const saisonContainer = document.getElementById("saisonContainer");

const body = document.body; // L'élément body

btnOpenSaisonModal.onclick = function () {
    saisonModal.style.display = "block";
    document.body.classList.add('body_no_scroll'); // Ajout de no-scroll ici
}

btnCloseSaisonModal.onclick = function () {
    saisonModal.style.display = "none";
    document.body.classList.remove('body_no_scroll'); // Retrait de no-scroll ici
}

function closeModal() {
    const modal = document.getElementById('saisonModal');
    modal.style.display = 'none'; // Cache la modale
    document.body.classList.remove('body_no_scroll'); // Réactive le scroll du body
}

function fillFormData(element) {

  const numeroSaisonDropdown = document.getElementById('numeroSaison');
  const imageUploadInput = document.getElementById('fileInputImageSerie');


  const id = element.getAttribute('data-id');
  const title = element.getAttribute('data-title');
  const synopsis = element.getAttribute('data-synopsis');
  const tags = element.getAttribute('data-tags');
  const categorieUnId = element.getAttribute('data-serie_categorie_un_id');
  const categorieDeuxId = element.getAttribute('data-serie_categorie_deux_id');
  const categorieTroisId = element.getAttribute('data-serie_categorie_trois_id');
  const saisonsDisponibles = element.getAttribute('data-saisons-disponibles').split(',');
  const saisonsPrises = element.getAttribute('data-saisons-prises').split(',');
  const selectSaison = document.getElementById('numeroSaison');
  selectSaison.innerHTML = ''; // Nettoyer les options existantes

  saisonsDisponibles.forEach(function(saison) {
      const option = document.createElement('option');
      option.value = saison;
      option.text = `Saison ${saison}`;
      if (saisonsPrises.includes(saison)) {
          option.disabled = true; // Désactiver les saisons prises
      }
      selectSaison.appendChild(option);
      if (saison !== '1') {
        imageUploadInput.disabled = true;
    } else {
        imageUploadInput.disabled = false;
    }
    if (numeroSaisonDropdown.value !== '1') {
        imageUploadInput.disabled = true;
    }
  });

  document.getElementById('serieID').value = id;
  document.getElementById('serieTitle').value = title;
  document.getElementById('serieSynopsis').value = synopsis;
  document.getElementById('serieTags').value = tags;
  document.getElementById('serieCategorieUn').value = categorieUnId;
  document.getElementById('serieCategorieDeux').value = categorieDeuxId;
  document.getElementById('serieCategorieTrois').value = categorieTroisId;


  // Afficher la modale
  saisonModal.style.display = "block";
  body.classList.add('body_no_scroll');
}

