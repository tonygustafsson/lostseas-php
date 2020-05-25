import * as noUiSlider from 'nouislider';
import dialog from './components/dialog.js';

const appdir = $('base').attr('href');
const gameMusic = new Audio();

const changeSong = () => {
    var newSong = appdir + 'assets/music/song' + Math.floor(1 + Math.random() * 38);

    $('#music_icon').attr('src', appdir + 'assets/images/icons/music_pause.png');

    if (gameMusic.canPlayType('audio/ogg')) {
        //Play OGG files
        gameMusic.src = newSong + '.ogg';
        gameMusic.type = 'audio/ogg';
    } else if (gameMusic.canPlayType('audio/mp4')) {
        //MP4 if Safari or Internet Explorer
        gameMusic.src = newSong + '.mp4';
        gameMusic.type = 'audio/mp4';
    }

    if (typeof ga == typeof Function) {
        ga('send', 'event', 'MusicSong', gameMusic.src);
    }

    var musicVolume = $('#music_control').data('musicvolume');

    gameMusic.volume = musicVolume / 100;
    gameMusic.load();
    gameMusic.addEventListener('canplay', gameMusic.play(), false);
};

const musicControl = () => {
    if (gameMusic.paused || gameMusic.src == '') {
        $.ajax({
            url: appdir + 'account/music/1',
            success: function () {
                if (gameMusic.src == '') {
                    changeSong();

                    if (typeof ga == typeof Function) {
                        ga('send', 'event', 'Music', 'TurnOn');
                    }
                } else {
                    gameMusic.play();

                    if (typeof ga == typeof Function) {
                        ga('send', 'event', 'Music', 'Play');
                    }
                }

                $('#music_icon').attr('src', appdir + 'assets/images/icons/music_pause.png');
                $('#music_link').attr('title', 'Pause game music');
            }
        });
    } else {
        gameMusic.pause();

        $.ajax({
            url: appdir + 'account/music/0',
            success: function () {
                if (typeof ga == typeof Function) {
                    ga('send', 'event', 'Music', 'Pause');
                }

                $('#music_icon').attr('src', appdir + 'assets/images/icons/music_play.png');
                $('#music_link').attr('title', 'Play game music');
            }
        });
    }
};

const onSliderChange = (value) => {
    const volume = value;

    $.ajax({
        url: appdir + 'account/music_volume/' + volume,
        success: function () {
            gameMusic.volume = volume / 100;

            if (typeof ga == typeof Function) {
                ga('send', 'event', 'MusicVolume', volume);
            }

            $('#music_control').data('musicvolume', volume);
        }
    });
};

gameMusic.addEventListener('ended', changeSong, false);

$(document).on('change', '#sound_effects input', function () {
    var value = $('#sound_effects input:checked').val();

    $.ajax({
        url: appdir + 'account/sound_effects/' + value,
        success: function () {
            var googleValue = value === 1 ? 'TurnOn' : 'TurnOff';

            if (typeof ga == typeof Function) {
                ga('send', 'event', 'SoundFX', googleValue);
            }
        }
    });
});

$(document).ready(function () {
    var autoPlay = $('#music_control').data('autoplay');
    if (autoPlay == 'yes') {
        changeSong();
    }

    const modal = dialog({
        dialogElementId: 'sound_controls',
        dialogTriggerElementId: 'music_control'
    });

    const sliderEl = document.getElementById('music_volume_slider');
    const musicVolue = $('#music_control').data('musicvolume');

    if (!sliderEl) {
        return;
    }

    const slider = noUiSlider
        .create(sliderEl, {
            start: musicVolue,
            connect: 'lower',
            direction: 'ltr',
            step: 1,
            orientation: 'horizontal',
            range: {
                min: 0,
                max: 100
            }
        })
        .on('set', (value) => {
            onSliderChange(parseInt(value, 10));
        });
});

window.musicControl = musicControl;
window.changeSong = changeSong;
