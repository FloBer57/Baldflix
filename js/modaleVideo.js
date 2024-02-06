function openModal(element) {
    let modal = document.getElementById('containerModaleVideo');
    let image = element.getAttribute('data-image');
    let title = element.getAttribute('data-title');
    let synopsis = element.getAttribute('data-synopsis');
    let duration = element.getAttribute('data-duration');
    let videoPath = element.getAttribute('data-video');
    let miniature = element.getAttribute('data-miniature');
    let id = element.getAttribute('data-id');
    let type = element.getAttribute('data-type');
    let videoPlayer = document.getElementById('myVideo');

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
    let modal = document.getElementById('containerModaleVideo');
    let videoPlayer = document.getElementById('myVideo');

    if (videoPlayer) {
        videoPlayer.pause();
        videoPlayer.src = "";
        videoPlayer.load();
    }

    modal.style.display = 'none'; 
    document.body.classList.remove('body_no_scroll'); 
}