<?php

//COMO VAMOS USAR DAO, PRECISAMOS FAZER OS SQL EM ARQUIVOS SEPARADOS E RETORNAR METODOS PARA FAZER TUDO
define('BASE_PATH', __DIR__);

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(BASE_PATH . "/model/Musica.php");
require_once(BASE_PATH . "/dao/MusicaDAO.php");

$msgErro = "";
$errosCampos = [];

$titulo = "";
$genero = "";
$artista = "";
$linkImagem = "";
$corCard = "";
$linkMusica = "";

if (isset($_POST["titulo"])) {
    $titulo = trim($_POST["titulo"]);
    $genero = $_POST["genero"];
    $artista = trim($_POST["artista"]);
    $linkImagem = trim($_POST["linkImagem"]);
    $corCard = $_POST["corCard"];
    $linkMusica = trim($_POST["linkMusica"]);

    $musicaDao = new MusicaDAO();

    if (!$titulo) {
        $errosCampos['titulo'] = "Informe o título";
    } elseif (strlen($titulo) < 3) {
        $errosCampos['titulo'] = "Seu título deve ter no mínimo 3 caracteres.";
    } elseif (strlen($titulo) > 50) {
        $errosCampos['titulo'] = "Seu título deve ter no máximo 50 caracteres.";
    } elseif ($musicaDao->buscarPorTituloRepetido($titulo) > 0) {
        $errosCampos['titulo'] = "O título já foi cadastrado na tabela.";
    }

    if (!$genero) {
        $errosCampos['genero'] = "Informe o gênero";
    }

    if (!$corCard) {
        $errosCampos['corCard'] = "Informe a cor do card";
    }

    if (!$artista) {
        $errosCampos['artista'] = "Informe o artista";
    } elseif (strlen($artista) < 3) {
        $errosCampos['artista'] = "O nome do artista deve ter mais de 3 caracteres";
    } elseif (strlen($artista) > 50) {
        $errosCampos['artista'] = "O nome do artista deve ter menos de 50 caracteres";
    }

    if (!$linkImagem) {
        $errosCampos['linkImagem'] = "Informe o link da imagem";
    } elseif (!filter_var($linkImagem, FILTER_VALIDATE_URL)) {
        $errosCampos['linkImagem'] = "Você inseriu um link inválido.";
    }

    if (!$linkMusica) {
        $errosCampos['linkMusica'] = "Informe o link da música";
    } elseif (!filter_var($linkMusica, FILTER_VALIDATE_URL)) {
        $errosCampos['linkMusica'] = "Você inseriu um link inválido.";
    }

    if (count($errosCampos) == 0) {
        $musica = new Musica($titulo, $genero, $artista, $linkImagem, $corCard, $linkMusica);
        $musicaDao->inserirMusicas($musica);
        header("location: Index.php");
    }
}


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Musicas</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<div class="form-e-listagem">

    <div class="form-container">

        <!-- AQUI É A PARTE DO FORMULÁRIO -->
        <h1>Formulário</h1>

            <form action="" method="POST">
        <div>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo"
                value="<?= $titulo ?>"
                class="<?= isset($errosCampos['titulo']) ? 'input-erro' : '' ?>"/>
            <?php if (isset($errosCampos['titulo'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['titulo'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label for="genero">Gênero: </label>
            <select name="genero" id="genero"
                    class="<?= isset($errosCampos['genero']) ? 'input-erro' : '' ?>">
                <option value="">---Selecione---</option>
                <option value="S" <?= $genero == "S" ? "selected" : "" ?>>Sertanejo</option>
                <option value="R" <?= $genero == "R" ? "selected" : "" ?>>Rock</option>
                <option value="G" <?= $genero == "G" ? "selected" : "" ?>>Gospel</option>
                <option value="O" <?= $genero == "O" ? "selected" : "" ?>>Outro</option>
            </select>
            <?php if (isset($errosCampos['genero'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['genero'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label for="artista">Artista: </label>
            <input type="text" name="artista" id="artista"
                value="<?= $artista ?>"
                class="<?= isset($errosCampos['artista']) ? 'input-erro' : '' ?>"/>
            <?php if (isset($errosCampos['artista'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['artista'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label for="linkImagem">Link da Imagem: </label>
            <input type="text" name="linkImagem" id="linkImagem"
                value="<?= $linkImagem ?>"
                class="<?= isset($errosCampos['linkImagem']) ? 'input-erro' : '' ?>"/>
            <?php if (isset($errosCampos['linkImagem'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['linkImagem'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label for="corCard">Cor do Card: </label>
            <select name="corCard" id="corCard"
                    class="<?= isset($errosCampos['corCard']) ? 'input-erro' : '' ?>">
                <option value="">---Selecione---</option>
                <option value="G" <?= $corCard == "G" ? "selected" : "" ?>>Verde</option>
                <option value="R" <?= $corCard == "R" ? "selected" : "" ?>>Vermelho</option>
                <option value="Y" <?= $corCard == "Y" ? "selected" : "" ?>>Amarelo</option>
                <option value="P" <?= $corCard == "P" ? "selected" : "" ?>>Roxo</option>
                <option value="A" <?= $corCard == "A" ? "selected" : "" ?>>Aleatório</option>
            </select>
            <?php if (isset($errosCampos['corCard'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['corCard'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label for="linkMusica">Link da Música: </label>
            <input type="text" name="linkMusica" id="linkMusica"
                value="<?= $linkMusica ?>"
                class="<?= isset($errosCampos['linkMusica']) ? 'input-erro' : '' ?>"/>
            <?php if (isset($errosCampos['linkMusica'])): ?>
                <div class="mensagem-erro"><?= $errosCampos['linkMusica'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <button type="submit">Gravar</button>
        </div>
    </form>

    
        
        <div id="divErro" style="color: red;">
            <?php
                print $msgErro;
            ?>
        </div>

    </div>

    <!-- AQUI É A PARTE DA LISTA -->

    <div class="musica-listada">
        <h1>Listagem</h1>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Artista</th>
                <th>Link da Imagem</th>
                <th>Cor do Card</th>
                <th>Link da Música</th>
                <th>Exclusão</th>
            </tr>

            <?php 
            $musicaDao = new MusicaDAO();
            $arrayMus = $musicaDao->listarMusicas();
            foreach($arrayMus as $mus){
            ?>
                <tr>
                    <td><?= $mus->getId() ?></td>
                    <td><?= $mus->getTitulo() ?></td>
                    <td><?= $mus->getGeneroDetalhado() ?></td>
                    <td><?= $mus->getArtista() ?></td>
                    <td><a href="<?= $mus->getImagem() ?>">Link da Imagem</a></td>
                    <td><?= $mus->getCorCardDetalhado()?></td> 
                    <td><a href="<?= $mus->getLinkMusica() ?>">Link da Música</a></td>
                    <td>
                        <a href="Excluir.php?id=<?= $mus->getId()?>" 
                            onclick="return confirm('Confirma a exclusão?');">
                            Excluir</a>
                    </td>
                </tr>
            <?php }?> 
            <!-- end do foreach -->
        </table>
        <a href="Cards.php" class="ver-cards">Cards</a>

    </div>

</div>

</body>
</html>
