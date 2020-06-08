<form id="register" method="post"
    action="<?=base_url('account/register_temp')?>">
    <fieldset>
        <legend>Start playing right now...</legend>

        <section id="register_left">
            <div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
                <input type="hidden" id="character_avatar" name="character_avatar"
                    value="<?=$character['character_avatar']?>">
                <input type="hidden" id="character_gender" name="character_gender"
                    value="<?=$character['character_gender']?>">

                <img id="current_avatar_img" style="border: 1px black solid;"
                    src="<?=$character['character_avatar_path']?>"
                    alt="Avatar"><br>
                <button type="button" id="js-start-avatar-selector-trigger">Change</button>
            </div>

            <label for="character_name">Character name</label>
            <input id="character_name" type="text" name="character_name"
                value="<?=$character['character_name']?>">

            <label for="character_age">Character age</label>
            <input id="character_age" type="number" min="15" max="80" style="width: 50px;" name="character_age"
                value="<?=$character['character_age']?>"><br>

            <a class="ajaxJSON"
                href="<?=base_url('account/generate_character')?>"
                title="Generate random character">
                <svg width="32" height="32" class="Randomize">
                    <use xlink:href="#dices"></use>
                </svg>
            </a>
            <br />
        </section>

        <section id="register_right">
            <input type="submit" value="Play!">
        </section>
    </fieldset>
</form>