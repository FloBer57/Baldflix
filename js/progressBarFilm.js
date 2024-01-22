document.getElementById('uploadForm').addEventListener('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    // Afficher la barre de progression
    document.getElementById('progressBarContainer').style.display = 'block';

    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        var percentComplete = (e.loaded / e.total) * 100;
        document.getElementById('uploadProgress').value = percentComplete;
        if (percentComplete === 100) {
          document.getElementById('btnRestart').disabled = false;
          document.getElementById('btnUpload').disabled = true;
        }
      }
    };

    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          // Afficher un message de succès, réinitialiser le formulaire, etc.
          alert(response.message);
        } else {
          // Gérer l'erreur
          alert(response.message);
        }
      } else {
        alert("Une erreur s'est produite lors du téléchargement.");
      }
    };

    xhr.send(formData);
  });

  document.getElementById('btnRestart').addEventListener('click', function () {
    // Réinitialiser le formulaire
    document.getElementById('uploadForm').reset();
    document.getElementById('uploadProgress').value = 0;
    document.getElementById('progressBarContainer').style.display = 'none';
    this.disabled = true;
    document.getElementById('btnUpload').disabled = false;
  });