var btnOpenSaisonModal = document.getElementById("openSaisonModal");
var saisonModal = document.getElementById("saisonModal");
var btnCloseSaisonModal = document.getElementById("closeSaisonModal");
var saisonContainer = document.getElementById("saisonContainer");

const body = document.body; // L'élément body

btnOpenSaisonModal.onclick = function () {
    saisonModal.style.display = "block";
    document.body.classList.add('body-no-scroll'); // Ajout de no-scroll ici
}

btnCloseSaisonModal.onclick = function () {
    saisonModal.style.display = "none";
    document.body.classList.remove('body-no-scroll'); // Retrait de no-scroll ici
}

function closeModal() {
    var modal = document.getElementById('saisonModal');
    modal.style.display = 'none'; // Cache la modale
    document.body.classList.remove('body-no-scroll'); // Réactive le scroll du body
}

function fillFormData(element) {
  // Récupérer les données
  const id = element.getAttribute('data-id');
  const title = element.getAttribute('data-title');
  const synopsis = element.getAttribute('data-synopsis');
  const tags = element.getAttribute('data-tags');
  const categorieUnId = element.getAttribute('data-serie_categorie_un_id');
  const categorieDeuxId = element.getAttribute('data-serie_categorie_deux_id');
  const categorieTroisId = element.getAttribute('data-serie_categorie_trois_id');

  // Remplir le formulaire
  document.getElementById('serie_ID').value = id;
  document.getElementById('serie_title').value = title;
  document.getElementById('serie_synopsis').value = synopsis;
  document.getElementById('serie_tags').value = tags;
  document.getElementById('serie_categorie_un').value = categorieUnId;
  document.getElementById('serie_categorie_deux').value = categorieDeuxId;
  document.getElementById('serie_categorie_trois').value = categorieTroisId;


  // Afficher la modale
  saisonModal.style.display = "block";
  body.classList.add('body-no-scroll');
}