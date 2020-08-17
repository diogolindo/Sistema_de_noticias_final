<main>
<h1>Logado como:
<?php
if(isset($_SESSION['nome'])){
    echo $_SESSION['nome'];

?>
</h1>

<a href="<?php echo HOME_URI;?>usuario/edit" class="btn">Editar conta</a>
<a href="<?php echo HOME_URI;?>usuario/dados" class="btn">Dados da conta</a>
<a href="<?php echo HOME_URI;?>usuario/sair" class="btn">Sair</a>
<a href="<?php echo HOME_URI;?>usuario/delete" class="btn">Deletar conta</a>

<table class="table">
<thead>
    <tr><td>#</td><td>Nome</td><td>Email</td><td></td></tr>
</thead>

<?php
if(isset($usuarios)){
    foreach($usuarios AS $usuario){
?>
    <tr><td><?php echo $usuario->id ?></td><td><?php echo $usuario->nome ?><td><?php echo $usuario->email ?></td></td></tr>
<?php
   }
}

?>
</table>
<?php
}
else{
    $this->login();
}
?>
</main>