<form action="php/processa-new-post.php" method="post" enctype="multipart/form-data">
    <h2>Nuovo Post</h2>
    <ul>
        <li>
            <label for="title">Titolo:</label>
            <input type="text" id="title" name="title">
        </li>
        <li>
            <label for="content">Contenuto:</label>
            <textarea id="content" name="content" rows="5" cols="50"></textarea>
        </li>
        <li>
            <label for="attachment">Carica un'immagine:</label>
            <input type="file" accept="image/jpg, image/jpeg, image/png, image/gif" id="attachment" name="attachment">
        </li>
        <li>
            <label for="audio">Carica un brano audio:</label>
            <input type="file" accept="audio/*" id="audio" name="audio">
        </li>
    </ul>
    <input type="submit" value="Invia" />
    <input type="reset" value="Cancella" />
</form>