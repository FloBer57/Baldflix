function showTab(tabId) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab__content').forEach(function (tabContent) {
      tabContent.style.display = 'none';
      tabContent.classList.remove('active-tab');
    });
  
    // Désélectionner tous les onglets actifs
    document.querySelectorAll('.account__nav li').forEach(function (tab) {
      tab.classList.remove('active-onglet');
    });
  
    // Afficher le contenu de l'onglet actuel si l'ID existe
    var currentTab = document.getElementById(tabId);
  
    if (currentTab) {
      currentTab.style.display = 'block';
      currentTab.classList.add('active-tab'); // Ajouter la classe active-tab
  
      // Ajouter la classe active-onglet à l'onglet cliqué
      var tabLink = document.querySelector('[data-tab="' + tabId + '"]');
      if (tabLink) {
        tabLink.classList.add('active-onglet');
      }
  
      // Afficher ou masquer les éléments "prev" en fonction de l'onglet sélectionné
      var prevElements = document.querySelector('.prev');
      if (tabId === 'admin-video-tab-content' && prevElements) {
        prevElements.style.display = 'block';
      } else if (prevElements) {
        prevElements.style.display = 'none';
      }
    } else {
      console.error("L'élément avec l'ID " + tabId + " n'existe pas.");
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