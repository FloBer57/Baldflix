function confirmDelete(link) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?")) {
      window.location.href = link;
    }
  }