<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/botui/build/botui.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/botui/build/botui-theme-default.min.css" />
</head>
<body>
    <div id="chat-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/botui/build/botui.min.js"></script>

    <script>
        var botui = new BotUI('chat-container');

        botui.message.add({
            content: 'Hello! How can I help you today?'
        }).then(function() {
            return botui.action.text({
                action: {
                    placeholder: 'Type your question...'
                }
            });
        }).then(function(res) {
            botui.message.add({
                content: 'You said: ' + res.value
            });
        });
    </script>
</body>