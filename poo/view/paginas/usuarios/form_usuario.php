<main>
    <form action="<?php echo HOME_URI;?>usuario/salvar" method="POST">
        <fieldset>
            <legend>Cadastro de usuários</legend>
            <input type="hidden" name="id" />
            <div class="row">
                <input type="text" name="nome" placeholder="Nome do usuário" required
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
    <p>Já possui conta?<a href="<?php echo HOME_URI;?>usuario/login" class="btn">Logue-se aqui</a></p>

</main>