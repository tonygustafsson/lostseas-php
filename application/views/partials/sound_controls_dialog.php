<div id="sound_controls" class="dialog" tabindex="-1" role="dialog">
        <h3 class="dialog-title">Sound control</h3>

        <h4>Track</h4>

        <?php
                $pause_music_display_style = $user['music_play'] == 1 ? 'inline-block' : 'none';
                $play_music_display_style = $user['music_play'] == 1 ? 'none' : 'inline-block';
        ?>

        <a id="music_link_play" title="Play game music" class="js-music-toggle-state sound-control-button" href="#"
                style="display: <?=$play_music_display_style?>">
                <svg width="32" height="32" class="Play music">
                        <use xlink:href="#sound-play"></use>
                </svg>
        </a>

        <a id="music_link_pause" title="Pause game music" class="js-music-toggle-state sound-control-button" href="#"
                style="display: <?=$pause_music_display_style?>">
                <svg width="32" height="32" class="Pause music">
                        <use xlink:href="#sound-pause"></use>
                </svg>
        </a>

        <a title="Next song, please" style="padding-left: 0.5em;" class="js-music-next" href="#">
                <svg width="32" height="32" class="Next song">
                        <use xlink:href="#sound-next"></use>
                </svg>
        </a>

        <h4>Volume</h4>

        <div id="music_volume_slider" class="slider"></div>

        <h4>Sound effects</h4>

        <span id="sound_effects">
                On <input type="radio" name="sound_effects" value="1" <?=($user['sound_effects_play'] == 1) ? ' checked' : ''?>>
                Off <input type="radio" name="sound_effects" value="0" <?=($user['sound_effects_play'] == 0) ? ' checked' : ''?>>
        </span>
</div>