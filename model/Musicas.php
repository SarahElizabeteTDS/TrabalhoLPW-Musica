<?php
class Musicas
{
    private $id;
    private $titulo;
    private $genero;
    private $artista;
    private $imagem;
    private $corCard;
    private $linkMusica;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getArtista()
    {
        return $this->artista;
    }

    public function setArtista($artista): self
    {
        $this->artista = $artista;

        return $this;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }

    public function getCorCard()
    {
        return $this->corCard;
    }

    public function setCorCard($corCard): self
    {
        $this->corCard = $corCard;

        return $this;
    }

    public function getLinkMusica()
    {
        return $this->linkMusica;
    }

    public function setLinkMusica($linkMusica): self
    {
        $this->linkMusica = $linkMusica;

        return $this;
    }
}