<?php
class Noticia{
    private $id;
    private $titulo;
    private $descricao;
    private $comentarios;
    private $data;
    private $usuario;

    /**
    * Método index que chama método listar
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function index(){
        $this->listar();
     }
    
    /**
    * Método que lista todas notícias existentes no banco de dados
    * @author Cândido Farias
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function listar(){
        $conexao=Conexao::getConexao();
        $resultado=$conexao->query(
            "SELECT id, titulo, descricao,DATE_FORMAT(data, '%d/%m/%Y') AS data,
            (SELECT nome FROM usuario WHERE id=noticia.usuario_id) AS nome_usuario FROM noticia ORDER BY id DESC"
        );
        
        $noticias=null;
        while($noticia=$resultado->fetch(PDO::FETCH_OBJ)){
            $noticias[]=$noticia;
        }
        include HOME_DIR."view/paginas/noticias/noticias.php";
    }

    /**
    * Método que salva nova notícia no banco de dados
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public  function salvar(){
        if(isset($_POST['enviar'])){
            if(isset($_SESSION['id'])){
                $titulo = $_POST["titulo"];
                $descricao = $_POST["descricao"];
                $data = date('Y/m/d');
                $id = $_SESSION['id'];
                
                $conexao=Conexao::getConexao();
                $conexao->query("SET FOREIGN_KEY_CHECKS=0");
                $conexao->query("
                    INSERT INTO noticia
                    (usuario_id, titulo, descricao, data) VALUES
                    ('".$id."', '".$titulo."', '".$descricao."', '".$data."')"
                );
                $conexao->query("SET FOREIGN_KEY_CHECKS=1");
                echo "<h2>Notícia salva com sucesso!</h2>";
                $this->listar();
            }
            else{
                include HOME_DIR."view/paginas/usuarios/login.php";
            }
        }
    }

    /**
    * Método que leva à página de criação de uma nova notícia
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public  function nova(){
        if(isset($_SESSION['id'])){
            include HOME_DIR."view/paginas/noticias/criar.php";
        }else{
            echo "<h2>Para criar uma notícia, faça login primeiro</h2>";
            include HOME_DIR."view/paginas/usuarios/login.php";
        }
    }

    /**
    * Método que abre a notícia desejada
    * @author Cândido Farias
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public  function ver($id){
        $_SESSION['not_id'] = $id;
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

    /**
    * ...
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public  function delete(){
        $id = $_SESSION['not_id'];
        $conexao=Conexao::getConexao();
        $conexao->query("SET FOREIGN_KEY_CHECKS=0");
        $conexao->query("
            DELETE FROM noticia
            WHERE id = '".$id."'"
        );
        $conexao->query("SET FOREIGN_KEY_CHECKS=1");
        echo "<h2>Notícia excluída!</h2>";
        $this->listar();
    }

    /**
    * Método que leva á página de update de notícias
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public function update(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            include HOME_DIR."view/paginas/noticias/editar.php";
        }
    }

    /**
    * Método que recebe valores do formulário e faz update em uma notícia
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public function editar(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            if(isset($_POST['enviar'])){
                $id = $_SESSION['not_id'];
                $titulo = $_POST['titulo'];
                $descricao = $_POST['descricao'];
                $conexao=Conexao::getConexao();
                $conexao->query("SET FOREIGN_KEY_CHECKS=0");
                $conexao->query("
                    UPDATE noticia
                    SET titulo = '".$titulo."', descricao = '".$descricao."'
                    WHERE id = '".$id."'"
                );
                $conexao->query("SET FOREIGN_KEY_CHECKS=1");
                
                echo "<h2>Notícia atualizada com sucesso!</h2>";
                $this->ver($id);
            }
        }
    }


    //-----------------------------------------SETTERS E GETTERS
    /**
    * Método que salva o ID
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
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
    * @since 23/07/2020
    * @return $id
    */
    public function getId(){
        return $this->id;
    }

    /**
    * Método que salva o título
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function setTitulo($titulo){
        $this->titulo=$titulo;
    }
    
    /**
    * Método que retorna o título
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    * @return $titulo
    */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
    * Método que salva a descrição
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function setDescricao($descricao){
        $this->descricao=$descricao;
    }
    
    /**
    * Método que retorna a descrição
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    * @return $descricao
    */
    public function getDescricao(){
        return $this->descricao;
    }

    /**
    * Método que salva o ID dos comentários
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function setComentarios($comentarios){
        $this->comentarios=$comentarios;
    }
    
    /**
    * Método que retorna o ID do comentário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    * @return $comentarios
    */
    public function getComentarios(){
        return $this->comentarios;
    }

    /**
    * Método que salva a data
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function setData($data){
        $this->data=$data;
    }
    
    /**
    * Método que retorna a data
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    * @return $data
    */
    public function getData(){
        return $this->data;
    }

    /**
    * Método que salva o usuário que fez a notícia
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    */
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    /**
    * Método que returna o usuário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 23/07/2020
    * @return $usuario
    */
    public function getUsuario(){
        return $this->usuario;
    }

}


?>