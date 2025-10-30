<!-- ===== NAVBAR ===== -->
<header class="navbar">
    <!-- Logo -->
    <div class="logo">
        <h1>BARANG KARUNG</h1>
    </div>

    <!-- Search bar -->
    <div class="search-box">
        <input type="text" placeholder="Cari produk keren dan terbaik di sini ..." />
        <button><span class="material-icons">search</span></button>
    </div>

    <!-- Right icons -->
    <div class="nav-right">
        <div class="dropdown">
            <a href="#"><span class="material-icons">notifications</span></a>
            <div class="dropdown-menu">
                <a href="#">Tidak ada Notifikasi !</a>
            </div>
        </div>

        <a href="{{ route('keranjang') }}"><span class="material-icons">shopping_cart</span></a>

        <div class="dropdown">
            <a href="#"><span class="material-icons">account_circle</span></a>
            <div class="dropdown-menu">
                @auth
                    <a href="{{ route('profile') }}"><span class="material-icons">person</span>Profile</a>
                    <a href="{{ route('pesanan') }}"><span class="material-icons">inventory_2</span>Pesanan</a>
                    <a href="{{ route('pesanan.history') }}"><span class="material-icons">history</span>Riwayat Pesanan</a>
                    <a href="#"><span class="material-icons">help_outline</span>FAQ</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #000; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 12px; padding: 12px 20px; width: 100%; text-align: left; cursor: pointer; transition: background 0.3s;">
                            <span class="material-icons">logout</span>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"><span class="material-icons">login</span>Masuk</a>
                    <a href="{{ route('register') }}"><span class="material-icons">person_add</span>Daftar</a>
                    <a href="#"><span class="material-icons">help_outline</span>FAQ</a>
                @endauth
            </div>
        </div>

        <!-- Tombol garis tiga -->
        <span class="material-icons menu-toggle">menu</span>
    </div>
</header>

<!-- ===== CATEGORY MENU ===== -->
<nav class="category-menu">
    <a href="{{ route('beranda') }}">Beranda</a>
    <a href="{{ route('katalog') }}">Katalog</a>
    <a href="{{ route('pesanan') }}">Pesanan</a>
    <a href="{{ route('pesanan.history') }}">Riwayat</a>
    <a href="{{ route('profile') }}">Profile</a>
</nav>

<!-- js toogle menu nav -->
<script>
    const toggle = document.querySelector('.menu-toggle');
    const categoryMenu = document.querySelector('.category-menu');

    toggle.addEventListener('click', () => {
        categoryMenu.classList.toggle('show');
    });
</script>

<!-- ===== Chatbot Floating Widget ===== -->
<div id="bk-chatbot" data-token="{{ csrf_token() }}" style="position: fixed; right: 20px; bottom: 20px; z-index: 9999; font-family: 'Poppins', sans-serif;">
    <div id="bk-chatbot-window" style="width: 320px; height: 420px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); display: none; flex-direction: column; overflow: hidden;">
        <div style="background:#111827; color:#fff; padding:12px 14px; display:flex; align-items:center; justify-content:space-between;">
            <div style="font-weight:600; font-size:14px;">Asisten BarangKarung</div>
            <button id="bk-chatbot-close" style="background:transparent; border:none; color:#fff; font-size:16px; cursor:pointer;">×</button>
        </div>
        <div id="bk-chatbot-messages" style="flex:1; padding:12px; overflow-y:auto; background:#f9fafb;"></div>
        <div style="padding:10px; border-top:1px solid #e5e7eb; background:#fff; display:flex; gap:8px;">
            <input id="bk-chatbot-input" type="text" placeholder="Tulis pertanyaan..." style="flex:1; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
            <button id="bk-chatbot-send" style="background:#111827; color:#fff; border:none; border-radius:8px; padding:10px 12px; font-size:13px; cursor:pointer;">Kirim</button>
        </div>
    </div>
    <button id="bk-chatbot-toggle" style="width:56px; height:56px; border-radius:50%; background:#111827; color:#fff; border:none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:22px;">💬</span>
    </button>
    
    <script>
        (function(){
            const root = document.getElementById('bk-chatbot');
            const token = root.getAttribute('data-token');
            const toggle = document.getElementById('bk-chatbot-toggle');
            const win = document.getElementById('bk-chatbot-window');
            const closeBtn = document.getElementById('bk-chatbot-close');
            const messages = document.getElementById('bk-chatbot-messages');
            const input = document.getElementById('bk-chatbot-input');
            const send = document.getElementById('bk-chatbot-send');

            function appendBubble(text, role){
                const wrap = document.createElement('div');
                wrap.style.margin = '8px 0';
                wrap.style.display = 'flex';
                wrap.style.justifyContent = role === 'user' ? 'flex-end' : 'flex-start';
                const bubble = document.createElement('div');
                bubble.style.maxWidth = '80%';
                bubble.style.padding = '10px 12px';
                bubble.style.borderRadius = '12px';
                bubble.style.fontSize = '13px';
                bubble.style.lineHeight = '1.4';
                bubble.style.whiteSpace = 'pre-wrap';
                bubble.style.wordBreak = 'break-word';
                if (role === 'user') {
                    bubble.style.background = '#111827';
                    bubble.style.color = '#fff';
                } else {
                    bubble.style.background = '#e5e7eb';
                    bubble.style.color = '#111827';
                }
                bubble.textContent = text;
                wrap.appendChild(bubble);
                messages.appendChild(wrap);
                messages.scrollTop = messages.scrollHeight;
            }

            function greet(){
                appendBubble('Halo! Saya asisten BarangKarung. Tanyakan soal pakaian, ukuran, pengiriman, atau cara belanja ya.','bot');
            }

            toggle.addEventListener('click', function(){
                win.style.display = 'flex';
                toggle.style.display = 'none';
                if (!messages.hasChildNodes()) greet();
                input.focus();
            });
            closeBtn.addEventListener('click', function(){
                win.style.display = 'none';
                toggle.style.display = 'flex';
            });

            function sendMessage(){
                const text = (input.value || '').trim();
                if (!text) return;
                appendBubble(text, 'user');
                input.value = '';
                fetch("{{ route('chatbot.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ message: text })
                }).then(r => r.json()).then(data => {
                    appendBubble(data.reply || 'Maaf, terjadi kendala. Coba lagi ya.', 'bot');
                }).catch(() => {
                    appendBubble('Maaf, jaringan bermasalah. Coba lagi nanti.', 'bot');
                });
            }

            send.addEventListener('click', sendMessage);
            input.addEventListener('keydown', function(e){ if (e.key === 'Enter') sendMessage(); });
        })();
    </script>
</div>