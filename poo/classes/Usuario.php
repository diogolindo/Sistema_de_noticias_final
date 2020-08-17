<?php
class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;

    /**
    * Método index que leva à página de login ou listar
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function index(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            $this->listar();
        }
    }

    /**
    * Método que lista todos os usuário que há no banco de dados
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function listar(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            $conexao=Conexao::getConexao();
            $resultado=$conexao->query(
                "SELECT id, nome, email FROM usuario"
            );
            $usuarios=null;
            while($usuario=$resultado->fetch(PDO::FETCH_OBJ)){
                $usuarios[]=$usuario;
            }
            include HOME_DIR."view/paginas/usuarios/listar.php";
        }
    }

    /**
    * Método que leva à tela de cadastro
    * @author Caândido Farias
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function criar(){
        include HOME_DIR."view/paginas/usuarios/form_usuario.php";
    }

    /**
    * Método que salva o novo usuário no banco de dados
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function salvar(){
        if(isset($_POST["enviar"])){
            /*testa se é novo usuário*/
            if(empty($_POST["id"])){
                $obj = new Usuario;

                $obj->setNome($_POST["nome"]);
                $obj->setEmail($_POST["email"]);
                $senhaForm = md5("info123");
                $obj->setSenha($senhaForm);

                //salva no bd pela classe conexao
                $conexao=Conexao::getConexao();
                $sql="INSERT INTO usuario (nome, email, senha) VALUES ('".$obj->getNome()."', '".$obj->getEmail()."', '".$obj->getSenha()."')";
                $conexao->query($sql);

                //mensagem se deu certo (usuário salvo no bd)
                $sql = $conexao->query("
                SELECT id
                FROM usuario
                WHERE email = '".$obj->getEmail()."' AND nome = '".$obj->getNome()."' AND senha = '".$obj->getSenha()."'"
                );
                $result = $sql->fetch(PDO::FETCH_OBJ);
                if(is_string($result->id)){
                    echo "<h2>Novo usuário salvo com sucesso!</h2>";
                }
                else{
                    echo "<h2>Falha ao salvar novo usuário!</h2>";
                }
                include HOME_DIR."view/paginas/usuarios/login.php";
            }else{
                $sql="UPDATE usuario SET nome=".$_POST["nome"].", email=".$_POST["email"];
            }
        }
    }

    /**
    * Método que leva à tela de login
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function login(){
        include HOME_DIR."view/paginas/usuarios/login.php";
    }

    public function primeiro(){
        if(isset($_POST["enviar"])){
            $senha = md5($_POST["senha"]);
            $id = $_SESSION['id'];
            $conexao=Conexao::getConexao();
            $conexao->query("
                UPDATE usuario
                SET senha = '".$senha."'
                WHERE id = '".$id."'"
            );
            
            $this->listar();
        }
    }

    /**
    * Método que avalia os dados repassados e loga ou não
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function entrar(){
        if(isset($_POST["enviar"])){
            $obj = new Usuario;
            $obj->setNome($_POST["nome"]);
            $obj->setEmail($_POST["email"]);

            //conecta e procura se há conta com os dados
            $conexao=Conexao::getConexao();
            $sql = $conexao->query("
                SELECT *
                FROM usuario
                WHERE email = '".$obj->getEmail()."' AND nome = '".$obj->getNome()."'"
            );
            $result = $sql->fetch(PDO::FETCH_OBJ);
            
            //se há conta
            if(isset($result->id) && isset($result->nome) && isset($result->senha) && isset($result->email)){
                //se for primeiro acesso
                if($result->senha == md5("info123")){
                    echo "passou";
                    include HOME_DIR."view/paginas/usuarios/primeiroAcesso.php";
                    $this->session($result->id, $result->nome, $result->email);
                }
                else{
                    include HOME_DIR."view/paginas/usuarios/loginSenha.php";
                    $this->session($result->id, $result->nome, $result->email);
                }
            }
            else{
                echo "<h2>Dados repassados inválidos!</h2>";
                $this->login();
            }
        }
    }

    /**
    * Método que recebe a senha do login e verifica ela
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 14/08/2020
    */
    public function loginSenha(){
        if(isset($_POST["enviar"])){
            $senha = md5($_POST["senha"]);
            $id = $_SESSION['id'];
            $conexao=Conexao::getConexao();
            $sql = $conexao->query("
                SELECT id
                FROM usuario
                WHERE email = '".$_SESSION['email']."' AND nome = '".$_SESSION['nome']."' AND senha ='".$senha."'"
            );
            $result = $sql->fetch(PDO::FETCH_OBJ);
            if(isset($result->id) && $result->id == $id){
                $this->listar();
            }
            else{
                echo "<h2>Senha repassada inválida!</h2>";
                include HOME_DIR."view/paginas/usuarios/loginSenha.php";
            }
            
        }
    }

    /**
    * Método que salva o usuário logado em sessões
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function session($id, $nome, $email){
        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;

        /*if($_SESSION['id'] == null){
            $this->login();
        }else{
            $this->listar();
        }*/
    }

    /**
    * Método que leva à tela de editar o usuário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function edit(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            include HOME_DIR."view/paginas/usuarios/editar.php";
        }
    }

    /**
    * Método que atualiza/update no usuário no banco
    * @author Diogo Krupp
    * @version 0.2
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function update(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            if(isset($_POST["enviar"])){
                $obj = new Usuario;
                $obj->setSenha(md5($_POST["senha"]));
                $obj->setEmail($_POST["email"]);
                $obj->setNome($_POST["nome"]);
                $obj->setId($_SESSION['id']);
    
                $conexao=Conexao::getConexao();
                $conexao->query("
                    UPDATE usuario
                    SET nome = '".$obj->getNome()."', email = '".$obj->getEmail()."', senha = '".$obj->getSenha()."'
                    WHERE id = '".$obj->getId()."'"
                );
                
                $_SESSION['senha'] = $_POST["senha"];
                $_SESSION['email'] = $_POST["email"];
                $_SESSION['nome'] = $_POST["nome"];
                
                echo "<h2>Usuário atualizado com sucesso!</h2>";
                $this->listar();
            }
        }
    }

    /**
    * Método que leva á página de dados da conta
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function dados(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            include HOME_DIR."view/paginas/usuarios/dados.php";
        }
    }

    /**
    * Método que desloga o usuário
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function sair(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            session_unset();
            session_destroy();
            echo "<h2>Deslogado!</h2>";
            include HOME_DIR."view/paginas/usuarios/login.php";
        }
    }

    /**
    * Método que deleta conta do banco de dados e desloga
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function delete(){
        if(!isset($_SESSION['id'])){
            $this->login();
        }
        else{
            $conexao=Conexao::getConexao();
            $conexao->query("
                DELETE FROM usuario
                WHERE id = '".$_SESSION['id']."'"
            );
            session_unset();
            session_destroy();
            echo "<h2>Conta deletada!</h2>";
            include HOME_DIR."view/paginas/usuarios/login.php";
        }
    }


    //-------------------------------------------------------------GETTERS & SETTERS
    /**
    * Método que salva o ID
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
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
    * @since 28/07/2020
    * @return $id
    */
    public function getId(){
        return $this->id;
    }

    /**
    * Método que salva o nome
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function setNome($nome){
        $this->nome=$nome;
    }
    
    /**
    * Método que retorna o nome
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    * @return $nome
    */
    public function getNome(){
        return $this->nome;
    }

    /**
    * Método que salva o email
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function setEmail($email){
        $this->email=$email;
    }
    
    /**
    * Método que retorna o email
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    * @return $email
    */
    public function getEmail(){
        return $this->email;
    }

    /**
    * Método que salva a senha
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    */
    public function setSenha($senha){
        $this->senha=$senha;
    }
    
    /**
    * Método que retorna a senha
    * @author Diogo Krupp
    * @version 0.1
    * @access public
    * @copyright GPL 2020, Info63a
    * @since 28/07/2020
    * @return $senha
    */
    public function getSenha(){
        return $this->senha;
    }

}