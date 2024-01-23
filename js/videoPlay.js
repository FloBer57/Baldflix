document.getElementById('playButton').addEventListener('click', function() {
    var video = document.getElementById('myVideo');
    var container = this.parentElement;
    
    if (video.paused) {
        video.play();
        container.classList.add('video-playing');
    }
});

// Optionnel : arrêter la vidéo et remettre l'effet grisé en cas de pause
document.getElementById('myVideo').addEventListener('pause', function() {
    this.parentElement.classList.remove('video-playing');
    this.style.filter = 'grayscale(100%)';
});
