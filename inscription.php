<?php
include "inc/00_init.inc.php";
include "inc/01_function.inc.php";

include_once "inc/02_head.inc.php";

$pseudo = '';
$mdp = '';
$nom = '';
$prenom = '';
$email = '';
$sexe = '';
$ville = '';
$cp = '';
$adresse = '';

if (isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['sexe']) && isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['adresse'])) {
    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $sexe = trim($_POST['sexe']);
    $ville = trim($_POST['ville']);
    $cp = trim($_POST['cp']);
    $adresse = trim($_POST['adresse']);

    $msg = "";
    $erreur = false;

    // Verif pseudo
    if (iconv_strlen($pseudo) < 1 || iconv_strlen($pseudo) >= 25) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le pseudo doit avoir entre 1 et 25 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif si le pseudo est déjà pris
    $requete = $pdo->prepare("SELECT * FROM membre where pseudo = :pseudo");
    $requete->bindParam("pseudo", $pseudo, PDO::PARAM_STR);
    $requete->execute();
    if ($requete->rowCount() > 0) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le pseudo est déjà pris<br>Veuillez en changer.</div>';
    }

    // Verif mdp
    if (iconv_strlen($mdp) < 7 || iconv_strlen($pseudo) >= 50) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le mot de passe doit avoir entre 7 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif nom
    if (iconv_strlen($nom) < 1 || iconv_strlen($nom) >= 50) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le nom doit avoir entre 1 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif prenom
    if (iconv_strlen($prenom) < 1 || iconv_strlen($prenom) >= 50) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le prenom doit avoir entre 1 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif email
    if (iconv_strlen($email) < 1 || iconv_strlen($email) >= 50) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, L\'email doit avoir entre 1 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, L\'email n\'est pas valide<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif ville
    if (iconv_strlen($ville) < 1 || iconv_strlen($ville) >= 50) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le nom de la ville doit avoir entre 1 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif cp
    if (iconv_strlen($cp) < 1 || iconv_strlen($cp) > 5) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le code postal doit avoir entre 1 et 5 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    // Verif adresse
    if (iconv_strlen($adresse) < 1 || iconv_strlen($adresse) >= 100) {
        $erreur = true;
        $msg .= '<div class="alert alert-danger mb-3">⚠, Le code postal doit avoir entre 1 et 50 caractères inclus<br>Veuillez vérifier vos saisies.</div>';
    }

    if ($erreur == false) {

        $enregistrement = $pdo->prepare("INSERT INTO membre(statut, pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse) VALUES(:statut, :pseudo, :mdp, :nom, :prenom, :email, :sexe, :ville, :cp, :adresse)");
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $statut = "0";
        $enregistrement->bindParam("statut", $statut, PDO::PARAM_STR);
        $enregistrement->bindParam("pseudo", $pseudo, PDO::PARAM_STR);
        $enregistrement->bindParam("mdp", $mdp, PDO::PARAM_STR);
        $enregistrement->bindParam("nom", $nom, PDO::PARAM_STR);
        $enregistrement->bindParam("prenom", $prenom, PDO::PARAM_STR);
        $enregistrement->bindParam("email", $email, PDO::PARAM_STR);
        $enregistrement->bindParam("sexe", $sexe, PDO::PARAM_STR);
        $enregistrement->bindParam("ville", $ville, PDO::PARAM_STR);
        $enregistrement->bindParam("cp", $cp, PDO::PARAM_STR);
        $enregistrement->bindParam("adresse", $adresse, PDO::PARAM_STR);
        $enregistrement->execute();
        header('location:connexion.php');
    }
}

// debut des affichages
include 'inc/03_nav.inc.php';
// include 'inc/04_header.inc.php';
?>
<main class="container-fluid">
    <div class="bg-light p-3 text-center">
        <h1>Inscription <i class="far fa-edit text-dark"></i></h1>
        <p class="lead text-dark">Vous avez déjà un compte ? <a class="text-danger fs-italic" href="connexion.php">Connectez vous ici <i class="far fa-arrow-alt-circle-right"></i></a></p>
    </div>

    <div class="container">
        <div class="row mt-5 form_inscription">
            <div class="col-12">
                <?= $msg ?>
            </div>
            <div class="col-12">
                <form method="post" action="" class="border p-3 row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="pseudo">Pseudo <i class="fas fa-user"></i></label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= $pseudo; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="mdp">Mot de passe</label>
                            <input type="password" name="mdp" id="mdp" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="<?= $nom; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="prenom">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control" value="<?= $prenom; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="sexe">Sexe</label>
                            <select name="sexe" id="sexe" class="form-control">
                                <option value="m">Homme</option>
                                <option value="f" <?php if ($sexe == 'f') {
                                                        echo 'selected';
                                                    } ?>>Femme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ville">Ville </label>
                            <input type="text" name="ville" id="ville" class="form-control" value="<?= $ville; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cp">Code postal</label>
                            <input type="text" name="cp" id="cp" class="form-control" value="<?= $cp; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="adresse">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control"><?= $adresse; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="inscription" class="btn btn-outline-danger rounded-pill w-100"><i class="fas fa-sign-in-alt"></i> Inscription <i class="fas fa-sign-in-alt"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include_once "inc/06_footer2.inc.php";
    ?>