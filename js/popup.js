
      let welcomePopup = document.getElementById("welcomePopup");


      let closeBtn = document.getElementsByClassName("welcome_close")[0];


      window.onload = function() {
        welcomePopup.style.display = "block";
      }


      closeBtn.onclick = function() {
        welcomePopup.style.display = "none";
      }

      window.onclick = function(event) {
        if (event.target == welcomePopup) {
          welcomePopup.style.display = "none";
        }
      }