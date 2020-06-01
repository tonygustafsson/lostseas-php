import * as noUiSlider from 'nouislider';
import axios from 'axios';
import dialog from './components/dialog.js';
import snackbar from './components/snackbar';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;
const gameMusic = new Audio();

const changeSong = (e) => {
    if (e) {
        e.preventDefault();
    }

    const newSong = appdir + 'assets/music/song' + Math.floor(1 + Math.random() * 38);
    const musicControlEl = document.getElementById('music_control');

    const musicIcon = document.getElementById('music_icon');
    musicIcon.src = appdir + 'assets/images/icons/music_pause.png';

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

    const musicVolume = musicControlEl.dataset.musicvolume;

    gameMusic.volume = musicVolume / 100;
    gameMusic.load();
    gameMusic.addEventListener('canplay', gameMusic.play(), false);
};

const musicToggle = (e) => {
    e.preventDefault();

    const musicIcon = document.getElementById('music_icon');
    const musicLink = document.getElementById('music_link');

    if (gameMusic.paused || gameMusic.src === '') {
        axios({
            method: 'post',
            url: `${appdir}/account/music/1`
        })
            .then((result) => {
                if (gameMusic.src === '') {
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

                musicIcon.src = appdir + 'assets/images/icons/music_pause.png';
                musicLink.title = 'Pause the music';
            })
            .catch((err) => {
                snackbar({ text: 'Could not save sound effects settings', level: 'error' });
            });
    } else {
        gameMusic.pause();

        axios({
            method: 'post',
            url: `${appdir}/account/music/0`
        })
            .then((result) => {
                if (typeof ga == typeof Function) {
                    ga('send', 'event', 'Music', 'Pause');
                }

                musicIcon.src = appdir + 'assets/images/icons/music_play.png';
                musicLink.title = 'Play the music';
            })
            .catch((err) => {
                snackbar({ text: 'Could not save sound effects settings', level: 'error' });
            });
    }
};

const onSliderChange = (value) => {
    const volume = value;
    const musicControlEl = document.getElementById('music_control');

    axios({
        method: 'post',
        url: `${appdir}account/music_volume/${volume}`
    })
        .then((result) => {
            gameMusic.volume = volume / 100;

            if (typeof ga == typeof Function) {
                ga('send', 'event', 'MusicVolume', volume);
            }

            musicControlEl.dataset.musicvolume = volume;
        })
        .catch((err) => {
            snackbar({ text: 'Could not save sound effects settings', level: 'error' });
        });
};

gameMusic.addEventListener('ended', changeSong, false);

const changeSoundEffects = (e) => {
    const checkbox = e.target;
    const value = checkbox.value;

    axios({
        method: 'post',
        url: `${appdir}account/sound_effects/${value}`
    })
        .then((result) => {
            var googleValue = value === 1 ? 'TurnOn' : 'TurnOff';

            if (typeof ga == typeof Function) {
                ga('send', 'event', 'SoundFX', googleValue);
            }
        })
        .catch((err) => {
            snackbar({ text: 'Could not save sound effects settings', level: 'error' });
        });
};

window.addEventListener('load', () => {
    // Enable music toggle
    const musicToggles = Array.from(document.querySelectorAll('.js-music-toggle-state'));

    musicToggles.forEach((toggle) => {
        toggle.addEventListener('click', musicToggle);
    });

    // Enable music next
    const musicNextBtn = document.querySelector('.js-music-next');

    musicNextBtn.addEventListener('click', changeSong);

    // Auto play music if turned on
    const musicControlEl = document.getElementById('music_control');

    if (musicControlEl.dataset.autoplay && musicControlEl.dataset.autoplay === 'yes') {
        changeSong();
    }

    // Enable sound effect triggers
    const soundEffectCheckboxes = Array.from(document.querySelectorAll('#sound_effects input'));

    soundEffectCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', changeSoundEffects);
    });

    // Enable modal on click
    const modal = dialog({
        dialogElementId: 'sound_controls',
        dialogTriggerElementId: 'music_control'
    });

    const sliderEl = document.getElementById('music_volume_slider');
    const musicVolue = musicControlEl.dataset.musicvolume;

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
