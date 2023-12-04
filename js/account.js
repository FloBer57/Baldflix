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