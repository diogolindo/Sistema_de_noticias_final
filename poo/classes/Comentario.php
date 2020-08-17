<?php

class Comentario{
    private $id;
    private $comentario;
    private $data;
    private $noticia;
    private $usuario;

    /**
    * Método que recebe comentário de usuário e salva no banco
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 15/08/2020
    */
    public function salvar(){
        if(isset($_POST['enviar'])){
            $comentario = $_POST['comentario'];
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];
                $conexao=Conexao::getConexao();
                $resultado=$conexao->query(
                    "SELECT nome
                    FROM usuario
                    WHERE id=".$id
                );
                $result=$resultado->fetch(PDO::FETCH_OBJ);
                $nome = $result->nome;
            }
            else{
                $nome = "Usuário visitante";
            }

            $not_id = $_SESSION['not_id'];

            $conexao->query("SET FOREIGN_KEY_CHECKS=0");
            $resultado=$conexao->query("
                INSERT INTO comentario
                (comentario, nome, noticia_id) VALUES
                ('".$comentario."', '".$nome."', '".$not_id."')"
            );
            $conexao->query("SET FOREIGN_KEY_CHECKS=1");

            $this->ver($not_id);
        }
    }
    
    /**
    * Método
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 15/08/2020
    */
    public  function ver($id){
        $conexao=Conexao::getConexao();
        $resultado=$conexao->query(
            "SELECT id, titulo, descricao, DATE_FORMAT(data, '%d/%m/%Y') AS data,
             (SELECT nome FROM usuario WHERE id=noticia.usuario_id) AS nome_usuario,
             (SELECT id FROM usuario WHERE id=noticia.usuario_id) AS id_usuario
             FROM noticia  
             WHERE id=".$id
        );
        $noticia=$resultado->fetch(PDO::FETCH_OBJ);

        $resultado=$conexao->query(
            "SELECT comentario, nome, id
             FROM comentario  
             WHERE noticia_id=".$id
        );
        $coments = null;
        while($coment=$resultado->fetch(PDO::FETCH_OBJ)){
            $coments[]=$coment;
        }
        include HOME_DIR."view/paginas/noticias/noticia.php";
    }

    
    //-------------------------------------------SETTERS E GETTERS
    /**
    * Método que salva o ID
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    */
    public function setId($id){
        $this->id=$id;
    }
    
    /**
    * Método que retorna o ID
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    * @return $id
    */
    public function getId(){
        return $this->id;
    }

    /**
    * Método que salva o comentário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    */
    public function setComentario($comentario){
        $this->comentario=$comentario;
    }
    
    /**
    * Método que retorna o comentário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    * @return $comentario
    */
    public function getComentario(){
        return $this->comentario;
    }

    /**
    * Método que salva o ID da notícia
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    */
    public function setNoticia($noticia){
        $this->noticia=$noticia;
    }
    
    /**
    * Método que retorna o ID da notícia
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    * @return $noticia
    */
    public function getNoticia(){
        return $this->noticia;
    }

    /**
    * Método que salva o nome do usuário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    */
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    /**
    * Método que retorna o nome do usuário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 16/07/2020
    * @return $usuario
    */
    public function getUsuario(){
        return $this->usuario;
    }

}