<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    
    <h1 class="titulo-cards">Cards</h1>
    <div class="container-cards">
        <?php
            define('BASE_PATH', __DIR__);

            require_once(BASE_PATH . "/dao/MusicaDAO.php");

            $musicaDao = new MusicaDAO();
            $arrayMus = $musicaDao->listarMusicas();

            foreach($arrayMus as $mus)
            {?>
                <div class="card" style="background: linear-gradient(145deg, <?= $mus->getCorCardDetalhado() ?>, #1e1e1e);">
                    <img src="<?= $mus->getImagem() ?>" alt="Imagem da música">
                    <h2>Título: <?= $mus->getTitulo() ?></h2>
                    <p>ID: <?= $mus->getId() ?></p>
                    <p>Gênero: <?= $mus->getGeneroDetalhado() ?></p>
                    <p>Artista: <?= $mus->getArtista() ?></p>
                    <a href="<?= $mus->getLinkMusica() ?>">Link da Música</a>
                </div>  
                
            <?php 
            } //FIM DO FOREACH 

        ?>

    </div>
</body>
</html>
