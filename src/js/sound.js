var appdir = $('base').attr('href');
var gameMusic = new Audio();

function changeSong() {
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
}

function musicControl() {
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
            },
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
            },
        });
    }
}

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
        },
    });
});

$(document).ready(function () {
    var autoPlay = $('#music_control').data('autoplay');
    if (autoPlay == 'yes') {
        changeSong();
    }

    $('#sound_controls').dialog({
        autoOpen: false,
        resizable: false,
        open: function () {
            $('#music_link').blur();
        },
    });

    $('#sound_controls_icon').click(function () {
        if ($('#sound_controls').dialog('isOpen')) {
            $('#sound_controls').dialog('close');
        } else {
            $('#sound_controls').dialog('open');
        }
        return false;
    });

    var musicVolue = $('#music_control').data('musicvolume');

    $('#music_volume_slider').slider({
        value: musicVolue,
        step: 1,
        min: 0,
        max: 100,
        animate: 'fast',
        change: function () {
            var volume = $('#music_volume_slider').slider('value');

            $.ajax({
                url: appdir + 'account/music_volume/' + volume,
                success: function () {
                    gameMusic.volume = volume / 100;

                    if (typeof ga == typeof Function) {
                        ga('send', 'event', 'MusicVolume', volume);
                    }

                    $('#music_control').data('musicvolume', volume);
                },
            });
        },
    });
});

window.musicControl = musicControl;
window.changeSong = changeSong;
