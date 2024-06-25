<?php

function getCurrentUserId() {
    return $_SESSION["user_id"];
}

function isUserLoggedIn() {
    // return isset($_SESSION["user_id"]);
    return !empty(getCurrentUserId());
}

function uploadFile($path, $file, $acceptedExtensions, $maxKB = 5000) {
    $fileName = basename($file["name"]);
    $fullPath = $path.$fileName;
    $result = 0;
    $msg = "";

    //Controllo dimensione dell'immagine < 500KB
    if ($file["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    if (!empty($acceptedExtensions)) {
        $fileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
        if (!in_array($fileType, $acceptedExtensions)) {
            $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
        }
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do {
            $i++;
            $fileName = pathinfo(basename($file["name"]), PATHINFO_FILENAME)."_$i.".$fileType;
        } while(file_exists($path.$fileName));
        $fullPath = $path.$fileName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if (strlen($msg)==0) {
        if (!move_uploaded_file($file["tmp_name"], $fullPath)) {
            $msg.= "Errore nel caricamento dell'immagine.";
        } else{
            $result = 1;
            $msg = $fileName;
        }
    }
    return array($result, $msg);
}

// Funzione per caricare un'immagine in una cartella
// Parametri:
// - $path: percorso della cartella in cui caricare l'immagine
// - $image
// Restituisce un array con due elementi:
// - $result: 1 se l'upload è andato a buon fine, 0 altrimenti
// - $msg: messaggio di errore se l'upload non è andato a buon fine, nome dell'immagine caricata altrimenti
function uploadImage($path, $image) {
    $result = 0;
    $msg = "";

    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if ($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
        return array($result, $msg);
    }

    return uploadFile($path, $image, array("jpg", "jpeg", "png", "gif"));
}

function uploadSong($path, $song) {
    return uploadFile($path, $song, array(), 10000);
}

?>