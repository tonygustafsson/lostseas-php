const runChat = () => {
    var appdir = $('base').attr('href');
    var chatUpdateTimeout;

    function updateChat() {
        if (!$('#dynamic_chat').length) {
            // Only run in chat
            clearTimeout(chatUpdateTimeout);
            return;
        }

        $.ajax({
            url: appdir + 'chat/update_chat',
            cache: false,
            success: function (data) {
                $('#dynamic_chat').html(data);
                setTimeout(() => {
                    $('#chat_content').prop({ scrollTop: $('#chat_content').prop('scrollHeight') });
                    $('#entry').focus();
                }, 10);
            },
            error: function () {
                var errorMsg = 'Could not post data. Please try again!';
                window.alert(errorMsg);
            }
        });

        chatUpdateTimeout = window.setTimeout(updateChat, 10000);
    }

    $(document)
        .off('submit', '#chat_form')
        .on('submit', '#chat_form', function () {
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
                }
            });

            return false;
        });

    updateChat();
};

window.runChat = runChat;
