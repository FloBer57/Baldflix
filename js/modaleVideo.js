function openModal(element) {
    var modal = document.getElementById('container_modale_video');
    
    // Extraction des données de l'élément cliqué
    var image = element.getAttribute('data-image');
    var title = element.getAttribute('data-title');
    var synopsis = element.getAttribute('data-synopsis');
    var tags = element.getAttribute('data-tags');
    var duration = element.getAttribute('data-duration');
    var videoPath = element.getAttribute('data-video');
    var miniature = element.getAttribute('data-miniature');
    var dateAjout = element.getAttribute('data-date-ajout');

    // Mise à jour du contenu de la modale
    modal.querySelector('.affiche_modale img').src = image;
    modal.querySelector('.affiche_modale img').alt = title;
    modal.querySelector('.title_video h2').textContent = title;
    modal.querySelector('.player_modale p').textContent = synopsis;
    modal.querySelector('.tags_duree_modale').innerHTML = '<p>' + tags + '</p><p>' + duration + '</p>';
    modal.querySelector('.player_modale video source').src = videoPath;
    modal.querySelector('.player_modale video').poster = miniature;
    modal.style.display = 'block'; // Affiche la modale
}

function closeModal() {
    var modal = document.getElementById('container_modale_video');
    modal.style.display = 'none'; // Cache la modale
    document.body.classList.remove('body-no-scroll'); // Réactive le scroll du body
}