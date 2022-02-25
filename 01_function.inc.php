<?php

function user_is_connected(){
    if(isset($_SESSION['membre'])){
        return true; // vrai, l'user est connecté
    } else{
        return false; // faux, l'user n'est pas connecté
    }
}

// fonction permettant de savoir si le statut de l'user est "admin"
function user_is_admin(){
    if( user_is_connected() && $_SESSION['membre']['statut'] == 2){ // on demande si l'user est connecté : si oui on veriefie si c'est un admin ou non
        return true; // oui il est connecté et son "statut" en BDD est 2 donc c'est un admin
    }else{
        return false; // oui il est connecter et son statut N'EST PAS egal à 2 en BDD c'est donc un membre
    }
}

// Retourne true si les deux intervalles de dates se supérpose
function date_overlap($startA, $endA, $startB, $endB){
    return ($startA <= $endB) && ($endA >= $startB);
}

// Verifi la validité d'une date
// commentaire sur la page https://www.php.net/manual/fr/function.checkdate.php pour son utilisation
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
