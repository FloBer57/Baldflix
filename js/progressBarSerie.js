document.getElementById('uploadFormSerie').addEventListener('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);


    document.getElementById('progressBarContainerSerie').style.display = 'block';

    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        let percentComplete = (e.loaded / e.total) * 100;
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

    document.getElementById('uploadFormSerie').reset();
    document.getElementById('uploadProgressSerie').value = 0;
    document.getElementById('progressBarContainerSerie').style.display = 'none';
    this.disabled = true;
    document.getElementById('btnUploadSerie').disabled = false;
  });