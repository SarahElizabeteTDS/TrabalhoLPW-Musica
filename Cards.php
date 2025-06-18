<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    
    <h1>Cards</h1>
    <div class="container">
        <?php
            define('BASE_PATH', __DIR__);

            require_once(BASE_PATH . "/dao/MusicaDAO.php");

            $musicaDao = new MusicaDAO();
            $arrayMus = $musicaDao->listarMusicas();

            foreach($arrayMus as $mus)
            {?>
                <div class="card" style="background-color: <?= $mus->getCorCardDetalhado()?>;">
                    <img src="<?= $mus->getImagem() ?>" alt="Imagem da música">
                    <h2>Título: <?= $mus->getTitulo() ?></h2>
                    <p>Id: <?= $mus->getId() ?></p>
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