<main>
    <form action="<?php echo HOME_URI;?>usuario/update" method="POST">
        <fieldset>
            <legend>Editar usuário</legend>
            <div class="row">
                <input type="text" name="nome" placeholder="nome" required
                pattern="^(?![ ])(?!.*[ ]{2})((?:e|da|do|das|dos|de|d'|D'|la|las|el|los)\s*?|(?:[A-Z][^\s]*\s*?)(?!.*[ ]$))+$"/>
            </div>
            <div class="row">
                <input type="email" name="email" placeholder="Email" required/>
            </div>
            <div class="row">
                <input type="text" name="senha" placeholder="senha" required/>
            </div>
            <div class="row">
                <input type="submit" name="enviar" value="Enviar" />
            </div>
        </fieldset>
    </form>

</main>