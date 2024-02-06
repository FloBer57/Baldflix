function showTab(tabId) {

    document.querySelectorAll('.tab_content').forEach(function (tabContent) {
      tabContent.style.display = 'none';
      tabContent.classList.remove('active_tab');
    });
  

    document.querySelectorAll('.account_nav li').forEach(function (tab) {
      tab.classList.remove('active_onglet');
    });
  

    let currentTab = document.getElementById(tabId);
  
    if (currentTab) {
      currentTab.style.display = 'block';
      currentTab.classList.add('active_tab'); 
  

      let tabLink = document.querySelector('[data-tab="' + tabId + '"]');
      if (tabLink) {
        tabLink.classList.add('active_onglet');
      }
  

      let prevElements = document.querySelector('.prev');
      if (tabId === 'admin_video_tab_content' && prevElements) {
        prevElements.style.display = 'block';
      } else if (prevElements) {
        prevElements.style.display = 'none';
      }
    } else {
      console.error("L'élément avec l'ID " + tabId + " n'existe pas.");
    }
  }

  document.querySelectorAll('.tab_header').forEach(function(tabHeader) {
    tabHeader.addEventListener('click', function() {

      let tabId = this.getAttribute('data-tab-id');

      showTab(tabId);
    });
  });