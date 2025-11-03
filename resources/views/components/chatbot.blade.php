<!-- Chat Widget -->
<div class="chat-trigger">
    <i class="material-icons">chat</i>
</div>

<div class="chat-widget">
    <div class="chat-header">
        <h3>Asisten BarangKarung</h3>
        <button class="chat-close">×</button>
    </div>
    <div class="chat-messages">
        <div class="chat-message bot">
            Halo! Saya asisten BarangKarung. Tanyakan soal pakaian, ukuran, pengiriman, atau cara belanja ya.
        </div>
    </div>
    <div class="chat-input-container">
        <input type="text" class="chat-input" placeholder="Tulis pertanyaan...">
        <button class="chat-send">Kirim</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatTrigger = document.querySelector('.chat-trigger');
    const chatWidget = document.querySelector('.chat-widget');
    const chatClose = document.querySelector('.chat-close');
    const chatInput = document.querySelector('.chat-input');
    const chatSend = document.querySelector('.chat-send');
    const chatMessages = document.querySelector('.chat-messages');

    // Toggle chat widget
    chatTrigger.addEventListener('click', () => {
        chatWidget.style.display = 'block';
        chatTrigger.style.display = 'none';
    });

    chatClose.addEventListener('click', () => {
        chatWidget.style.display = 'none';
        chatTrigger.style.display = 'flex';
    });

    // Send message
    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Add user message
            const userMsg = document.createElement('div');
            userMsg.className = 'chat-message user';
            userMsg.textContent = message;
            chatMessages.appendChild(userMsg);

            // Clear input
            chatInput.value = '';

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Send to server
            fetch('{{ route("chatbot.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Add bot reply
                const botMsg = document.createElement('div');
                botMsg.className = 'chat-message bot';
                botMsg.textContent = data.reply;
                chatMessages.appendChild(botMsg);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
        }
    }

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
</script>