<?php

//COMO VAMOS USAR DAO, PRECISAMOS FAZER OS SQL EM ARQUIVOS SEPARADOS E RETORNAR METODOS PARA FAZER TUDO

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("util/Conexao.php");
require_once("model/Musicas.php");

$con = Conexao::getConexao();

$sql = "SELECT * FROM musicas"; 
$stm = $con->prepare($sql);
$stm->execute();
$musica = $stm->fetchAll();
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

    //referente ao titulo
    if(!$titulo)
    {
        array_push($erros,"Informe o titulo");
    }elseif (strlen($titulo) < 5) 
    {
        array_push($erros,"Seu título deve ter no mínimo 5 caracteres.");
    }elseif (strlen($titulo) > 50) 
    {
        array_push($erros,"Seu título deve ter no máximo 50 caracteres.");
    }else
    {
        $sqlTitulo = "SELECT id FROM musicas WHERE titulo = ?";
        $stm = $con->prepare($sqlTitulo);
        $stm->execute([$titulo]);
        $qtdTitulos = count($stm->fetchAll());
        if ($qtdTitulos > 0) 
        {
            array_push($erros,"Seu título deve ser único.");
        }
    }

    //referente ao genero
    if(!$genero)
    {
        array_push($erros,"Informe o gênero");
    }

    //referente ao artista
    if(!$artista)
    {
        array_push($erros,"Informe o artista");
    }

    //referente ao linkImagem
    if(!$linkImagem)
    {
        array_push($erros,"Informe o link da imagem");
    }

    //referente ao corCard
    if(!$corCard)
    {
        array_push($erros,"Informe o link da imagem");
    }

    //referente ao linkMusica
    if(!$linkMusica)
    {
        array_push($erros,"Informe o link da música");
    }

    //se nao cair em nenhum
    if(count($erros) == 0)
    {
        //Inserir as informações na base de dados
        $sql = "INSERT INTO musicas (titulo,genero,artista,linkImagem,corCard,linkMusica) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $stm = $con->prepare($sql);
        $stm->execute([$titulo,$genero,$artista,$linkImagem,$corCard,$linkMusica]);

        //Redirecionar para a mesma página a fim de limpar o buffer do navegodor
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
                <option value="D" <?=$genero == "S"?"selected":""?>>Sertanejo</option>
                <option value="F"<?=$genero == "R"?"selected":""?>>Rock</option>
                <option value="R"<?=$genero == "G"?"selected":""?>>Gospel</option>
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
                <option value="D" <?=$corCard == "G"?"selected":""?>>Verde</option>
                <option value="F"<?=$corCard == "R"?"selected":""?>>Vermelho</option>
                <option value="R"<?=$corCard == "Y"?"selected":""?>>Amarelo</option>
                <option value="O"<?=$corCard == "P"?"selected":""?>>Roxo</option>
                <option value="O"<?=$corCard == "A"?"selected":""?>>Aleatório</option>
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
        </tr>

        <?php foreach($musica as $m): ?>
            <tr>
                <td><?= $m["id"] ?></td>
                <td><?= $m["titulo"] ?></td>
                <td>
                    <?php 
                        if($m["genero"] == 'S')
                            print "Sertanejo";
                        else if($m["genero"] == 'R') 
                            print "Rock";
                        else if($m["genero"] == 'G') 
                            print "Gospel";
                        else
                            print "Outro";
                    ?>
                </td>
                <td><?= $m["artista"] ?></td>
                <td><a href="<?= $m['linkImagem'] ?>">Link da Imagem</a></td>
                <td>
                    <?php 
                        if($m["corCard"] == 'G')
                            print "Verde";
                        else if($m["corCard"] == 'R') 
                            print "Vermelho";
                        else if($m["corCard"] == 'Y') 
                            print "Amarelo";
                        else if($m["corCard"] == 'P') 
                            print "Roxo";
                        else if($m["corCard"] == 'B') 
                            print "Azul";
                        else
                            print "Aleatório";
                    ?>
                </td> 
                <td><a href="<?= $m['linkMusica'] ?>">Link da Música</a></td>
            </tr>
        <?php endforeach; ?>
    
</body>
</html>