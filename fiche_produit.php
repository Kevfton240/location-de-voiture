<?php
include 'inc/00_init.inc.php';
include 'inc/01_function.inc.php';
include 'inc/02_head.inc.php';

//*********************************//
// Recupération donnée du véhicule //
//*********************************//
if(isset($_GET['id'])){
    // SI ID PRESENT DANS URL
    $recup_data_vehicule = $pdo->prepare("SELECT * FROM voiture WHERE id = :id");
    $recup_data_vehicule->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    $recup_data_vehicule->execute();

    if ($recup_data_vehicule->rowCount() > 0){
        // SI VOITURE TROUVER EN BDD
        $info_vehicule = $recup_data_vehicule->fetch(PDO::FETCH_ASSOC);
        $id = $info_vehicule['id'];
    } else {
        // SI VOITURE NON TROUVER EN BDD
        header('location:' . URL . 'index.php#vehicule');
        exit();
    }
} else {
    // SI PAS ID DANS URL
    header('location:' . URL . 'index.php#vehicule');
    exit();
}

$permis = '';
$nom = '';
$prenom = '';
$info = '';
$telephone = '';
// Récuperation de la date d'aujourd'hui
$date_courrante = date("Y-m-d");
$date_debut = $date_courrante;
$date_fin = $date_courrante;

//****************************//
// ENREGISTREMENT RESA EN BDD //
//****************************//

if(isset($_POST['id_voiture']) && isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['permis']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['info'])){
   if(user_is_connected()){ // verification 
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $id_voiture = $_POST['id_voiture'];
    $permis = $_POST['permis'];
    $nom = $_POST['nom'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $info = $_POST['info'];


    //*********************************//
    // VERIFICATION DU RESTE DES INPUT //
    //*********************************//

    // VERIF DES DATES
    if(!validateDate($date_debut,'Y-m-d')){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Erreur présente pour la date de début.<br>Veuillez vérifier vos saisies.</div>';
    }
    if(!validateDate($date_fin,'Y-m-d')){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Erreur présente pour la date de fin.<br>Veuillez vérifier vos saisies.</div>';
    }
    // RECUPERATION DES RESERVATIONS LIE AU VEHICULE
    $recup_data_reservations= $pdo->prepare("SELECT * FROM reservation WHERE id_voiture = :id_voiture");
    $recup_data_reservations->bindParam(':id_voiture', $id_voiture, PDO::PARAM_STR);
    $recup_data_reservations->execute();
    $error = false;
    // VERIFICATION DE LA DISPO DU CRENAU
    $reserver = false;
    while (($reservation = $recup_data_reservations->fetch(PDO::FETCH_ASSOC)) && !$reserver && !$error) {
        if(date_overlap($reservation['date_debut'],$reservation['date_fin'],$date_debut,$date_fin)){
            $reserver = true;
            $error = true;
        }
    }

    // VERIFICATION DE L EXISTANCE DU VEHICULE
    $recup_data_vehicule = $pdo->prepare("SELECT * FROM voiture WHERE id = :id");
    $recup_data_vehicule->bindParam(':id', $id_voiture, PDO::PARAM_STR);
    $recup_data_vehicule->execute();
    if($recup_data_vehicule->rowCount()<1){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Une erreure est survenue. Véhicule non trouvé.</div>';
    }

    // VERIFICATION NOM
    if(strlen($nom) < 3 || strlen($nom)>50){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le nom doit faire entre 3 et 50 caractères.<br>Veuillez vérifier vos saisies.</div>';
    }

    // VERIFICATION PRENOM
    if(strlen($prenom) < 3 || strlen($prenom)>50){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le prenom doit faire entre 3 et 50 caractères.<br>Veuillez vérifier vos saisies.</div>';
    }

    // VERIFICATION DU TELEPHONE
    if(!is_numeric($telephone)){
        $error = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le numéron de téléphone doit exclusivement contenir des chiffres.<br>Veuillez vérifier vos saisies.</div>';
    }

       if(!$error){
           // A FAIRE LE CALCULE DU TARIF
           $tarif = 24;

           $id_membre = $_SESSION['membre']['id_membre'];
           $enregistrementReservation = $pdo->prepare("INSERT INTO reservation (id_voiture, id_membre, date_debut, date_fin, permis, nom, prenom, telephone, vehicule, info, tarif) VALUES(:id_voiture, :id_membre, :date_debut, :date_fin, :permis, :nom, :prenom, :telephone, :vehicule, :info, :tarif)");
           $enregistrementReservation->bindParam(":id_voiture", $id_voiture, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":id_membre", $id_membre, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":date_debut", $date_debut, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":date_fin", $date_fin, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":permis", $permis, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":nom", $nom, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":prenom", $prenom, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":telephone", $telephone, PDO::PARAM_STR);
           $vehicule = $info_vehicule['marque'] . ' ' . $info_vehicule['modele'];
           $enregistrementReservation->bindParam(":vehicule", $vehicule, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":info", $info, PDO::PARAM_STR);
           $enregistrementReservation->bindParam(":tarif", $tarif, PDO::PARAM_STR);
           $enregistrementReservation->execute();
       }
   if($reserver){
      $msg .= '<div class="alert alert-danger mb-3">⚠, Ce véhicule est déjà réservé sur ces dates.</div>';
   }

   } else {
    $msg .= '<div class="alert alert-danger mb-3 text-center">Veuillez vous connectez, pour pouvoir réserver.<br> <a class="fs-italic text-dark" href="connexion.php">Connectez-vous ici <i class="far fa-arrow-alt-circle-right "></i></a> ou alors,  <a class="fs-italic text-dark" href="inscription.php">Inscrivez-vous ici <i class="far fa-arrow-alt-circle-right"></i></a></div>';
   }
}

//**************************//
// Récupération réservation //
//**************************//
//on requpère les date de début de de fin des reservations à venir. Ainsi que data_debut et data_fin qui serviron a être injecter dans les elements de la liste sour forme de data-atribute en html
$requeteReservations = $pdo->prepare("SELECT DATE_FORMAT(date_debut, '%d/%m/%Y') AS date_debut, DATE_FORMAT(date_fin, '%d/%m/%Y') as date_fin, DATE_FORMAT(date_debut, '%Y%m%d') as data_debut, DATE_FORMAT(date_fin, '%Y%m%d') as data_fin FROM reservation WHERE :id_voiture = id_voiture AND date_fin > :date_courrante");
$requeteReservations->bindParam(":id_voiture", $_GET['id'], PDO::PARAM_STR);
$requeteReservations->bindParam(":date_courrante", $date_courrante, PDO::PARAM_STR);
$requeteReservations->execute();

// debut des affichages
include 'inc/03_nav.inc.php';
?>

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Accueil</a></li>
          <li><?= $info_vehicule['marque'] . ' '. $info_vehicule['modele'] ?> </li>
        </ol>
        <h2><?= $info_vehicule['marque'] . ' '. $info_vehicule['modele'] ?>  Details</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">
        <?= $msg ?>
        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                  <img src="assets/img/voiture/<?= $info_vehicule['image'] ?>" alt="">
                </div>

                <!-- faudra penser a rajoouter des img pour les sliders -->
                <div class="swiper-slide">
                  <img src="assets/img/portfolio/portfolio-2.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="assets/img/portfolio/portfolio-3.jpg" alt="">
                </div>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3> <?= $info_vehicule['modele'] ?> </h3>
              <ul>
                <li><strong>Marque</strong>: <?= $info_vehicule['marque'] ?></li>
                <li><strong>Puissance</strong>: <?= $info_vehicule['puissance'] ?></li>
                <li><strong>Energie</strong>: <?= $info_vehicule['energie'] ?></li>
                <li><strong>Consomation moyenne</strong>: <?= $info_vehicule['consomation'] ?></li>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>Elle peut vous surprendre :</h2>
              <p>
                Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur dignissimos. Sequi nulla at esse enim cum deserunt eius.
              </p>
            </div>
          </div>
        </div>
        <div class="row gy-4">
            <h1>Fiche de revervation</h1>
            <form action="" method="post" class="row gy-4">
              <div class="col-lg-6">
                <input type="hidden" name="id_voiture" value="<?= $id ?>">
                <div class="mb-3">
                    <label for="permis">Numero de permis: </label>
                    <input  id="permis" name="permis" class="form-control" value="<?= $permis ?>">
                </div>
                <div class="mb-3">
                    <label for="nom">Nom : </label>
                    <input  id="nom" name="nom" class="form-control" value="<?= $nom ?>">
                </div>
                <div class="mb-3">
                    <label for="prenom">Prenom : </label>
                    <input  id="prenom" name="prenom" class="form-control" value="<?= $prenom ?>">
                </div>
                <div class="mb-3">
                    <label for="telephone">Telephone : </label>
                    <input  id="telephone" name="telephone" class="form-control" value="<?= $telephone ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label for="date_debut">Date de début de réservation : </label>
                  <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= $date_debut ?>">
                </div>
                <div class="mb-3">
                    <label for="date_fin">Date de fin de réservation : </label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="<?= $date_fin ?>">
                </div>
                <div class="mb-3">
                    <label for="info">Informations complémentaires : </label>
                    <textarea name="info" class="form-control" id="info"><?= $info ?></textarea>
                </div>
                <div class="mb-3" id="submit">
                    <input type="submit" value="Reserver" id="btn_reservation" class="btn btn-outline-dark rounded-pill w-100">
                </div>
              </div>
            </form>
          </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

 <?php
 include 'inc/06_footer2.inc.php';
