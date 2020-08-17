<main>
    <form action="<?php echo HOME_URI;?>noticia/editar" method="POST">
        <fieldset>
            <legend>Editar noticia notícia</legend>
            <div class="row">
                <input type="text" name="titulo" placeholder="Título da notícia" required/>
            </div>
            <div class="row">
                <input type="text" name="descricao" placeholder="Descrição da notícia" required/>
            </div>
            <div class="row">
                <input type="submit" name="enviar" value="Enviar" />
            </div>
        </fieldset>
    </form>
</main>