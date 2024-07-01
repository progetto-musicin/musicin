<form action="php/processa-new-post.php" method="post" enctype="multipart/form-data">
    <h2>Nuovo Post</h2>
    <div class="form-floating">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Dai un titolo al tuo post" required />
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenuto</label>
            <textarea class="form-control" id="content" name="content" rows="3" cols="50" required></textarea>
        </div>

        <div class="mb-3">
            <label for="attachment" class="form-label">Carica un immagine</label>
            <input class="form-control" type="file" id="attachment" name="attachment" accept="image/jpg, image/jpeg, image/png, image/gif" />
        </div>

        <div class="mb-3">
            <label for="audio" class="form-label">Carica un brano</label>
            <input class="form-control" type="file" id="audio" name="audio" accept="audio/*" />
        </div>

    </div>
    <input class="btn btn-primary" type="submit" value="Pubblica" />
    <input class="btn btn-primary" type="reset" value="Cancella" />
</form>
