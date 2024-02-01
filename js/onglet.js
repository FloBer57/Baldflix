function showTab(tabId) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab_content').forEach(function (tabContent) {
      tabContent.style.display = 'none';
      tabContent.classList.remove('active_tab');
    });
  
    // Désélectionner tous les onglets actifs
    document.querySelectorAll('.account_nav li').forEach(function (tab) {
      tab.classList.remove('active_onglet');
    });
  
    // Afficher le contenu de l'onglet actuel si l'ID existe
    var currentTab = document.getElementById(tabId);
  
    if (currentTab) {
      currentTab.style.display = 'block';
      currentTab.classList.add('active_tab'); // Ajouter la classe active-tab
  
      // Ajouter la classe active_onglet à l'onglet cliqué
      var tabLink = document.querySelector('[data-tab="' + tabId + '"]');
      if (tabLink) {
        tabLink.classList.add('active_onglet');
      }
  
      // Afficher ou masquer les éléments "prev" en fonction de l'onglet sélectionné
      var prevElements = document.querySelector('.prev');
      if (tabId === 'admin_video_tab_content' && prevElements) {
        prevElements.style.display = 'block';
      } else if (prevElements) {
        prevElements.style.display = 'none';
      }
    } else {
      console.error("L'élément avec l'ID " + tabId + " n'existe pas.");
    }
  }
  
  // Ajouter un écouteur d'événements "click" à chaque onglet
  document.querySelectorAll('.tab_header').forEach(function(tabHeader) {
    tabHeader.addEventListener('click', function() {
      // Récupérer l'ID de l'onglet à afficher
      var tabId = this.getAttribute('data-tab-id');
      // Appeler la fonction showTab avec l'ID de l'onglet
      showTab(tabId);
    });
  });