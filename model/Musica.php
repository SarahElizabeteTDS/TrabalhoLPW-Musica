<?php
class Musica
{
    private $id;
    private $titulo;
    private $genero;
    private $artista;
    private $imagem;
    private $corCard;
    private $linkMusica;

    //construct
    public function __construct($t,$g,$a,$im,$c,$l)
    {
        $this->titulo = $t;
        $this->genero = $g;
        $this->artista = $a;
        $this->imagem = $im;
        $this->corCard = $c;
        $this->linkMusica = $l;
    }


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

    public function getGeneroDetalhado() 
    {
        if($this->genero == 'S')
            return "Sertanejo";
        else if($this->genero == 'R') 
            return "Rock";
        else if($this->genero == 'G') 
            return "Gospel";
        else
            return "Outro";
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

    public function getCorCardDetalhado()
    {
        $cores = array();
        $cores = ["Green", "Red", "Yellow", "Purple", "Blue"];

        if($this->corCard == 'G')
            return "Green";
        else if($this->corCard == 'R') 
            return "Red";
        else if($this->corCard == 'Y') 
            return "Yellow";
        else if($this->corCard == 'P') 
            return "Purple";
        else if($this->corCard == 'B') 
            return "Blue";
        else
            return $cores[sort($cores)];
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