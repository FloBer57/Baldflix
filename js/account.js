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