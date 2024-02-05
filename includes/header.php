<header class="header">

  <div class="title">
    <h1><a href="../index.php">BaldFlix</a></h1>
  </div>

  <nav class="main_nav" role="navigation">
    <div class="menu">
      <ul class="menu_list">
        <li><a href="../php/categorie.php?categorie=Série"">Séries</a></li>
        <li><a href="../php/categorie.php?categorie=Film">Films</a></li>
        <li><a href="../php/categorie.php?categorie=Anime">Anime</a></li>
        <li><a href="../php/categorie.php?categorie=Spectacle">Spectacles</a></li>
        <li><a href="../php/categorie.php?categorie=Bald">Bald</a></li>
        <li><a href="../php/mention_legale.php">Mentions</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <nav class="navbar" role="navigation">
      <div class="hamburger_menu">
        <div class="line line_1"></div>
        <div class="line line_2"></div>
        <div class="line line_3"></div>
      </div>
      <ul class="nav_list">
        <li class="nav_item nav_hero">
          <a href="#" class="hero" id="herro">
            <?php if (isset($_SESSION['profile_picture'])): ?>
              <img id="profilePicture" src="<?php echo $_SESSION['profile_picture']; ?>" alt="Photo de profil">
            <?php else: ?>
              <img id="profilePicture" src="image/users_icon/default.png" alt="Photo de profil par défaut">
            <?php endif; ?>
          </a>
        </li>
        <li class="nav_item">
          <a href="../php/profile.php" class="nav_link connect">Mon compte</a>
        </li>
        <?php 
        if ($_SESSION['user_role_ID'] == 2) {
          echo '<li class="nav_item"><a href="../php/admin_page.php" class="nav_link">Administration</a></li>';
        } else {
          echo '<li class="nav_item"><a href="../index.php" class="nav_link">Acceuil</a></li>';
        }

        ?>
        <li class="nav_item"><a href="../php/categorie.php?categorie=Serie" class="nav_link">Séries</a></li>
        <li class="nav_item"><a href="../php/categorie.php?categorie=Film" class="nav_link">Films</a></li>
        <li class="nav_item"><a href="../php/categorie.php?categorie=Anime" class="nav_link">Anime</a></li>
        <li class="nav_item"><a href="../php/categorie.php?categorie=Spectacle" class="nav_link">Spectacles</a></li>
        <li class="nav_item"><a href="../php/categorie.php?categorie=Bald" class="nav_link">Bald</a></li>
        <li class="nav_item">
          <a href="../php/logout.php" class="nav_link">Déconnexion</a>
        </li>
      </ul>
    </nav>
  </div>

  </div>
  </nav>

  <div class="search_nav"
  <form action="../php/search.php" method="get">
    <input type="text" class="search" id="search" placeholder="Rechercher...">
    <button class="search_button" onclick="searchFunction()">Rechercher</button>
    </form>
  </div>

  <div class="search_phone" role="search">
    <a href="#"><img src="../image/icon/loupe.png" alt=""></a>
  </div>

</header>