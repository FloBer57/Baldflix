<!-- <link href="css/global.CSS" rel="stylesheet" /> -->

<header class="header">

    <div class="title">
      <h1><a href="index.php">BaldFlix</a></h1>
    </div>

    <nav class="main-nav" role="navigation">
      <div class="menu">
        <ul class="menu-list">
          <li><a href="index.php">Home</a></li>
          <li><a href="serie.html">Séries</a></li>
          <li><a href="films.html">Films</a></li>
          <li><a href="anime.html">Anime</a></li>
          <li><a href="spectacles.html">Spectacles</a></li>
          <li><a href="bald.html">Bald</a></li>
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
            <a href="#" class="hero" id="herro"><img src="image/users_icon/icon.png" alt=""></a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link connect">Mon compte</a>
          </li>
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="serie.html" class="nav-link">Séries</a>
          </li>
          <li class="nav-item">
            <a href="films.html" class="nav-link">Films</a>
          </li>
          <li class="nav-item">
            <a href="anime.html" class="nav-link">Anime</a>
          </li>
          <li class="nav-item">
            <a href="spectacles.html" class="nav-link">Spectacles</a>
          </li>
          <li class="nav-item">
            <a href="bald.html" class="nav-link">Bald</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">Déconnexion</a>
          </li>
        </ul>
      </nav>
      <script src="js/burger.js"></script>
    </div>

    </div>
    </nav>

    <div class="search_nav">
      <input type="text" id="search" placeholder="Rechercher...">
      <button class="search-button" onclick="searchFunction()">Rechercher</button>
    </div>

    <div class="search_phone" role="search">
      <a href="#"><img src="image/loupe.png" alt=""></a>
    </div>

  </header>