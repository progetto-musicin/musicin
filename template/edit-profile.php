<section>
    <h2>Modifica Profilo</h2>
    <form action="php/processa-profile.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
      
            <label for="surname" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>">
       
            <label for="image" class="form-label">Immagine Profilo</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>
        
        <?php if ($user['profile_image']): ?>
            <img src="<?php echo UPLOAD_DIR . htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo" style="width: 100px; height: auto;"><br>
        <?php endif; ?>

        <!-- Selezione del genere musicale preferito -->
        <label for="genre" class="form-label">Genere Musicale Preferito:</label>
        <select class="form-select" id="genre" name="genre">
            <option value="">Nessun genere selezionato</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?php echo $genre['id']; ?>"<?php if ($user['genre_id'] == $genre['id']) echo htmlspecialchars('selected'); ?>><?php echo htmlspecialchars($genre['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <input class="btn btn-primary" type="submit" value="Aggiorna Profilo">
    </form>
</section>






