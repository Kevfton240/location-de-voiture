<?php
include 'inc/00_init.inc.php';
include 'inc/01_function.inc.php';
include 'inc/02_head.inc.php';


$voiture = '';
$mercedes = '';
$audi = '';
$porsche = '';

//***************************//
// Récupération des voitures //
//***************************//
$voitures = $pdo->query("SELECT * FROM voiture ORDER BY marque, modele");

$marques = $pdo->query("SELECT DISTINCT marque FROM voiture ORDER BY marque");

// debut des affichages
include 'inc/03_nav.inc.php';
include 'inc/04_header.inc.php';

?>
<main id="main">

  <!-- ======= Why Us Section ======= -->
  <section id="why-us" class="why-us">
    <div class="container">

      <div class="section-title">
        <span>Pourquoi nous ?</span>
        <h2>Pourquoi nous ?</h2>
        <p>Un service à la hauteur de vos qualitées</p>
      </div>

      <div class="row">

        <div class="col-lg-4" data-aos="fade-up">
          <div class="box">
            <span>Rapidité</span>
            <h4>Efficacité</h4>
            <p>Grâce a la conaissance de nos expert vous gagnerez un temps fou.</p>

          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="150">
          <div class="box">
            <span>Facilité</span>
            <h4>Accesilibité</h4>
            <p>Une application accecible à tous.</p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="box">
            <span>Engagement</span>
            <h4>Sécurité</h4>
            <p>Chez Golden Location nous vous offrons ce qu'il ya de meileures en termes de voiture, de prix ainsi que de securité. Toutes nos voitures sont assurées au plus haut rang.</p>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Why Us Section -->

  <!-- ======= Clients Section ======= -->
  <section id="clients" class="clients">
    <div class="container" data-aos="zoom-in">
      <h2>Ils nous font confiance</h2>

      <!-- logo marque partenaire (garage, service ect..) -->

      <div class="row d-flex align-items-center">

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6">
          <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
        </div>

      </div>

    </div>
  </section><!-- End Clients Section -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title">
        <span>Services</span>
        <h2>Services</h2>
        <p>Un service à la hauteur de votre qualitée</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-calendar-date"></i></div>
            <h4><a href="">Location à la journée</a></h4>
            <p>Besoin d'un véhicule pour 24H ? Golden Location est là pour vous.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="150">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-calendar-range"></i></div>
            <h4><a href="">Location à la semaine</a></h4>
            <p>Une semaine de vacances ? Golden Location vous accompagne.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-calendar-day"></i></div>
            <h4><a href=""></a>Location au mois</h4>
            <p>Optez pour un un plaisir de longue durée. Profitez de ce qui ce fait de mieux en termes d'automobile. </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="450">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-world"></i></div>
            <h4><a href="">Partout dans le monde</a></h4>
            <p>Où que vous soyez dans le monde, Golden Location ne sera jamais très loin.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="600">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-car"></i></div>
            <h4><a href="">Service voiturier n'importe où chez l'un de nos partenaire</a></h4>
            <p>Profitez d'un service voiturier dans toutes les infrasctructures partenaires.</p>
          </div>
        </div>
        <!-- on pourrait imaginer que chez certains commerçant (luxe) restau ect le service voiturier soit partenaire de la boite et prend en charge le véhicule dès l\'arriver de nos clients en loc -->

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="750">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-arch"></i></div>
            <h4><a href="">Des partenaires de grand nom</a></h4>
            <p>Des partenaires des plus luxieux partout dans le monde.</p>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Services Section -->

  <!-- ======= Vehicule Section ======= -->
  <section id="vehicule" class="portfolio">
    <div class="container">

      <div class="section-title">
        <span>Nos véhicule</span>
        <h2>Nos véhicule</h2>
        <p>De la sportive à la plus confortable, vous saurez trouver votre bonheur.</p>
      </div>

      <div class="row" data-aos="fade-up">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">Toutes</li>
            <?php
            while ($marque = $marques->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <li data-filter=".<?= $marque['marque'] ?>"><?= $marque['marque'] ?></li>
            <?php
            }
            ?>
          </ul>
        </div>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="150">
        <?php
        while ($voiture = $voitures->fetch(PDO::FETCH_ASSOC)) {
        ?>
          <div class="col-lg-4 col-md-6 portfolio-item <?= $voiture['marque'] ?>">
            <a href="fiche_produit.php?id=<?= $voiture['id'] ?>"><img src="assets/img/voiture/<?= $voiture['image'] ?>" class="img-fluid" alt=""></a>
            <div class="portfolio-info">
              <h4><?= $voiture['marque'] ?></h4>
              <p><?= $voiture['modele'] ?></p>
              <a href="assets/img/voiture/<?= $voiture['image'] ?>" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="<?= $voiture['marque'] . ' ' . $voiture['modele'] ?>"><i class="far fa-eye"></i></a>
              <a href="fiche_produit.php?id=<?= $voiture['id'] ?>" class="details-link" title="Pus de détails"><i class="far fa-arrow-alt-circle-right"></i></a>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
    </div>
  </section><!-- End Portfolio Section -->

  <!-- ======= tarif Section ======= -->
  <section id="tarif" class="pricing">
    <div class="container">

      <div class="section-title">
        <span>Tarif</span>
        <h2>Tarif</h2>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="150">
          <div class="box">
            <h3>Tarif à la journée</h3>
            <h4>600<sup>€</sup><span> / jours</span></h4>
            <ul>
              <li>Véhicule pendant 24h</li>
              <li>Essence au plein</li>
              <li>Service d'aide et d'assurance 24h/24h</li>
              <li class="na">Service voiturier</li>
              <li class="na">Ofrre et événement VIP</li>
            </ul>
            <div class="btn-wrap">
              <a href="#vehicule" class="btn-buy">Reservez votre véhicule maintenant</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mt-md-0" data-aos="zoom-in">
          <div class="box featured">
            <h3>Tarif à la semaine</h3>
            <h4>3 800<sup>€</sup><span> / Semaine</span></h4>
            <ul>
              <li>Véhicule pendant 7j</li>
              <li>Essence au plein</li>
              <li>Service d'aide et d'assurance 24h/24h, 7j/7</li>
              <li>Service voiturier</li>
              <li>Ofrre et événement VIP</li>
            </ul>
            <div class="btn-wrap">
              <a href="#vehicule" class="btn-buy">Reservez votre véhicule maintenant</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
          <div class="box">
            <h3>Tarif du Week-End</h3>
            <h4>1 700<sup>€</sup><span> / Week-end</span></h4>
            <ul>
              <li>Véhicule pendant le Week-End</li>
              <li>Essence au plein</li>
              <li>Service d'aide et d'assurance 24h/24h, 7j/7</li>
              <li>Service voiturier</li>
              <li>Ofrre et événement VIP</li>
            </ul>
            <div class="btn-wrap">
              <a href="#vehicule" class="btn-buy">Reservez votre véhicule maintenant</a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Pricing Section -->

  <?php
  include 'inc/05_footer.inc.php';
