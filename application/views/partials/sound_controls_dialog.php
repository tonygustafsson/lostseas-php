<div id="sound_controls" class="dialog" tabindex="-1" role="dialog">
    <h3 class="dialog-title">Sound control</h3>

    <h4>Track</h4>

    <?php if ($user['music_play'] == 1): ?>
    <a id="music_link" title="Pause game music" class="js-music-toggle-state" href="#"><img id="music_icon"
            src="<?php echo base_url('assets/images/icons/music_pause.png')?>"
            alt="Pause"></a>
    <?php else: ?>
    <a id="music_link" title="Play game music" class="js-music-toggle-state" href="#"><img id="music_icon"
            src="<?php echo base_url('assets/images/icons/music_play.png')?>"
            alt="Play"></a>
    <?php endif; ?>
    <a title="Next song, please" style="padding-left: 0.5em;" class="js-music-next" href="#"><img
            src="<?php echo base_url('assets/images/icons/music_next.png')?>"
            alt="Change track"></a>

    <h4>Volume</h4>

    <div id="music_volume_slider" class="slider"></div>

    <h4>Sound effects</h4>

    <span id="sound_effects">
        On <input type="radio" name="sound_effects" value="1" <?php echo ($user['sound_effects_play'] == 1) ? ' checked' : ''?>>
        Off <input type="radio" name="sound_effects" value="0" <?php echo ($user['sound_effects_play'] == 0) ? ' checked' : ''?>>
    </span>
</div>