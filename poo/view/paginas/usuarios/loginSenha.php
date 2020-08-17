<main>
    <form action="<?php echo HOME_URI;?>usuario/loginSenha" method="POST">
        <fieldset>
            <legend>Repasse a sua senha</legend>
            <div class="row">
                <input type="text" name="senha" placeholder="senha" required/>
            </div>
            <div class="row">
                <input type="submit" name="enviar" value="Enviar" required/>
            </div>
        </fieldset>
    </form>

</main>