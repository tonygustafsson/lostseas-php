<form id="register" method="post"
    action="<?=base_url('account/register_temp')?>">
    <fieldset>
        <legend>Start playing without signing up...</legend>

        <div class="row">
            <div class="col-2">
                <input type="hidden" id="character_avatar" name="character_avatar"
                    value="<?=$character['character_avatar']?>">

                <label>Avatar</label>

                <img id="current_avatar_img" class="avatar-img pt-2"
                    src="<?=$character['character_avatar_path']?>"
                    alt="Avatar">

                <button class="mt-2 mb-2 small" type="button" id="js-start-avatar-selector-trigger">
                    Change avatar
                </button>
            </div>

            <div class="col-5">
                <label for="character_name">Name</label>
                <input id="character_name" type="text" name="character_name"
                    value="<?=$character['character_name']?>" />

                <label for="character_nation">Nation</label>

                <select name="character_nation" id="character_nation">
                    <option value="england" <?=$character['character_nation'] === 'england' ? 'selected' : ''?>>England
                    </option>
                    <option value="france" <?=$character['character_nation'] === 'france' ? 'selected' : ''?>>France
                    </option>
                    <option value="spain" <?=$character['character_nation'] === 'spain' ? 'selected' : ''?>>Spain
                    </option>
                    <option value="holland" <?=$character['character_nation'] === 'holland' ? 'selected' : ''?>>Holland
                    </option>
                </select>

                <div class="desktop-only">
                    <button type="submit" class="primary mt-3">
                        <svg width="32" height="32" class="Randomize">
                            <use xlink:href="#icon-swords"></use>
                        </svg>
                        Play
                    </button>

                    <a class="ajaxJSON button mt-3 ml-md-1"
                        href="<?=base_url('settings/generate_character')?>"
                        title="Generate random character">
                        <svg width="32" height="32" class="Randomize">
                            <use xlink:href="#icon-dices"></use>
                        </svg>
                        Random
                    </a>
                </div>
            </div>

            <div class="col-5">
                <label for="character_age">Age</label>
                <input id="character_age" type="number" min="15" max="80" name="character_age"
                    value="<?=$character['character_age']?>" /><br />

                <div class="mt-4">
                    <input class="js-gender-selector" id="male" type="radio" name="character_gender" value="M" <?=$character['character_gender'] === 'M' ? 'checked' : ''?>
                    /><label for="male">Male</label><br />
                    <input class="js-gender-selector" id="female" type="radio" name="character_gender" value="F" <?=$character['character_gender'] === 'F' ? 'checked' : ''?>
                    /><label for="female">Female</label>
                </div>


                <div class="mobile-only">
                    <button type="submit" class="primary mt-3">
                        <svg width="32" height="32" class="Randomize">
                            <use xlink:href="#icon-swords"></use>
                        </svg>
                        Play
                    </button>

                    <a class="ajaxJSON button mt-3 ml-md-1"
                        href="<?=base_url('settings/generate_character')?>"
                        title="Generate random character">
                        <svg width="32" height="32" class="Randomize">
                            <use xlink:href="#icon-dices"></use>
                        </svg>
                        Random
                    </a>
                </div>
            </div>
        </div>
    </fieldset>
</form>