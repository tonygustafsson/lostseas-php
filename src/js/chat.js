import snackbar from './components/snackbar';
import axios from 'axios';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;
let chatUpdateTimeout = null;

const updateChat = () => {
    const chatWrapper = document.getElementById('dynamic_chat');
    const input = document.getElementById('entry');

    if (!chatWrapper) {
        // Only run in chat
        clearTimeout(chatUpdateTimeout);
        return;
    }

    const url = appdir + 'chat/update_chat';

    axios({
        method: 'get',
        url: url,
        responseType: 'json'
    })
        .then((response) => {
            chatWrapper.innerHTML = response.data.content;

            setTimeout(() => {
                const chatContent = document.getElementById('chat_content');
                chatContent.scrollTop = chatContent.scrollHeight;

                input.focus();
            }, 10);
        })
        .catch((err) => {
            debugger;
            snackbar({ text: `Could not update chat. ${err.toString()}`, level: 'error' });
        });

    chatUpdateTimeout = window.setTimeout(updateChat, 10000);
};

const postChat = (e) => {
    e.preventDefault();

    const chatForm = e.target;
    const url = chatForm.action;
    const input = document.getElementById('entry');

    axios({
        method: 'post',
        url: url,
        data: new FormData(chatForm)
    })
        .then(() => {
            input.value = '';

            clearTimeout(chatUpdateTimeout);

            updateChat();
        })
        .catch((err) => {
            snackbar({ text: `Could not post to chat. ${err.toString()}`, level: 'error' });
        });
};

window.addEventListener('chat', () => {
    updateChat();

    const chatForm = document.getElementById('chat_form');

    if (chatForm) {
        chatForm.addEventListener('submit', postChat);
    }
});
