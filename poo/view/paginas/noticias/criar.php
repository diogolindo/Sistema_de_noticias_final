<main>
    <form action="<?php echo HOME_URI;?>noticia/salvar" method="POST">
        <fieldset>
            <legend>Criar notícia</legend>
            <h4>Só você poderá excluir e editar</h4>
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