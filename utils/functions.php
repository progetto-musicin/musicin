<?php

function getCurrentUserId() {
    return $_SESSION["user_id"];
}

function isUserLoggedIn() {
    // return isset($_SESSION["user_id"]);
    return !empty(getCurrentUserId());
}

// Funzione per caricare un'immagine in una cartella
// Parametri:
// - $path: percorso della cartella in cui caricare l'immagine
// - $image
// Restituisce un array con due elementi:
// - $result: 1 se l'upload è andato a buon fine, 0 altrimenti
// - $msg: messaggio di errore se l'upload non è andato a buon fine, nome dell'immagine caricata altrimenti
function uploadImage($path, $image) {
    $imageName = basename($image["name"]);
    $fullPath = $path.$imageName;

    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";

    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if ($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $acceptedExtensions)) {
        $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do {
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME)."_$i.".$imageFileType;
        } while(file_exists($path.$imageName));
        $fullPath = $path.$imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if (strlen($msg)==0) {
        if (!move_uploaded_file($image["tmp_name"], $fullPath)) {
            $msg.= "Errore nel caricamento dell'immagine.";
        } else{
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

// Restituisce il numero di follower dell'utente con l'id passato come parametro
function getNumFollowers($user_id) {
    return -1;
}

// Restituisce il numero di utenti seguiti dall'utente con l'id passato come parametro
function getNumFollowing($user_id) {
    return -1;
}

// Restituisce il numero di like del post con l'id passato come parametro
function getPostLikes($post_id) {
    return -1;
}

?>