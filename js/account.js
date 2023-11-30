function showTab(tabId) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab__content').forEach(function (tabContent) {
        tabContent.style.display = 'none';
    });

    // Afficher le contenu de l'onglet actuel
    document.getElementById(tabId).style.display = 'block';
}