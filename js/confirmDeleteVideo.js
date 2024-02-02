function confirmDeleteVideo(link) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette serie/film?")) {
      window.location.href = link;
    }
  }