function showTab(tabId) {
  // Masquer tous les contenus
  document.querySelectorAll('.tab__content').forEach(function (tabContent) {
    tabContent.style.display = 'none';
    tabContent.classList.remove('active-tab'); // Supprimer la classe active-tab
  });

  // Afficher le contenu de l'onglet actuel si l'ID existe
  var currentTab = document.getElementById(tabId);
  if (currentTab) {
    currentTab.style.display = 'block';
    currentTab.classList.add('active-tab'); // Ajouter la classe active-tab
  } else {
    console.error('L\'élément avec l\'ID ' + tabId + ' n\'existe pas.');
  }
}

// Ajouter un écouteur d'événements "click" à chaque onglet
document.querySelectorAll('.tab__header').forEach(function(tabHeader) {
  tabHeader.addEventListener('click', function() {
    // Récupérer l'ID de l'onglet à afficher
    var tabId = this.getAttribute('data-tab-id');
    // Appeler la fonction showTab avec l'ID de l'onglet
    showTab(tabId);
  });
});

function confirmDelete(link) {
  if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?")) {
    window.location.href = link;
  }
}

document.getElementById('duckLink').addEventListener('click', function(event) {
  event.preventDefault(); // Empêche la navigation par défaut du lien

  var audio = new Audio('chemin/vers/mysound.mp3');
  audio.play();
});

var btnOpenIconModal = document.getElementById("openIconModal");
var iconModal = document.getElementById("iconModal");
var btnCloseIconModal = document.getElementById("closeModal");
var iconContainer = document.getElementById("iconContainer");
var selectedIcon = null; // Déclaration ici

btnOpenIconModal.onclick = function () {
  iconModal.style.display = "block";
}

btnCloseIconModal.onclick = function () {
  iconModal.style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  // Retirez cette ligne pour éviter la redéclaration
  // var selectedIcon = null;

  // Sélectionnez toutes les icônes et ajoutez un écouteur de clic
  var iconImages = document.querySelectorAll('.icon-preview');
  iconImages.forEach(function (icon) {
    icon.addEventListener('click', function () {
      // Déselectionnez l'icône précédemment sélectionnée (si elle existe)
      if (selectedIcon) {
        selectedIcon.classList.remove('selected-icon');
      }

      // Mettez à jour l'icône sélectionnée
      selectedIcon = icon;
      selectedIcon.classList.add('selected-icon');

      // Affichez la confirmation ou effectuez d'autres actions nécessaires
      console.log("Icône sélectionnée :", selectedIcon.getAttribute("data-icon"));
    });
  });
});

function updateProfileIcon() {
  if (selectedIcon) {
    var selectedIconPath = selectedIcon.getAttribute("data-icon");

    // Mettre à jour l'image de profil de l'utilisateur
    var userProfileImage = document.getElementById("userProfileImage");
    userProfileImage.src = "image/users_icon/" + selectedIconPath;

    // Fermer la modale
    iconModal.style.display = "none";
  } else {
    alert("Veuillez sélectionner une icône avant de confirmer.");
  }
}