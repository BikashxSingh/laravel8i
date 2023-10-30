const { default: axios } = require('axios');

require('./bootstrap');

const message_el = document.getElementById("messages");
const username_input = document.getElementById("username");
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form");

message_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let has_errors = false;

    if (username_input.value == "") {
        alert('Enter a username');
        has_errors = true;
    }

    if (message_input.value == "") {
        alert('Enter a message');
        has_errors = true;
    }

    if (has_errors) {
        return;
    }

    const options = {
        method: 'post',
        url: '/chat-first-example/chat/send-message',
        data: {
            username: username_input.value,
            message: message_input.value
        }
    }

    axios(options);

});


console.log(window.Echo.channel('chat'));
window.Echo.channel('chat')
    .listen('.data', (e) => {
        console.log(e);
        message_el.innerHTML += '<div class="message"><strong>' + e.username + ':</strong>' + e.message + '</div>';
    });
// . in message is required casue we are returning 'message' in Message Event and without . returning wont work cause we have to add app/event/message



// console.log('dfghjk');

// window.Echo.private('personal-chat')
//     .listen('.data', (e) => {
//         // this.messages.push({
//         //   message: e.message.message,
//         //   user: e.user
//         // });
//         console.log(e);

//         message_el1.innerHTML += '<div class="message"><strong>' + e.username + ':</strong>' + e.message + '</div>';

//     }); 