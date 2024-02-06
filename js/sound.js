document.addEventListener("DOMContentLoaded", function () {
    let duckLink = document.getElementById("duckLink");
  
    duckLink.addEventListener("click", function (event) {
      event.preventDefault(); // Empêcher la navigation vers une autre page

      let audioContext = new (window.AudioContext || window.webkitAudioContext)();

      let audioSource = audioContext.createBufferSource();
      let request = new XMLHttpRequest();
      request.open("GET", "../audio/honk.mp3", true);
      request.responseType = "arraybuffer";
  
      request.onload = function () {
        audioContext.decodeAudioData(request.response, function (buffer) {
          audioSource.buffer = buffer;
          audioSource.connect(audioContext.destination);
          audioSource.start(0);
        });
      };
  
      request.send();
    });
  });
  