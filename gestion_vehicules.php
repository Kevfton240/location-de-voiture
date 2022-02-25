<?php
include "../inc/00_init.inc.php";
include "../inc/01_function.inc.php";

// Redirige si l'utilisateur n'est pas admin
if (!user_is_admin()) {
    header('location: ../connexion.php');
    exit(); // Permet de bloquer l'execution de la suite du code de la page.
}

//************************//
// SUPRESSION DU VEHICULE //
//************************//
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id'])) {

    // //Récupération des données de la voitura voiture pour pouvoir supprimer sa image.
    $recup_nom_image = $pdo->prepare("SELECT * FROM voiture WHERE id= :id");
    $recup_nom_image->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    $recup_nom_image->execute();

    if ($recup_nom_image->rowCount() > 0) {
        $recup = $recup_nom_image->fetch(PDO::FETCH_ASSOC);
        unlink(ROOT_PATH . IMG_DIRECTORY . $recup['image']);
    }


    $id = $_GET['id'];
    $supprimer = $pdo->prepare("DELETE FROM voiture WHERE id= :id");
    $supprimer->bindParam(':id', $id, PDO::PARAM_STR);
    $supprimer->execute();

    if ($supprimer->rowCount() > 0) {
        $msg .= '<div class="alert alert-success">La voiture n° ' . $id . ' a bien été supprimée. </div>';
    }
}

$id = ''; // Champ caché du formulaire réservé à la modification
$marque = '';
$modele = '';
$tarif24 = '';
$tarifSemaine = '';
$caution = '';
$image = '';
$energie = '';
$consomation = '';
$puissance = '';

//******************************************//
// RECUPERATION DES DONNEES SI MODIFICATION //
//******************************************//

if (isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id'])) {
    $modification = $pdo->prepare("SELECT * FROM voiture WHERE id= :id");
    $modification->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    $modification->execute();

    if ($modification->rowCount() > 0) {
        $infos = $modification->fetch(PDO::FETCH_ASSOC);
        $id = $infos['id'];
        $marque = $infos['marque'];
        $modele = $infos['modele'];
        $tarif24 = $infos['tarif24'];
        $tarifSemaine = $infos['tarifSemaine'];
        $caution = $infos['caution'];
        $image = $infos['image'];
        $energie = $infos['energie'];
        $consomation = $infos['consomation'];
        $puissance = $infos['puissance'];
    }
}

//***********************//
// Enregistrement en BDD //
//***********************//

if (isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['tarif24']) && isset($_POST['tarifSemaine']) && isset($_POST['caution']) && isset($_POST['energie']) && isset($_POST['consomation']) && isset($_POST['puissance'])) {

    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $tarif24 = trim($_POST['tarif24']);
    $tarifSemaine = trim($_POST['tarifSemaine']);
    $caution = trim($_POST['caution']);
    $energie = trim($_POST['energie']);
    $puissance = trim($_POST['puissance']);
    $consomation = trim($_POST['consomation']);

    // Récupération de l'id si modification
    if (!empty($_POST['id'])) {
        $id = trim($_POST['id']);
    }

    $erreur = false;
    // Contôle sur la disponibilité de la reference car unique en BDD

    //Contrôle : la marque doit être définie
    if (empty($marque)) {
        $msg .= '<div class="alert alert-danger mb-3 ">⚠ La voiture n\'a pas de marque !</div>';
        $erreur = true;
    }

    //Contrôle : le modele doit être défini
    if (empty($modele)) {
        $msg .= '<div class="alert alert-danger mb-3 ">⚠ La voiture n\'a pas de modèle !</div>';
        $erreur = true;
    }

    // Contrôle : Le tarif 24h doit être numérique
    if (!is_numeric($tarif24)) {
        $msg .= '<div class="alert alert-warning mb-3 ">⚠ Le tarif 24h doit être défini.</div>';
        $error = true;
    } else {

        // Contrôle : si le tarif Semaine n'est pas défini il est mit au sept de celui de 24h
        if (!is_numeric($tarifSemaine)) {
            $tarifSemaine = intval($tarif24) * 7;
            $msg .= '<div class="alert alert-warning mb-3 ">⚠ Le tarif ebdomadaire n\'étant pas renseigné, a été mis au sept de celui de 24h.</div>';
        }
    }

    // Contrôle : La caution doit être numérique
    if (!is_numeric($tarif24)) {
        $msg .= '<div class="alert alert-warning mb-3 ">⚠ La caution doit être défini.</div>';
        $error = true;
    }

    // Contrôle sur l'image
    //Les fichiers d'un formulaire vont dans la superglobale $_FILES(obligatoire de mettre l'attribut enctype sur le form sinon les fichiers ne seront jamais récupérés !)
    if (!empty($_FILES['image']['name'])) {
        // Attention car $_FILES n'est jamais vide à la validation du form.
        //Il faut aller jusqu'au ['name'] du fichier chargé afin d'être sûr qu'un fichier soit présent.

        //Afin d'être sûr que le fichier chargé est bien une image avec un extension valide pour le web, nous allons recupérer l'extension du fichier pour le comparer avec des extension valides
        $tab_extension_valide = ['png', 'gif', 'jpg', 'jpeg', 'webp'];

        // Pour vérifier l'extension, nous allons découper le nom du fichier en partant de la fin, on remonte au permier point trouvé,  et on récupère tout depuis ce point : strrchr()

        $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
        // exemple : pour le fichier truc.png on récupère .png
        //Ensuite on enleve le point dans la chaine de caractère recupéré pour avoir png avec substr
        // Puis on met tout en minuscule pour pas avoir de souci,  avec strtolower()

        //On va maintenant comparer les extensions reçu avec les extension acceptées qui sont dans le tableau tab_extension_valide
        // in_array() renvoie true si le premier argument est présent dans les valeurs du tableau fourni en deuxième argument
        if (in_array($extension, $tab_extension_valide) && $erreur == false) {
            // On vérifie si $erreur == false car si il est true, le produit ne sera pas enregistré donc pas besoin d'enregistrer l'image.
            // Extension ok on va lancer la copie
            // On rajoute la référence (unique) devant le nom de l'image afin de ne pas ecraser une image deja enregistré du meme nom
            $image = $marque . '_' . $modele . '_' .  $_FILES['image']['name'];

            // Chemin du dossier pour enregistrer l'image :
            $chemin_enregistrement_image = ROOT_PATH . IMG_DIRECTORY . $image;
            // On copie : copy(chemin_origine, chemin_cible);
            copy($_FILES['image']['tmp_name'], $chemin_enregistrement_image);
        } else {
            //cas d'erreur
            $msg .= '<div class="alert alert-danger mb-3 ">⚠ L\'extension de l\'image n\'est pas valide.<br> Vérifiez si votre image est bien en png, gif, jpg, jpeg ou webp .</div>';
            $erreur = true;
        } // Si extension ok
    } // Si une image est chargé

    //*************************************//
    // Enregistrement de la voiture en bdd //
    //*************************************//

    if ($erreur == false) {

        if (empty($id)) {

            $enregistrement = $pdo->prepare("INSERT INTO voiture (marque, modele, tarif24, tarifSemaine, caution, consomation, energie, puissance, image) VALUES (:marque, :modele, :tarif24, :tarifSemaine, :caution, :consomation, :energie, :puissance, :image)");
            $enregistrement->bindParam(':image', $image, PDO::PARAM_STR);
        } else {
            $enregistrement = $pdo->prepare("UPDATE voiture SET marque = :marque, modele = :modele, tarif24 = :tarif24, tarifSemaine = :tarifSemaine, caution = :caution, energie = :energie, consomation = :consomation, puissance = :puissance WHERE id= :id");
            $enregistrement->bindParam(':id', $id, PDO::PARAM_STR);
        }
        $enregistrement->bindParam(':marque', $marque, PDO::PARAM_STR);
        $enregistrement->bindParam(':modele', $modele, PDO::PARAM_STR);
        $enregistrement->bindParam(':tarif24', $tarif24, PDO::PARAM_STR);
        $enregistrement->bindParam(':tarifSemaine', $tarifSemaine, PDO::PARAM_STR);
        $enregistrement->bindParam(':caution', $caution, PDO::PARAM_STR);
        $enregistrement->bindParam(':consomation', $consomation, PDO::PARAM_STR);
        $enregistrement->bindParam(':energie', $energie, PDO::PARAM_STR);
        $enregistrement->bindParam(':puissance', $puissance, PDO::PARAM_STR);
        $enregistrement->execute();

        //On redirige sur la même page afin de ne plus avoir la mémoire du formulaire si on recharge la page
        header('location: gestion_vehicules.php');
    }
}

//***************************//
// Récupération des voitures //    
//***************************//
$voitures = $pdo->query("SELECT * FROM voiture ORDER BY marque, modele");
include "../inc/02_head.inc.php";
include "../inc/03_nav.inc.php";

?>

<div class="bg-light pb-5">
    <h1 class="text-center pt-5 fw-bold"> Gestion des véhicules <i class="fas fa-cogs"></i></h1>
</div>

<main class="container-fluid">

    <div class="container">
        <div class="row mt-5">

            <div class="col-12"><?= $msg ?></div>

            <div class="col-12">
                <form action="" method="POST" class="border rounded p-3 row" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="marque"><i class="fas fa-car"></i> Marque : </label>
                            <input type="text" name="marque" id="marque" class="form-control" value="<?= $marque ?>">
                        </div>
                        <div class="mb-3">
                            <label for="modele"><i class="fas fa-car"></i> Modèle : </label>
                            <input type="text" name="modele" id="modele" class="form-control" value="<?= $modele ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image"><i class="far fa-images"></i> Photo</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="energie"><i class="fas fa-gas-pump"></i> Enérgie : </label>
                            <input type="text" name="energie" id="energie" class="form-control" value="<?= $energie ?>">
                        </div>
                        <div class="mb-3">
                            <label for="consomation"><i class="fas fa-oil-can"></i> Consomation : </label>
                            <input type="text" name="consomation" id="consomation" class="form-control" value="<?= $consomation ?>">
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="puissance"><i class="fas fa-horse-head"></i> Puissance : </label>
                            <input type="text" name="puissance" id="puissance" class="form-control" value="<?= $puissance ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tarif24"><i class="fas fa-money-bill-alt"></i> Tarif 24h : </label>
                            <input type="text" name="tarif24" id="tarif24" class="form-control" value="<?= $tarif24 ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tarifSemaine"><i class="fas fa-money-bill-alt"></i> Tarif Hebdomadaire : </label>
                            <input type="text" name="tarifSemaine" id="tarifSemaine" class="form-control" value="<?= $tarifSemaine ?>">
                        </div>
                        <div class="mb-3">
                            <label for="caution"><i class="fas fa-money-bill-alt"></i> Caution : </label>
                            <input type="text" name="caution" id="caution" class="form-control" value="<?= $caution ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" id="enregistrement" class="btn btn-outline-dark rounded-pill w-100">Enregistrement <i class="fas fa-sign-in-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="col-12 mt-5">
                <p class="alert alert-secondary">Actuellement <?= $voitures->rowCount() ?> véhicules enregistrés.</p>
                <hr>
                <table class="table table-bordered text-center w-100">
                    <thead class="">
                        <tr>
                            <th>ID voiture</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Energie</th>
                            <th>Consomation</th>
                            <th>Puissance</th>
                            <th>Tarif 24h</th>
                            <th>Tarif Hebdo</th>
                            <th>Caution</th>
                            <th>Photo</th>
                            <th>Modif</th>
                            <th>Suppr</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($voiture = $voitures->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $voiture['id'] . '</td>';
                            echo '<td>' . $voiture['marque'] . '</td>';
                            echo '<td>' . $voiture['modele'] . '</td>';
                            echo '<td>' . $voiture['energie'] . '</td>';
                            echo '<td>' . $voiture['consomation'] . '</td>';
                            echo '<td>' . $voiture['puissance'] . '</td>';
                            echo '<td>' . $voiture['tarif24'] . ' €' . '</td>';
                            echo '<td>' . $voiture['tarifSemaine'] . ' €' .  '</td>';
                            echo '<td>' . $voiture['caution'] . ' €' .  '</td>';
                            echo '<td><img src="' . URL . 'assets/img/voiture/' . $voiture['image'] . '" width="100"></td>';
                            echo '<td><a href="?action=modifier&id=' . $voiture['id'] . '" class="btn btn-warning">editer</a></td>';
                            // AJOUTER UNE VALIDATION SUR LA SUPRESSION
                            echo '<td><a href="?action=supprimer&id=' . $voiture['id'] . '" class="btn btn-danger">suprimer</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</main>