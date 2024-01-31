<header class="header">

  <div class="title">
    <h1><a href="../index.php">BaldFlix</a></h1>
  </div>

  <nav class="main-nav" role="navigation">
    <div class="menu">
      <ul class="menu-list">
        <li><a href="../php/categorie.php">Séries</a></li>
        <li><a href="../php/categorie.php?categorie=Film">Films</a></li>
        <li><a href="../php/categorie.php?categorie=Anime">Anime</a></li>
        <li><a href="../php/categorie.php?categorie=Spectacles">Spectacles</a></li>
        <li><a href="../php/categorie.php?categorie=Bald">Bald</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <nav class="navbar" role="navigation">
      <div class="hamburger-menu">
        <div class="line line-1"></div>
        <div class="line line-2"></div>
        <div class="line line-3"></div>
      </div>
      <ul class="nav-list">
        <li class="nav-item nav-hero">
          <a href="#" class="hero" id="herro">
            <?php if (isset($_SESSION['profile_picture'])): ?>
              <img id="profilePicture" src="<?php echo $_SESSION['profile_picture']; ?>" alt="Photo de profil">
            <?php else: ?>
              <img id="profilePicture" src="image/users_icon/default.png" alt="Photo de profil par défaut">
            <?php endif; ?>
          </a>
        </li>
        <li class="nav-item">
          <a href="../php/profile.php" class="nav-link connect">Mon compte</a>
        </li>
        <?php 
        if ($_SESSION['user_role_ID'] == 2) {
          echo '<li class="nav-item"><a href="../php/admin_page.php" class="nav-link">Administration</a></li>';
        } else {
          echo '<li class="nav-item"><a href="../index.php" class="nav-link">Acceuil</a></li>';
        }

        ?>
        <li class="nav-item"><a href="../php/categorie.php?categorie=Serie" class="nav-link">Séries</a></li>
        <li class="nav-item"><a href="../php/categorie.php?categorie=Film" class="nav-link">Films</a></li>
        <li class="nav-item"><a href="../php/categorie.php?categorie=Anime" class="nav-link">Anime</a></li>
        <li class="nav-item"><a href="../php/categorie.php?categorie=Spectacles" class="nav-link">Spectacles</a></li>
        <li class="nav-item"><a href="../php/categorie.php?categorie=Bald" class="nav-link">Bald</a></li>
        <li class="nav-item">
          <a href="../php/logout.php" class="nav-link">Déconnexion</a>
        </li>
      </ul>
    </nav>
  </div>

  </div>
  </nav>

  <div class="search_nav">
    <input type="text" id="search" placeholder="Rechercher...">
    <button class="search-button" onclick="searchFunction()">Rechercher</button>
  </div>

  <div class="search_phone" role="search">
    <a href="#"><img src="../image/icon/loupe.png" alt=""></a>
  </div>

</header>