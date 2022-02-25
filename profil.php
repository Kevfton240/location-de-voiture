<?php
include 'inc/00_init.inc.php';
include 'inc/01_function.inc.php';
include 'inc/02_head.inc.php';

//********************************//
// Recupération donnée du memebre //
//********************************//
if(user_is_connected()){
    // SI ID PRESENT DANS URL
    $recup_data_membre = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $recup_data_membre->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
    $recup_data_membre->execute();

    if ($recup_data_membre->rowCount() > 0){
        // SI VOITURE TROUVER EN BDD
        $info_membre = $recup_data_membre->fetch(PDO::FETCH_ASSOC);
        $id = $info_membre['id_membre'];
    } else {
        // SI VOITURE NON TROUVER EN BDD
        header('location:' . URL . 'connexion.php?oui='.$_SESSION['membre']['id_membre']);
        exit();
    }
} else {
    // SI PAS ID DANS URL
    header('location:' . URL . 'connexion.php');
    exit();
}

$recup_data_reservation = $pdo->prepare("SELECT * FROM reservation WHERE id_membre = :id_membre");
$recup_data_reservation->bindParam(':id_membre', $id, PDO::PARAM_STR);
$recup_data_reservation->execute();



$nom = $info_membre['nom'];
$prenom = $info_membre['prenom'];
$pseudo = $info_membre['pseudo'];
$email = $info_membre['email'];
$sexe = $info_membre['sexe'];
$adresse = $info_membre['adresse'];
$cp = $info_membre['cp'];
$ville = $info_membre['ville'];
$statut = $info_membre['statut'];

// debut des affichages
include 'inc/03_nav.inc.php';
?>
<section id="tarif" class="pricing">
    <div class="container">

        <div class="section-title">
            <span>Votre compte</span>
            <h2>Votre compte</h2>
            <p>Gérer vos reservations</p>
        </div>

        <div class="row">

            <div class="col-lg-4 col-md-6 mt-4 mt-md-0" data-aos="zoom-in">
                <div class="box featured profil-card">
                    <h3>Votre Profil : </h3>
                    <ul>
                        <li>Nom : <?= $nom ?></li>
                        <li>Prenom : <?= $prenom ?></li>
                        <li>Pseudo : <?= $pseudo ?></li>
                        <li>Email : <?= $email ?></li>
                        <li>Sexe : <?= ($sexe == 'm')? 'Homme' : "Femme" ?></li>
                        <li>Adresse : <?= $adresse ?></li>
                        <li>Code postal : <?= $cp ?></li>
                        <li>Ville : <?= $ville ?></li>
                        <?= ($statut == '2')? '<li>Statut : administrateur </li>' : '' ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8 col-md-6 mt-4 mt-md-0" data-aos="zoom-in">
                <table class="">
                    <thead>
                        <tr>
                            <th>ID | </th> 
                            <th>Date Début | </th> 
                            <th>Date Fin | </th> 
                            <th>Véhicule | </th> 
                            <th>Permis | </th> 
                            <th>Info | </th> 
                            <th>Tarif</th> 
                        </tr>
                    </thead>
                <tbody>
                <?php
                    while($reservation = $recup_data_reservation->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $reservation['id_reservation'] ?> | </td>
                            <td><?= $reservation['date_debut'] ?> | </td>
                            <td><?= $reservation['date_fin'] ?> | </td>
                            <td><?= $reservation['vehicule'] ?> | </td>
                            <td><?= $reservation['permis'] ?> | </td>
                            <td><?= $reservation['info'] ?></td>
                            <td><?= $reservation['tarif'] ?></td>
                        </tr>
                    <?php
                       }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php
    include 'inc/06_footer2.inc.php';
