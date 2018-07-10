'use strict';

//------------------
// Global variables
//------------------

var appdir = $('base').attr('href');
var windowFocus = true;
var firstFocus = true;
var updateTimeout;
var gameMusic = new Audio();

//------------------
// Functions
//------------------

function gameManipulateDOM(data) {
    var x;
    var toggleVisibility = [
        'inventory_ship_health',
        'inventory_rafts',
        'inventory_crew_mood',
        'inventory_prisoners',
        'inventory_porcelain',
        'inventory_spices',
        'inventory_silk',
        'inventory_medicine',
        'inventory_tobacco',
        'inventory_rum',
        'inventory_bank_account',
        'inventory_bank_loan',
        'inventory_new_messages'
    ];

    if (data.changeElements) {
        $.each(data.changeElements, function(element, attribute) {
            $.each(attribute, function(changedAttr, changedValue) {
                if (changedAttr == 'text') {
                    if ($('#' + element).text() != changedValue) {
                        $('#' + element).text(changedValue);

                        if (toggleVisibility.indexOf(element) > -1) {
                            //If the text is in an element that should be invisible if 0, or not
                            if (changedValue == 0) {
                                $('#' + element)
                                    .parent()
                                    .parent()
                                    .css('display', 'none');
                            } else {
                                $('#' + element)
                                    .parent()
                                    .parent()
                                    .css('display', 'block');
                            }
                        }

                        /* Nice effect for getting users attention */
                        for (x = 0; x < 5; x = x + 1) {
                            $('#' + element).slideToggle(100);
                            $('#' + element).slideToggle(100);
                        }
                    }
                } else if (changedAttr == 'html') {
                    $('#' + element).html(changedValue);
                } else if (changedAttr == 'val') {
                    $('#' + element).val(changedValue);
                } else if (changedAttr == 'checked') {
                    $('#' + element).prop('checked', changedValue);
                } else if (changedAttr == 'prepend') {
                    $('#' + element).prepend(changedValue);
                } else if (changedAttr == 'append') {
                    $('#' + element).append(changedValue);
                } else if (changedAttr == 'visibility') {
                    $('#' + element).css('display', changedValue);
                } else if (changedAttr == 'remove') {
                    $('#' + element).remove();
                } else {
                    $('#' + element).attr(changedAttr, changedValue);
                }
            });
        });
    }

    if (data.loadView) {
        $('article#main').html(data.loadView);

        var title =
            $(data.loadView.trim())
                .filter('header')
                .attr('title') + ' - Lost Seas';
        if (title) {
            document.title = title;
        }
    }

    if (data.pushState) {
        window.history.pushState({ path: data.pushState }, '', data.pushState);
    }

    if (data.playSound) {
        var sound = new Audio();
        var soundPath = appdir + 'assets/sounds/' + data.playSound;

        if (sound.canPlayType('audio/ogg')) {
            sound.src = soundPath + '.ogg';
            sound.type = 'audio/ogg';
        } else if (sound.canPlayType('audio/mp4')) {
            sound.src = soundPath + '.mp4';
            sound.type = 'audio/mp4';
        }

        sound.play();
    }

    if (data.loadJSFile && data.runJS) {
        //Run the runJS after loading the new JS files to avoid errors
        if ($.isArray(data.loadJSFile)) {
            //Load multiple JS files from an array
            $.each(data.loadJSFile, function(key, currentFile) {
                $.getScript(currentFile).done(function() {
                    eval(data.runJS);
                });
            });
        } else {
            //Load only one JS file from string
            $.getScript(data.loadJSFile).done(function() {
                eval(data.runJS);
            });
        }
    } else if (data.loadJSFile) {
        //Only load JS files, no runJS
        if ($.isArray(data.loadJSFile)) {
            //Load multiple JS files from an array

            $.each(data.loadJSFile, function(key, currentFile) {
                $.getScript(currentFile);
            });
        } else {
            //Load only one JS file from string
            $.getScript(data.loadJSFile);
        }
    } else if (data.runJS) {
        //Just runJS, no JS files to load
        eval(data.runJS);
    }

    if (data.success) {
        $('div#msg').prepend('<div class="success"><p>' + data.success + '</p></div>');
        $('div#msg div')
            .not(':first-child')
            .delay(3000)
            .slideUp(250);
    }

    if (data.info) {
        $('div#msg').prepend('<div class="info"><p>' + data.info + '</p></div>');
        $('div#msg div')
            .not(':first-child')
            .delay(3000)
            .slideUp(250);
    }

    if (data.error) {
        $('div#msg').prepend('<div class="error"><p>' + data.error + '</p></div>');
        $('div#msg div')
            .not(':first-child')
            .delay(3000)
            .slideUp(250);
    }
}

function ajaxGameRequest(event) {
    event.preventDefault();

    var element = $(this).prop('tagName');
    var url;
    var myData;

    if (element == 'FORM') {
        url = $(this).attr('action');
        myData = $(this).serialize();
    } else if (element == 'A') {
        url = $(this).attr('href');
        var question = $(this).attr('rel');
        myData = false;

        if (question && !window.confirm(question)) {
            //I put confirm questions in a rel="", if it exists and is not verified - do nothing
            return false;
        }
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: myData,
        dataType: 'json',
        beforeSend: function() {
            $('body').addClass('loading');
        },
        success: function(data) {
            gameManipulateDOM(data);

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', gaURL.pathname);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            var errorMsg = '<div class="error"><p>Failed to send data: ' + thrownError + '</p></div>';
            $('div#msg').prepend(errorMsg);
        },
        complete: function() {
            $('body').removeClass('loading');
            $('html, body').animate({ scrollTop: 0 }, 'normal');
        }
    });
}

function toggleVisibility(id) {
    var element = $('#' + id);
    if (element.css('display') == 'none') {
        element.css('display', 'block');
    } else {
        element.css('display', 'none');
    }
}

function godmodeChangeAll(pattern) {
    var input = window.prompt('Enter input for ' + pattern);
    $("input[id$='_" + pattern + "']").val(input);
}

function updateLastActivity() {
    if (windowFocus && $('#nav_logout').length != 0) {
        $.ajax({
            url: appdir + 'account/update_activity',
            cache: false,
            dataType: 'json',
            success: function(data) {
                gameManipulateDOM(data);
            }
        });
    }

    updateTimeout = window.setTimeout(updateLastActivity, 30000);
}

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
            success: function() {
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
            success: function() {
                if (typeof ga == typeof Function) {
                    ga('send', 'event', 'Music', 'Pause');
                }

                $('#music_icon').attr('src', appdir + 'assets/images/icons/music_play.png');
                $('#music_link').attr('title', 'Play game music');
            }
        });
    }
}

//------------------
// Event handelers
//------------------

$(document).ready(function() {
    window.setTimeout(updateLastActivity, 60000);

    var autoPlay = $('#music_control').data('autoplay');
    if (autoPlay == 'yes') {
        changeSong();
    }

    $('#sound_controls').dialog({
        autoOpen: false,
        resizable: false,
        open: function() {
            $('#music_link').blur();
        }
    });

    $('#sound_controls_icon').click(function() {
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
        change: function() {
            var volume = $('#music_volume_slider').slider('value');

            $.ajax({
                url: appdir + 'account/music_volume/' + volume,
                success: function() {
                    gameMusic.volume = volume / 100;

                    if (typeof ga == typeof Function) {
                        ga('send', 'event', 'MusicVolume', volume);
                    }

                    $('#music_control').data('musicvolume', volume);
                }
            });
        }
    });

    if ($('#initial_page_load').length != 0) {
        $('#initial_page_load').fadeOut(3000);
    }
});

$(window).on('focus blur', function(e) {
    //Detects if game has focus or not, discontinues automatic updates
    var prevType = $(this).data('prevType');

    if (prevType != e.type) {
        //reduce double fire issues

        switch (e.type) {
            case 'blur':
                windowFocus = false;
                firstFocus = false;

                break;
            case 'focus':
                windowFocus = true;

                if (firstFocus == false) {
                    clearTimeout(updateTimeout);
                    updateLastActivity();
                }

                break;
        }
    }

    $(this).data('prevType', e.type);
});

$(document).on('click', '.ajaxHTML', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        url: url,
        cache: false,
        beforeSend: function() {
            $('body').addClass('loading');
        },
        success: function(data) {
            $('article#main').html(data);

            if (window.location.hash) {
                //Handle internal links (hash)
                var hash = $('#' + window.location.hash.substring(1));
                if ($(hash).offset()) {
                    $(document).scrollTop($(hash).offset().top);
                }
            }

            //Change document title from <header title=""> on source, trim is needed for pages starting with tab
            var title =
                $(data.trim())
                    .filter('header')
                    .attr('title') + ' - Lost Seas';
            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            $('body').removeClass('loading');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            var errorDiv = $(
                '<div class="url_error">Something went wrong when recieving HTML: ' + thrownError + '</div>'
            ).hide();
            $('body').append(errorDiv);
            errorDiv
                .fadeIn(300)
                .delay(4000)
                .fadeOut(300);
            $('body').removeClass('loading');
        }
    });

    if (url != window.location) {
        window.history.pushState({ path: url }, '', url);
    }

    return false;
});

$(window).on('popstate', function(e) {
    if (!e.originalEvent.state) {
        return;
    }

    $.ajax({
        url: location.pathname,
        cache: false,
        beforeSend: function() {
            $('body').addClass('loading');
        },
        success: function(data) {
            $('article#main').html(data);

            //Change document title from <header title=""> on source, trim is needed for pages starting with tab
            var title =
                $(data.trim())
                    .filter('header')
                    .attr('title') + ' - Lost Seas';
            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = location.pathname;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            $('body').removeClass('loading');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            var errorDiv = $(
                '<div class="url_error">Something went wrong when recieving HTML: ' + thrownError + '</div>'
            ).hide();
            $('body').append(errorDiv);
            errorDiv
                .fadeIn(300)
                .delay(4000)
                .fadeOut(300);
            $('body').removeClass('loading');
        }
    });
});

$(document).on('change', '#sound_effects input', function() {
    var value = $('#sound_effects input:checked').val();

    $.ajax({
        url: appdir + 'account/sound_effects/' + value,
        success: function() {
            var googleValue = value === 1 ? 'TurnOn' : 'TurnOff';

            if (typeof ga == typeof Function) {
                ga('send', 'event', 'SoundFX', googleValue);
            }
        }
    });
});

gameMusic.addEventListener('ended', changeSong, false);

$(document).on('submit', 'form.ajaxJSON', ajaxGameRequest);

$(document).on('click', 'a.ajaxJSON', ajaxGameRequest);

$(document).on('click', 'a.disabled', function() {
    return false;
});

$(document).on('change', '#godmode_change_user', function() {
    var chosenUser = $('select[name=godmode_change_user]').val();
    var baseURL = $('#godmode_change_user_url').data('baseurl');
    $('#godmode_change_user_url').attr('href', baseURL + '/' + chosenUser);
});

$(document).on('click', '#nav_top_button', function() {
    toggleVisibility('nav_top');
    return false;
});

$(document).on('click', 'nav#nav_top a', function() {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('nav#nav_top').css('display', 'none');
    }
});

$(document).on('click', '#action_panel_button', function() {
    toggleVisibility('action_panel');
    return false;
});

$(document).on('click', '#action_panel a', function() {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('#action_panel').css('display', 'none');
    }
});

$(document).on('click', '#inventory_panel_button', function() {
    toggleVisibility('inventory_panel');
    return false;
});

$(document).on('click', '#inventory_panel a', function() {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('#inventory_panel').css('display', 'none');
    }
});

$(document).on('click', 'a.newWindow', function(e) {
    e.preventDefault();

    var url = $(this).attr('href');
    var title = $(this).attr('title') + ' - Lost Seas';

    var popUp = window.open(url, title, 'width=850, height=500, left=10, top=10, scrollbars, resizable');

    if (popUp === null || typeof popUp === 'undefined') {
        window.alert('The chat could not launch because popups are disabled in your browser!');
    } else {
        popUp.focus();
    }
});
