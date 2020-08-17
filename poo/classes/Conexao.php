<?php
class Conexao {
    //PARÂMETROS:
    //("mysql:host=localhost;dbname=sistema_noticias", "root", "vertrigo")

    /**
     * Método estático que retorna um objeto de conexão com banco de dados
     * @author Diogo Krupp
     * @version 0.1
     * @access public
     * @copyright GPL 2020, Info63a
     * @since 23/07/2020
     */
    static public function getConexao(){
        return new PDO (SGBD.":host=".HOST_DB.";dbname=".DB."",USER_DB, PASS_DB);
    }

}