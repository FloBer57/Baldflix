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

var btnOpenIconModal = document.getElementById("openIconModal");
var iconModal = document.getElementById("iconModal");
var btnCloseIconModal = document.getElementById("closeModal");
var iconContainer = document.getElementById("iconContainer");
var selectedIcon = null;

btnOpenIconModal.onclick = function () {
  iconModal.style.display = "block";
}

btnCloseIconModal.onclick = function () {
  iconModal.style.display = "none";
}

iconContainer.addEventListener("click", function (event) {
  var clickedIcon = event.target;

  if (clickedIcon.classList.contains("icon-preview")) {
    if (selectedIcon) {
      selectedIcon.classList.remove("selected");
    }

    selectedIcon = clickedIcon;
    selectedIcon.classList.add("selected");
  }
});

var btnConfirmIconSelection = document.getElementById("confirmIconSelection");

btnConfirmIconSelection.onclick = function () {
  if (selectedIcon) {
    var selectedIconPath = selectedIcon.getAttribute("data-icon");
    console.log("Icône sélectionnée :", selectedIconPath);
    iconModal.style.display = "none";
  } else {
    alert("Veuillez sélectionner une icône avant de confirmer.");
  }
}