let btnOpenIconModal = document.getElementById("openIconModal");
let iconModal = document.getElementById("iconModal");
let btnCloseIconModal = document.getElementById("closeModal");
let iconContainer = document.getElementById("iconContainer");
let selectedIcon = null; 

btnOpenIconModal.onclick = function () {
  iconModal.style.display = "block";
}

btnCloseIconModal.onclick = function () {
  iconModal.style.display = "none";
}

document.querySelectorAll('.modal_radio').forEach(function(radio) {
  radio.addEventListener('change', function() {
      
      document.querySelectorAll('.icon_preview').forEach(function(img) {
          img.classList.remove('icon_selected');
      });

     
      let labelParent = this.closest('.icon_label');
      if (labelParent) {
          let img = labelParent.querySelector('.icon_preview');
          if (img) {
              img.classList.add('icon_selected');
          }
      }
  });
});

const modal = document.getElementById('openIconModal'); 
const body = document.body; 

modal.addEventListener('click', () => {
    body.classList.add('body_no_scroll');
});

const closeModal = document.getElementById('closeModal');
closeModal.addEventListener('click', () => {
    body.classList.remove('body_no_scroll');
});




