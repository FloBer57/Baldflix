var btnOpenIconModal = document.getElementById("openIconModal");
var iconModal = document.getElementById("iconModal");
var btnCloseIconModal = document.getElementById("closeModal");
var iconContainer = document.getElementById("iconContainer");
var selectedIcon = null; // Déclaration ici

btnOpenIconModal.onclick = function () {
  iconModal.style.display = "block";
}

btnCloseIconModal.onclick = function () {
  iconModal.style.display = "none";
}

document.querySelectorAll('.modal_radio').forEach(function(radio) {
  radio.addEventListener('change', function() {
      // Retirer la classe de toutes les images
      document.querySelectorAll('.icon-preview').forEach(function(img) {
          img.classList.remove('icon-selected');
      });

      // Trouver l'image dans le label parent et ajouter la classe
      var labelParent = this.closest('.icon-label');
      if (labelParent) {
          var img = labelParent.querySelector('.icon-preview');
          if (img) {
              img.classList.add('icon-selected');
          }
      }
  });
});

const modal = document.getElementById('openIconModal'); // Votre modale
const body = document.body; // L'élément body

modal.addEventListener('click', () => {
    body.classList.add('body-no-scroll');
});

const closeModal = document.getElementById('closeModal');
closeModal.addEventListener('click', () => {
    body.classList.remove('body-no-scroll');
});




