document.getElementById('uploadForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);


    document.getElementById('progressBarContainer').style.display = 'block';

    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        let percentComplete = (e.loaded / e.total) * 100;
        document.getElementById('uploadProgress').value = percentComplete;
        if (percentComplete === 100) {
          document.getElementById('btnRestart').disabled = false;
          document.getElementById('btnUpload').disabled = true;
        }
      }
    };
    xhr.send(formData);
  });

  document.getElementById('btnRestart').addEventListener('click', function () {

    document.getElementById('uploadForm').reset();
    document.getElementById('uploadProgress').value = 0;
    document.getElementById('progressBarContainer').style.display = 'none';
    this.disabled = true;
    document.getElementById('btnUpload').disabled = false;
  });