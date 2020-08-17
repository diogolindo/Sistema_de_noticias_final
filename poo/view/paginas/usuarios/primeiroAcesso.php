<main>
    <form action="<?php echo HOME_URI;?>usuario/primeiro" method="POST">
        <fieldset>
            <legend>Já que é seu primeiro acesso, defina a sua senha</legend>
            <div class="row">
                <input type="text" name="senha" placeholder="senha" required/>
            </div>
            <div class="row">
                <input type="submit" name="enviar" value="Enviar" />
            </div>
        </fieldset>
    </form>

</main>