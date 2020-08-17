<main>
    <form action="<?php echo HOME_URI;?>usuario/entrar" method="POST">
        <fieldset>
            <legend>Login de usuário</legend>
            <div class="row">
                <input type="text" name="nome" placeholder="nome" 
                pattern="^(?![ ])(?!.*[ ]{2})((?:e|da|do|das|dos|de|d'|D'|la|las|el|los)\s*?|(?:[A-Z][^\s]*\s*?)(?!.*[ ]$))+$"/>
            </div>
            <div class="row">
                <input type="email" name="email" placeholder="Email" required/>
            </div>
            <div class="row">
                <input type="submit" name="enviar" value="Enviar" />
            </div>
        </fieldset>
    </form>
    <p>Não possui conta?<a href="<?php echo HOME_URI;?>usuario/criar" class="btn">Crie uma aqui</a></p>

</main>