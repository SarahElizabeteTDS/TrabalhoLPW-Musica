<?php

//COMO VAMOS USAR DAO, PRECISAMOS FAZER OS SQL EM ARQUIVOS SEPARADOS E RETORNAR METODOS PARA FAZER TUDO
define('BASE_PATH', __DIR__);

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(BASE_PATH . "/model/Musica.php");
require_once(BASE_PATH . "/dao/MusicaDAO.php");

$msgErro = "";

$titulo = "";
$genero = "";
$artista = "";
$linkImagem = "";
$corCard = "";
$linkMusica = "";

//fazer mais verificacoes em cada um
if(isset($_POST["titulo"]) || isset($_POST["genero"]) || isset($_POST["artista"]) || isset($_POST["linkImagem"]) || isset($_POST["corCard"]) || isset($_POST["linkMusica"]))
{
    $titulo = trim($_POST["titulo"]);
    $genero = $_POST["genero"];
    $artista = trim($_POST["artista"]);
    $linkImagem = trim($_POST["linkImagem"]);
    $corCard = $_POST["corCard"];
    $linkMusica = trim($_POST["linkMusica"]);

    $erros = array();
    $musicaDao = new MusicaDAO();

    //referente ao titulo
    if(!$titulo)
    {
        array_push($erros,"Informe o titulo");
    }elseif (strlen($titulo) < 3) 
    {
        array_push($erros,"Seu título deve ter no mínimo 3 caracteres.");
    }elseif (strlen($titulo) > 50) 
    {
        array_push($erros,"Seu título deve ter no máximo 50 caracteres.");
    }elseif ($musicaDao->buscarPorTituloRepetido($titulo) > 0)
    {
        array_push($erros, "O título já foi cadastrado na tabela.");  
    }

    //referente ao genero, como é um select, nao vimos necessidade de colocar mais verificacoes
    if(!$genero)
    {
        array_push($erros,"Informe o gênero");
    }

    //referente ao corCard, como é um select, resolvemos deixar somente com uma verificacao
    if(!$corCard)
    {
        array_push($erros,"Informe a cor do card");
    }

    //referente ao artista
    if(!$artista)
    {
        array_push($erros,"Informe o artista");
    }elseif (strlen($artista) < 3) 
    {
        array_push($erros,"O nome do artista deve ter mais de 3 caracteres");
    }elseif(strlen($artista) > 50)
    {
        array_push($erros,"O nome do artista deve ter menos de 50 caracteres");
    }
      
    //referente ao linkImagem
    if(!$linkImagem)
    {
        array_push($erros,"Informe o link da imagem");
    }elseif (!filter_var($linkImagem, FILTER_VALIDATE_URL))
    {
        array_push($erros, "Você inseriu um link inválido.");
    }

    //referente ao linkMusica
    if(!$linkMusica)
    {
        array_push($erros,"Informe o link da música");
    }elseif (!filter_var($linkMusica, FILTER_VALIDATE_URL)) 
    {
        array_push($erros, "Você inseriu um link inválido.");
    }

    //se nao cair em nenhum
    if(count($erros) == 0)
    {
        $musica = new Musica($titulo,$genero,$artista,$linkImagem,$corCard,$linkMusica);
        $musicaDao->inserirMusicas($musica);

        //limpa o buffer do navegador
        header("location: Index.php");
    }else
    {
        $msgErro = implode("<br>", $erros);
        //arrumar isso para aparecer bonito no HTML, provavel arrumar com CSS
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

    <!-- AQUI É A PARTE DO FORMULÁRIO -->
    <h1>Formulário</h1>

    <form action="" method="POST">
        <div style="margin-bottom: 10px;">
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" value="<?= $titulo ?>"/>
        </div>


        <div style="margin-bottom: 10px;">
            <label for="genero">Gênero: </label>
            <select name="genero" id="genero">
                <option value="">---Selecione---</option>
                <option value="S" <?=$genero == "S"?"selected":""?>>Sertanejo</option>
                <option value="R"<?=$genero == "R"?"selected":""?>>Rock</option>
                <option value="G"<?=$genero == "G"?"selected":""?>>Gospel</option>
                <option value="O"<?=$genero == "O"?"selected":""?>>Outro</option>
            </select>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="artista">Artista: </label>
            <input type="text" name="artista" id="artista" value="<?= $artista ?>"/>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="linkImagem">Link da Imagem: </label>
            <input type="text" name="linkImagem" id="linkImagem" value="<?= $linkImagem ?>"/>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="corCard">Cor do Card: </label>
            <select name="corCard" id="corCard">
                <option value="">---Selecione---</option>
                <option value="G" <?=$corCard == "G"?"selected":""?>>Verde</option>
                <option value="R"<?=$corCard == "R"?"selected":""?>>Vermelho</option>
                <option value="Y"<?=$corCard == "Y"?"selected":""?>>Amarelo</option>
                <option value="P"<?=$corCard == "P"?"selected":""?>>Roxo</option>
                <option value="A"<?=$corCard == "A"?"selected":""?>>Aleatório</option>
            </select>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="linkMusica">Link da Musica: </label>
            <input type="text" name="linkMusica" id="linkMusica" value="<?= $linkMusica ?>"/>
        </div>

        <div style="margin-bottom: 10px;">
            <button type="submit">Gravar</button>
        </div>
    </form>
   
    
    <div id="divErro" style="color: red;">
        <?php
            print $msgErro;
        ?>
    </div>

    <!-- AQUI É A PARTE DA LISTA -->
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
    <a href="Cards.php">Cards</a>
</body>
</html>