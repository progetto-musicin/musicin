# Music.in

## Setup di prova

- Inizializzare il DB con il [file SQL apposito](db/creazione_db.sql)
- Nel caso si usi XAMPP, mettere questa cartella con nome `htdocs` al posto di quella già eventualmente presente (o modificare opportunatamente la configurazione apache per puntare a questa cartella).
- Andare su <http://localhost/>

*ATTENZIONE*: per motivi dimostrativi se l'host corrisponde a `localhost` è possibile loggarsi con uno specifico id utente utilizzando il parametro di query `testing`. Per esempio `http://localhost/profile.php?testing=1` permetterà di loggarsi come l'utente con id `1`. Questa funzione può essere rimossa in [bootstrap.php](bootstrap.php).

## Validazione

- HTML: <https://validator.w3.org/>
- Accessibilità: <https://achecker.csr.unibo.it/checker/index.php>
