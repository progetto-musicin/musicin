<section>
    <h2>Modifica Profilo</h2>
    <form action="php/processa-profile.php" method="post" enctype="multipart/form-data">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

        <label for="surname">Cognome:</label>
        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required><br>

        <label for="image">Immagine Profilo:</label>
        <input type="file" id="image" name="image"><br>
        <?php if ($user['profile_image']): ?>
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo" style="width: 100px; height: auto;"><br>
        <?php endif; ?>

        <!-- Selezione del genere musicale preferito -->
        <label for="genre">Genere Musicale Preferito:</label>
        <select id="genre" name="genre">
            <?php foreach ($genres as $genre): ?>
                <option value="<?php echo $genre['id']; ?>"<?php if ($user['genre_id'] == $genre['id']) echo htmlspecialchars('selected="selected"'); ?>><?php echo htmlspecialchars($genre['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" name="submit" value="Aggiorna Profilo">
    </form>
</section>