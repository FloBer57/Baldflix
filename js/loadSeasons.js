function loadSeasons(serieId) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("saisonSelectContainer").innerHTML = '<select onchange="loadEpisodes(this.value, ' + serieId + ')">' + this.responseText + '</select>';
        }
    };
    xhttp.open("GET", "../php/getSeasons.php?serieId=" + serieId, true);
    xhttp.send();
}