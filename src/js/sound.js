import * as noUiSlider from 'nouislider';
import axios from 'axios';
import dialog from './components/dialog.js';
import snackbar from './components/snackbar';

const gameMusic = new Audio();

const trackSliderEl = document.getElementById('track_position_slider');
const trackNameEl = document.getElementById('js-music-control-track-name');

const getRandomSong = () => {
    const songs = window.musicFiles;
    const randomSong = songs[Math.floor(Math.random() * songs.length)];

    return `${window.appPath}assets/music/${randomSong}`;
};

const getSongNameFromUrl = (url) => {
    const regex = new RegExp(/^.*\/(.*)\..*$/);
    const groups = url.match(regex);

    if (groups.length < 2) {
        return url;
    }

    return groups[1].replace(/-/g, ' ');
};

const gameMusicPlay = () => {
    const playPromise = gameMusic.play();

    const currentSong = getSongNameFromUrl(gameMusic.src);

    console.log(`Playing song ${currentSong}`);
    trackNameEl.innerText = currentSong;

    playPromise.catch(() => {
        console.error('Could not play music, will start on DOM interaction');

        const body = document.getElementById('body');

        body.addEventListener(
            'click',
            () => {
                gameMusic.play();
            },
            { once: true }
        );
    });
};

const gameMusicTimeUpdate = (e) => {
    const audioSecondsLength = gameMusic.duration;
    const percentageDone = Math.floor((gameMusic.currentTime / audioSecondsLength) * 100);

    trackSliderEl.noUiSlider.set(percentageDone);
};

const gameMusicEnded = () => {
    trackSliderEl.noUiSlider.reset();

    changeSong();
};

const changeSong = (e) => {
    if (e) {
        e.preventDefault();
    }

    const newSong = getRandomSong();
    const musicControlEl = document.getElementById('music_control');

    const musicPlayIcon = document.getElementById('music_link_play');
    const musicPauseIcon = document.getElementById('music_link_pause');

    musicPlayIcon.style.display = 'none';
    musicPauseIcon.style.display = 'inline-block';

    if (gameMusic.canPlayType('audio/aac') || gameMusic.canPlayType('audio/x-m4a')) {
        const musicVolume = musicControlEl.dataset.musicvolume;

        gameMusic.src = newSong;
        gameMusic.type = 'audio/aac';
        gameMusic.volume = musicVolume / 100;

        gameMusic.load();
    } else {
        snackbar({ text: 'Audio type not supported.', level: 'error' });
    }
};

const musicToggle = (e) => {
    e.preventDefault();

    const musicPlayIcon = document.getElementById('music_link_play');
    const musicPauseIcon = document.getElementById('music_link_pause');

    if (gameMusic.paused || gameMusic.src === '') {
        axios({
            method: 'post',
            url: `${window.appPath}/account/music/1`
        })
            .then(() => {
                if (gameMusic.src === '') {
                    changeSong();

                    if (typeof window.gtag == typeof Function) {
                        window.gtag('event', 'Music', { event_category: 'TurnOn' });
                    }
                } else {
                    gameMusic.play();

                    trackNameEl.innerText = getSongNameFromUrl(gameMusic.src);

                    if (typeof window.gtag == typeof Function) {
                        window.gtag('event', 'Music', { event_category: 'Play' });
                    }
                }

                musicPlayIcon.style.display = 'none';
                musicPauseIcon.style.display = 'inline-block';

                trackSliderEl.removeAttribute('disabled');
            })
            .catch((err) => {
                snackbar({ text: 'Could not save sound effects settings', level: 'error' });
            });
    } else {
        gameMusic.pause();

        trackNameEl.innerText = 'Paused';
        trackSliderEl.setAttribute('disabled', true);

        axios({
            method: 'post',
            url: `${window.appPath}/account/music/0`
        })
            .then(() => {
                if (typeof window.gtag == typeof Function) {
                    window.gtag('event', 'Music', { event_category: 'Pause' });
                }

                musicPlayIcon.style.display = 'inline-block';
                musicPauseIcon.style.display = 'none';
            })
            .catch((err) => {
                snackbar({ text: 'Could not save sound effects settings', level: 'error' });
            });
    }
};

gameMusic.addEventListener('canplay', gameMusicPlay);
gameMusic.addEventListener('timeupdate', gameMusicTimeUpdate);
gameMusic.addEventListener('ended', gameMusicEnded, false);

const changeSoundEffects = (e) => {
    const checkbox = e.target;
    const value = checkbox.value;

    axios({
        method: 'post',
        url: `${window.appPath}account/sound_effects/${value}`
    })
        .then((result) => {
            if (typeof window.gtag == typeof Function) {
                window.gtag('event', 'SoundFX', { event_category: value === 1 ? 'TurnOn' : 'TurnOff' });
            }
        })
        .catch((err) => {
            snackbar({ text: 'Could not save sound effects settings', level: 'error' });
        });
};

const trackPositionSliderChange = (e) => {
    const seekPercentage = e[0] / 100;
    const audioSecondsLength = gameMusic.duration;
    const positionSeconds = audioSecondsLength * seekPercentage;

    gameMusic.currentTime = positionSeconds;
};

const createTrackPositionSlider = () => {
    if (!trackSliderEl) {
        return;
    }

    const trackPositionSlider = noUiSlider.create(trackSliderEl, {
        start: 0,
        connect: 'lower',
        direction: 'ltr',
        step: 1,
        orientation: 'horizontal',
        range: {
            min: 0,
            max: 100
        }
    });

    trackPositionSlider.on('change', trackPositionSliderChange);

    if (!gameMusic.src) {
        trackSliderEl.setAttribute('disabled', true);
    }
};

const volumeSliderChange = (value) => {
    const volume = value;
    const musicControlEl = document.getElementById('music_control');

    axios({
        method: 'post',
        url: `${window.appPath}account/music_volume/${volume}`
    })
        .then((result) => {
            gameMusic.volume = volume / 100;

            if (typeof window.gtag == typeof Function) {
                window.gtag('event', 'Music', { event_category: 'MusicVolume', event_label: volume });
            }

            musicControlEl.dataset.musicvolume = volume;
        })
        .catch((err) => {
            snackbar({ text: 'Could not save sound effects settings', level: 'error' });
        });
};

const createVolumeSlider = () => {
    const sliderEl = document.getElementById('music_volume_slider');
    const musicControlEl = document.getElementById('music_control');
    const musicVolue = musicControlEl.dataset.musicvolume;

    if (!sliderEl) {
        return;
    }

    const volumeSlider = noUiSlider
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
            volumeSliderChange(parseInt(value, 10));
        });
};

window.addEventListener('load', () => {
    // Enable music toggle
    const musicToggles = Array.from(document.querySelectorAll('.js-music-toggle-state'));

    if (musicToggles.length <= 0) {
        // Not logged in
        return;
    }

    musicToggles.forEach((toggle) => {
        toggle.addEventListener('click', musicToggle);
    });

    // Enable music next
    const musicNextBtn = document.querySelector('.js-music-next');

    musicNextBtn.addEventListener('click', (e) => {
        e.preventDefault();

        trackSliderEl.noUiSlider.reset();

        changeSong();
    });

    // Auto play music if turned on
    const musicControlEl = document.getElementById('music_control');

    if (musicControlEl.dataset.autoplay && musicControlEl.dataset.autoplay === 'yes') {
        // Start game music on page load, if autoplay is set
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

    createTrackPositionSlider();
    createVolumeSlider();
});
