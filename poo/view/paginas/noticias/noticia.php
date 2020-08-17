<html>
<main>

<?php
    
    if(isset($_SESSION['id'])){
        if($_SESSION['id'] == $noticia->id_usuario){
            $_SESSION['not_id'] = $noticia->id;
            ?>
                <a href="<?php echo HOME_URI;?>noticia/update" class=btn>Editar notícia</a>
                <a href="<?php echo HOME_URI;?>noticia/delete" class=btn>Deletar notícia</a>
            <?php
        }
    }

?>

<div class="panel-heading"><h1>Notícias</h1></div>
<div class="panel panel-primary">

<div class="panel-heading"><h1><?php echo $noticia->titulo ?></h1></div>
    <?php echo $noticia->descricao?>
    
    <div class='data'>
        <span class="label label-primary"><?php echo $noticia->data ?></span>
        <span class="label label-primary"><?php echo "Por:".$noticia->nome_usuario ?></span>
    </div>
  
    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <h5 class="panel-title">Comentarios</h5>
        </div>
<?php
    if(isset($coments)){
        foreach($coments AS $coment){
?>
        <div class="coments">
            <p class="nome-user"><?php echo $coment->nome ?></p>
            <p class="coment-user"><?php echo $coment->comentario ?></p>
        </div>
<?php
        }
    }
?>

         <form class="form" action="<?php echo HOME_URI;?>comentario/salvar" method="POST">  
            <div class="form-group">
                <input type="text" class="form-control" name="comentario" placeholder="Adicione um comentário">
            <div class="input-form">
                <button type="submit" class="btn btn-primary btn-sm" name="enviar">Enviar</button>
            </div>
            </div>      
            
        </form>

    </div>

    

</div>
    

</main>
</html>