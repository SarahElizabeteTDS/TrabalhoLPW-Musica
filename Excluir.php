<?php

define('BASE_PATH', __DIR__);

require_once(BASE_PATH . "/dao/MusicaDAO.php");

$musicaDao = new MusicaDAO();

$excluido = $_GET['id'];

$musicaDao->excluirMusicasID($excluido);

header("location: Index.php");
