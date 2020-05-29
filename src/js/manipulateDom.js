import snackbar from './components/snackbar';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;

const manipulateDom = (data) => {
    if (!data) {
        return;
    }

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
        $.each(data.changeElements, function (element, attribute) {
            $.each(attribute, function (changedAttr, changedValue) {
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

        var title = $(data.loadView.trim()).filter('header').attr('title') + ' - Lost Seas';
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

    if (data.runJS) {
        //Just runJS
        eval(data.runJS);
    }

    if (data.consoleLog) {
        data.consoleLog.forEach((log) => {
            console.log(log);
        });
    }

    if (data.success) {
        snackbar({ text: data.success, level: 'success' });
    }

    if (data.info) {
        snackbar({ text: data.info, level: 'info' });
    }

    if (data.error) {
        snackbar({ text: data.error, level: 'error' });
    }
};

export default manipulateDom;
