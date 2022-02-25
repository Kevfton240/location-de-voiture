<?php
include 'inc/00_init.inc.php';
include 'inc/01_function.inc.php';
include 'inc/02_head.inc.php';

// Déconnexion utilisateur
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
    session_destroy(); // on deruit la session : l'utilisateur ne sera plus connécter
    header('location: index.php');
    exit();
}

// restriction d'accès : si l'user est connecté, on le redirige vers profil.php
// if(user_is_connected()){
//     header('location: profil.php');
// }

if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {

    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);

    // on declanche une requete sur la base du pseudo
    $connexion  = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $connexion->bindParam(':pseudo', $pseudo, PDO::PARAM_STR) .
        $connexion->execute();

    // si on recup une ligne le pseudo est ok, sinon le pseudo n'existe pas en BDD
    if ($connexion->rowCount() > 0) {
        // pseudo ok, on verifie donc le mdp ->
        $info = $connexion->fetch(PDO::FETCH_ASSOC);

        // ON VERIFIE LE MDP DU FORM AVEC PASSWORD_VERIFY avec celui deja en BDD
        if (password_verify($mdp, $info['mdp'])) {;
            // cette fonction renvoie "true" si les mdp sont les memes, sinon false

            // on stock dans la session les infos user
            // pour ne pas tout melanger, on crée un premier indice "membre" dans la session que sera un sous tableau array contenant les informations.
            $_SESSION['membre'] = array();
            $_SESSION['membre']['id_membre'] = $info['id_membre'];
            $_SESSION['membre']['nom'] = $info['nom'];
            $_SESSION['membre']['prenom'] = $info['prenom'];
            $_SESSION['membre']['pseudo'] = $info['pseudo'];
            $_SESSION['membre']['email'] = $info['email'];
            $_SESSION['membre']['sexe'] = $info['sexe'];
            $_SESSION['membre']['ville'] = $info['ville'];
            $_SESSION['membre']['cp'] = $info['cp'];
            $_SESSION['membre']['statut'] = $info['statut'];
            $_SESSION['membre']['adresse'] = $info['adresse'];

            // l'utilisateur est connecter, on le redirige vers la page profile
            // cette fonction header() doit etre executée AVANT LE MOINDRE AFFICHAGE dans la page
            header('location: profil.php'); // fonction très importante qui permet d'envoyer les differents user dans une page (ici de la page "connexion" à la page "acceuil")

        } else {
            $msg .= '<div class="alert alert-danger mb-2">⚠, Le pseudo ou le mot de passe sont incorrect<br> Veuillez vérifier les champs ci-dessous</div>';
        }
    } else {
        $msg .= '<div class="alert alert-danger mb-2">⚠, Le pseudo ou le mot de passe sont incorrect<br> Veuillez vérifier les champs ci-dessous</div>';
    }
}

// debut des affichage sur la ligne en dessous
include 'inc/03_nav.inc.php';

// echo '<pre>'; echo print_r($_SESSION); echo '</pre>';

?>

<main class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
    <div class="p-3 text-center bg-light w-100">
        <h1 class="text-dark text-center">Connexion <i class="fas fa-sign-in-alt text-dark"></i></h1>
        <p class="lead text-dark">Vous n'avez pas encore de compte ? <a class="text-danger fs-italic" href="inscription.php">Inscivez-vous ici <i class="far fa-arrow-alt-circle-right"></i></a></p>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-12"><?php echo $msg; ?></div> <!-- affichage des msg utilisateur -->
            <div class="col-12">

                <form method="post" action="" class="p-0">
                    <div class="col-sm-4 mx-auto">
                        <div class="mb-3">
                            <label for="pseudo">Pseudo <i class="fas fa-user"></i></label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Votre pseudo" value="">
                        </div>

                        <div class="mb-3">
                            <label for="mdp">Mot de passe</label>
                            <input type="password" name="mdp" id="mdp" class="form-control" placeholder="Mot de passe" value="">
                        </div>

                        <div class="mb-3">
                            <button type="submit" id="inscription" class="btn btn-outline-danger rounded-pill w-100"> Connexion <i class="fas fa-sign-in-alt"></i></button>
                        </div>


                    </div>
            </div>
        </div>
</main>

<?php
include 'inc/06_footer2.inc.php';
?>