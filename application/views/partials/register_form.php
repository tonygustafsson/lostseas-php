<form id="register" method="post"
    action="<?=base_url('account/register_temp')?>">
    <fieldset>
        <legend>Start playing without signing up...</legend>

        <div class="flex">
            <div class="text-center">
                <input type="hidden" id="character_avatar" name="character_avatar"
                    value="<?=$character['character_avatar']?>">

                <img id="current_avatar_img" style="border: 1px black solid;"
                    src="<?=$character['character_avatar_path']?>"
                    alt="Avatar"><br />

                <button type="button" id="js-start-avatar-selector-trigger">Change</button><br />

                <a class="ajaxJSON"
                    href="<?=base_url('settings/generate_character')?>"
                    title="Generate random character">
                    <svg width="32" height="32" class="Randomize">
                        <use xlink:href="#icon-dices"></use>
                    </svg>
                </a>
            </div>

            <div class="flex-full">
                <label for="character_name" style="margin-top: -16px">Character name</label>
                <input id="character_name" type="text" name="character_name"
                    value="<?=$character['character_name']?>" />

                <div>
                    <input class="js-gender-selector" id="male" type="radio" name="character_gender" value="M" <?=$character['character_gender'] === 'M' ? 'checked' : ''?>
                    /><label for="male">Male</label>
                    <input class="js-gender-selector" id="female" type="radio" name="character_gender" value="F" <?=$character['character_gender'] === 'F' ? 'checked' : ''?>
                    /><label for="female">Female</label>
                </div>

                <label for="character_age">Character age</label>
                <input id="character_age" type="number" min="15" max="80" style="width: 50px;" name="character_age"
                    value="<?=$character['character_age']?>" /><br />



                <button type="submit" class="primary">Play!</button>
            </div>
        </div>
    </fieldset>
</form>