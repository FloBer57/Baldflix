      // Obtenir l'élément de la Pop-Up de Bienvenue
      var welcomePopup = document.getElementById("welcomePopup");

      // Obtenir l'élément <span> qui ferme la Pop-Up
      var closeBtn = document.getElementsByClassName("welcome_close")[0];

      // À l'ouverture de la page, afficher la Pop-Up
      window.onload = function() {
        welcomePopup.style.display = "block";
      }

      // Lorsque l'utilisateur clique sur <span> (x), fermer la Pop-Up
      closeBtn.onclick = function() {
        welcomePopup.style.display = "none";
      }

      // Lorsque l'utilisateur clique n'importe où en dehors de la Pop-Up, la fermer
      window.onclick = function(event) {
        if (event.target == welcomePopup) {
          welcomePopup.style.display = "none";
        }
      }