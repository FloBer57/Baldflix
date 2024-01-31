document.getElementById('uploadFormSerie').addEventListener('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    // Afficher la barre de progression
    document.getElementById('progressBarContainerSerie').style.display = 'block';

    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        var percentComplete = (e.loaded / e.total) * 100;
        document.getElementById('uploadProgressSerie').value = percentComplete;
        if (percentComplete === 100) {
          document.getElementById('btnRestartSerie').disabled = false;
          document.getElementById('btnUploadSerie').disabled = true;
        }
      }
    };

    xhr.send(formData);
  });

document.getElementById('btnRestartSerie').addEventListener('click', function () {
    // Réinitialiser le formulaire
    document.getElementById('uploadFormSerie').reset();
    document.getElementById('uploadProgressSerie').value = 0;
    document.getElementById('progressBarContainerSerie').style.display = 'none';
    this.disabled = true;
    document.getElementById('btnUploadSerie').disabled = false;
  });