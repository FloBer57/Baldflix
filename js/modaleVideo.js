function openModal(element) {
    var modal = document.getElementById('containerModaleVideo');
    var image = element.getAttribute('data-image');
    var title = element.getAttribute('data-title');
    var synopsis = element.getAttribute('data-synopsis');
    var duration = element.getAttribute('data-duration');
    var videoPath = element.getAttribute('data-video');
    var miniature = element.getAttribute('data-miniature');
    var id = element.getAttribute('data-id');
    var type = element.getAttribute('data-type');
    var videoPlayer = document.getElementById('myVideo');

    modal.querySelector('.affiche_modale img').src = image;
    modal.querySelector('.affiche_modale img').alt = title;
    modal.querySelector('.title_video h2').textContent = title;
    modal.querySelector('.player_modale p').textContent = synopsis;
    modal.querySelector('.player_modale video').poster = miniature;

    if (type === 'serie') {
        loadSeasons(id);
        loadFirstEpisode(id,1);
        modal.querySelector('.tags_duree_modale').innerHTML = '<p>' + duration + '</p>';
    } 
    if (type ==='film'){
        videoPlayer.src = videoPath;
        videoPlayer.load();
        modal.querySelector('.tags_duree_modale').innerHTML = '<p>' + 'Durée: ' + duration + '</p>';
    }

    modal.style.display = 'block'; 
}

function closeModal() {
    var modal = document.getElementById('containerModaleVideo');
    var videoPlayer = document.getElementById('myVideo');

    if (videoPlayer) {
        videoPlayer.pause();
        videoPlayer.src = "";
        videoPlayer.load();
    }

    modal.style.display = 'none'; 
    document.body.classList.remove('body_no_scroll'); 
}