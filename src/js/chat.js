const runChat = () => {
    var appdir = $('base').attr('href');
    var chatUpdateTimeout;

    function updateChat() {
        $.ajax({
            url: appdir + 'chat/update_chat',
            cache: false,
            success: function (data) {
                $('#dynamic_chat').html(data);
                $('#chat').prop({ scrollTop: $('article#chat').prop('scrollHeight') });
                $('#entry').focus();
            },
            error: function () {
                var errorMsg = 'Could not post data. Please try again!';
                window.alert(errorMsg);
            },
        });

        chatUpdateTimeout = window.setTimeout(updateChat, 15000);
    }

    $(document).on('submit', '#chat_form', function () {
        var url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: $('#entry').serialize(),
            success: function () {
                $('#entry').val('');
                clearTimeout(chatUpdateTimeout);
                updateChat();
            },
            error: function () {
                var errorMsg = 'Could not post data. Please try again!';
                window.alert(errorMsg);
            },
        });

        return false;
    });

    $(document).ready(function () {
        updateChat();
    });
};

$(document).ready(function () {
    runChat();
});
