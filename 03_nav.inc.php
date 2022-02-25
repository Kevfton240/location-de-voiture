<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-flex align-items-center">
  <div class="container d-flex justify-content-center justify-content-md-between">
    <div class="contact-info d-flex align-items-center">
      <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">contact@goldenlocation.com</a>
      <i class="bi bi-phone-fill phone-icon"></i> +33 9 12 34 56 78
    </div>
    <div class="social-links d-none d-md-block">
      <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
    </div>
  </div>
</section>

<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-between">

    <h1 class="logo"><a href="<?= URL ?>index.php">Golden Location</a></h1>
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="<?= URL ?>index.php">Accueil</a></li>
        <li><a class="nav-link scrollto" href="<?php if($currentPage != "index") echo URL . "index.php" ?>#services"> Nos Services</a></li>
        <li><a class="nav-link scrollto " href="<?php if($currentPage != "index") echo URL . "index.php" ?>#vehicule">Les véhicules</a></li>
        <li><a class="nav-link scrollto" href="<?php if($currentPage != "index") echo URL . "index.php" ?>#tarif">Tarif</a></li>
        <li><a class="nav-link scrollto" href="apropos.php">A propos</a></li>

        <?php
        //=============================================//
        // menu de connexion, deconnexion, inscription //
        //=============================================//

        if (user_is_connected()) {
          // page profil & deco
        ?>
          <li class="dropdown"><a href="#"><span>Mon compte</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="<?= URL ?>profil.php">Mon Profil</a></li>
              <li><a href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a></li>
            </ul>
          </li>
        <?php
        }
        ?>
        <?php

        if (!user_is_connected()) {
          // page connexion & inscription
        ?>

          <li class="dropdown"><a href="#"><span>Connectez-vous</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="<?= URL  ?>connexion.php">Connexion</a></li>
              <li><a href="<?= URL  ?>inscription.php">Inscription</a></li>
            </ul>
          </li>

        <?php
        }
        ?>

        <?php
        //=============================================//
        // Menu admin                                  //
        //=============================================//

        if (user_is_admin()) {
          // gestion voiture
        ?>
          <li class="dropdown"><a href="#"><span>Gestion</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="<?= URL ?>admin/gestion_vehicules.php">Gestion des véhicules</a></li>
              <li><a href="<?= URL ?>admin/gestion_reservation.php">Gestion des réservations</a></li>
            </ul>
          </li>

        <?php
        }
        ?>

        <li><a class="nav-link scrollto" href="<?php if($currentPage != "index") echo URL . "index.php" ?>#contact">Contact</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  </div>
</header><!-- End Header -->
