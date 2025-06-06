<?php

class Conexao
{
    private static $con = NULL;

    public static function getConexao()
    {
        if (self::$con == null) 
        {
            $opcoes = array
            (
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            self::$con = new PDO("mysql:host=localhost:3306;dbname=CardMusical","root", "bancodedados", $opcoes);//info deve ser alterada conforme o necessário.
        }

        return self::$con; 
    }
}