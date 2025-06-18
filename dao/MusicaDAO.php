<?php

require_once(BASE_PATH . "/model/Musica.php");
require_once(BASE_PATH . "/util/Conexao.php");


class MusicaDAO
{
    public function inserirMusicas(Musica $musica)
    {
        $sql = "INSERT INTO musicas (titulo,genero,artista,linkImagem,corCard,linkMusica) VALUES (?, ?, ?, ?, ?, ?)";
        $con = conexao::getConexao();

        $stm = $con->prepare($sql);
        $stm->execute([$musica->getTitulo(),$musica->getGenero(),$musica->getArtista(),$musica->getImagem(),$musica->getCorCard(),$musica->getLinkMusica()]);
    }

    public function listarMusicas()
    {
        $sql = "SELECT * FROM musicas"; 
        $con = conexao::getConexao();

        $stm = $con->prepare($sql);
        $stm->execute();

        $regMusicas = $stm->fetchAll();

        $musicas = self::MapMusicas($regMusicas);

        return $musicas;
    }

    public function buscarPorTituloRepetido($titulo)
    {
        $sqlTitulo = "SELECT id FROM musicas WHERE titulo = ?";
        $con = conexao::getConexao();

        $stm = $con->prepare($sqlTitulo);
        $stm->execute([$titulo]);

        return count($stm->fetchAll());  
    }

    public function excluirMusicasID($id)
    {
        $con = conexao::getConexao();
        
        $sql = "DELETE FROM musicas WHERE id = ?";
        
        $stm = $con->prepare($sql);
        $stm->execute([$id]);
    }

    private function MapMusicas(array $regMusicas) 
    {
        $musicasArray = array();
        
        foreach ($regMusicas as $m) 
        {
            $musicas = null;

            $musicas = new Musica($m['titulo'],$m['genero'],$m['artista'],$m['linkImagem'],$m['corCard'],$m['linkMusica']);
            $musicas->setId($m['id']);

            array_push($musicasArray, $musicas);
        }
        return $musicasArray;
    }

}