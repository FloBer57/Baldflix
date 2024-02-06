function loadEpisodes(saisonNumber, serieId, callback) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("episodesSelectContainer").innerHTML = this.responseText;
            if (typeof callback === "function") {
                callback();
            }
        }
    };
    xhttp.open("GET", "../php/getEpisodes.php?saisonNumber=" + saisonNumber + "&serieId=" + serieId, true);
    xhttp.send();
}

function loadFirstEpisode(serieId, saisonNumber) {
    loadEpisodes(saisonNumber, serieId, function() {
        let episodeSelect = document.getElementById('episodeSelect');
        if (episodeSelect && episodeSelect.options.length > 1) {
            episodeSelect.selectedIndex = 0; 
            updateEpisode(episodeSelect.value);
        }
    });
}


function updateEpisode(episodePath) {
    let videoPlayer = document.getElementById('myVideo');
    videoPlayer.src = episodePath;
    videoPlayer.load(); 
}
