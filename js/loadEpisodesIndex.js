function loadEpisodes(saisonNumber, serieId, callback) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("episodesSelectContainer").innerHTML = this.responseText;
            if (typeof callback === "function") {
                callback();
            }
        }
    };
    xhttp.open("GET", "php/getEpisodes.php?saisonNumber=" + saisonNumber + "&serieId=" + serieId, true);
    xhttp.send();
}

function loadFirstEpisode(serieId, saisonNumber) {
    loadEpisodes(saisonNumber, serieId, function() {
        var episodeSelect = document.getElementById('episodeSelect');
        if (episodeSelect && episodeSelect.options.length > 1) {
            episodeSelect.selectedIndex = 1; // Sélectionnez le premier épisode
            updateEpisode(episodeSelect.value);
        }
    });
}

// Cette fonction sera appelée lorsque l'utilisateur sélectionne un épisode
function updateEpisode(episodePath) {
    var videoPlayer = document.getElementById('myVideo');
    videoPlayer.src = episodePath;
    videoPlayer.load(); // Important pour recharger la source vidéo
}
