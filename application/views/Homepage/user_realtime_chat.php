<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Real-Time Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h2>Chat with Admin</h2>
    <select id="receiver">
        <option value="">Select Admin</option>
        <?php foreach ($admins as $admin): ?>
            <option value="<?= $admin['admin_id'] ?>"><?= $admin['email'] ?></option>
        <?php endforeach; ?>
    </select>

    <div id="chat-box"></div>
    <input type="text" id="message" placeholder="Type a message...">
    <button onclick="sendMessage()">Send</button>

    <script>
        var receiver_id = '';

        $('#receiver').change(function () {
            receiver_id = $(this).val();
            if (receiver_id) {
                loadMessages();
            }
        });

        function loadMessages() {
            if (!receiver_id) return;

            $.ajax({
                url: '<?= base_url("conRealtimeChat/fetchMessages") ?>',
                type: 'POST',
                data: { receiver_id: receiver_id },
                success: function (response) {
                    var messages = JSON.parse(response);
                    var chatBox = $('#chat-box');
                    chatBox.html('');

                    messages.forEach(function (msg) {
                        var align = (msg.sender_id == <?= json_encode($this->session->userdata('user_id')) ?>) ? 'sent' : 'received';
                        chatBox.append('<div class="message ' + align + '">' + msg.message + '</div>');
                    });

                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }
            });
        }

        function sendMessage() {
            var message = $('#message').val();
            if (!receiver_id || !message) return;

            $.ajax({
                url: '<?= base_url("conRealtimeChat/sendMessage") ?>',
                type: 'POST',
                data: { receiver_id: receiver_id, message: message },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        $('#message').val('');
                        loadMessages();
                    } else {
                        alert("Message failed to send.");
                    }
                }
            });
        }

        setInterval(loadMessages, 2000); // Auto-refresh messages
    </script>
</body>

</html>