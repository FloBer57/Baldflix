document.addEventListener('DOMContentLoaded', function() {
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (paginationContainer) {
      paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        const target = e.target;
        
        if (target.tagName === 'A' && target.classList.contains('page-link')) {
          const page = target.getAttribute('data-page');
          fetch(`admin_page.php?page=${page}&ajax=1`)
            .then(response => response.text())
            .then(html => {

              document.getElementById('videoList').innerHTML = html;
            })
            .catch(error => console.error('Erreur de chargement:', error));
        }
      });
    }
  });