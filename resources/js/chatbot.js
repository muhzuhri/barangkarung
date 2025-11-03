import './bootstrap';

// Chatbot Component
const chatbot = {
    data() {
        return {
            isOpen: false,
            messages: [{
                type: 'bot',
                content: 'Halo! Saya asisten BarangKarung. Tanyakan soal pakaian, ukuran, pengiriman, atau cara belanja ya.'
            }],
            newMessage: '',
            isTyping: false
        }
    },
    methods: {
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },
        async sendMessage() {
            if (!this.newMessage.trim()) return;

            // Tambahkan pesan user
            this.messages.push({
                type: 'user',
                content: this.newMessage.trim()
            });

            const message = this.newMessage.trim();
            this.newMessage = '';
            this.isTyping = true;

            try {
                const response = await fetch('/chatbot/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();

                // Tambahkan jeda singkat untuk efek natural
                setTimeout(() => {
                    this.isTyping = false;
                    this.messages.push({
                        type: 'bot',
                        content: data.reply
                    });
                    this.scrollToBottom();
                }, 500);
            } catch (error) {
                this.isTyping = false;
                this.messages.push({
                    type: 'bot',
                    content: 'Maaf, terjadi kesalahan. Silakan coba lagi.'
                });
            }

            this.scrollToBottom();
        },
        scrollToBottom() {
            const chatMessages = this.$refs.chatMessages;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        },
        formatMessage(content) {
            return content.split('\n').map(line => {
                if (line.startsWith('▫️')) {
                    return `<strong class="text-primary">${line}</strong>`;
                } else if (line.startsWith('📌')) {
                    return `<strong class="text-success">${line}</strong>`;
                } else if (line.startsWith('💡')) {
                    return `<strong class="text-info">${line}</strong>`;
                }
                return line;
            }).join('<br>');
        }
    },
    template: `
        <div class="chatbot-container">
            <!-- Chat Trigger Button -->
            <button v-if="!isOpen" @click="toggleChat" class="chat-trigger">
                <i class="material-icons">chat</i>
            </button>

            <!-- Chat Widget -->
            <div v-show="isOpen" class="chat-widget">
                <div class="chat-header">
                    <div class="chat-header-title">
                        <i class="material-icons">support_agent</i>
                        <h3>Asisten BarangKarung</h3>
                    </div>
                    <button @click="toggleChat" class="chat-close">
                        <i class="material-icons">close</i>
                    </button>
                </div>

                <div ref="chatMessages" class="chat-messages">
                    <div v-for="(message, index) in messages" 
                         :key="index" 
                         :class="['chat-message', message.type]">
                        <div class="message-content" v-html="formatMessage(message.content)"></div>
                    </div>
                    <div v-if="isTyping" class="chat-message bot typing">
                        <div class="typing-indicator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="chat-input-container">
                    <input type="text" 
                           v-model="newMessage" 
                           @keyup.enter="sendMessage"
                           placeholder="Tulis pertanyaan..." 
                           class="chat-input">
                    <button @click="sendMessage" 
                            class="chat-send" 
                            :disabled="!newMessage.trim()">
                        <i class="material-icons">send</i>
                    </button>
                </div>
            </div>
        </div>
    `
};

// Mount Vue app
const app = Vue.createApp({
    components: {
        'chat-bot': chatbot
    }
});

app.mount('#app');