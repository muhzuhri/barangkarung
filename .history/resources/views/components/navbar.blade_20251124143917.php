<!-- ===== NAVBAR ===== -->
<header class="navbar">
    <div class="navbar-top">
        <!-- LOGO -->
        <div class="logo">
            <h1>BARANG KARUNG</h1>
        </div>

        <!-- SECTION SEACRH BOX -->
        <div class="search-box">
            <input type="text" placeholder="Cari produk keren dan terbaik di sini ..." />
            <button><span class="material-icons">search</span></button>
        </div>

        <!-- SECTION RIGHT ICON -->
        <div class="nav-right">

            <!-- KERANJANG -->
            <a href="{{ route('keranjang') }}" class="nav-icon"> <span class="material-icons">shopping_cart</span>
            </a>

            <!-- DROPDOWN SETTING -->
            <div class="dropdown">
                <a href="#" class="nav-icon dropdown-trigger">
                    <span class="material-icons">account_circle</span>
                </a>

                <div class="dropdown-menu">
                    @auth
                        <a href="{{ route('profile') }}">
                            <span class="material-icons">person</span> Profile
                        </a>

                        <a href="{{ route('pesanan') }}">
                            <span class="material-icons">inventory_2</span> Pesanan
                        </a>

                        <a href="{{ route('pesanan.history') }}">
                            <span class="material-icons">history</span> Riwayat Pesanan
                        </a>

                        <!-- Logout di dalam menu -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <span class="material-icons">logout</span> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            <span class="material-icons">login</span> Masuk
                        </a>

                        <a href="{{ route('register') }}">
                            <span class="material-icons">person_add</span> Daftar
                        </a>
                    @endauth
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const dropdown = document.querySelector(".dropdown");
                    const trigger = document.querySelector(".dropdown-trigger");

                    // Toggle saat icon diklik
                    trigger.addEventListener("click", (e) => {
                        e.preventDefault();
                        dropdown.classList.toggle("active");
                    });

                    // Tutup jika klik area luar dropdown
                    document.addEventListener("click", (e) => {
                        if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                            dropdown.classList.remove("active");
                        }
                    });
                });
            </script>

        </div>
        <!-- HAMBURGER MENU (Mobile) -->
<div class="hamburger" id="hamburgerBtn">
    <span class="material-icons">menu</span>
</div>
    </div>

</header>

<!-- ===== SECTION CATEGORY MENU ===== -->
<nav class="category-menu" id="categoryMenu">
    <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
    <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog</a>
    <a href="{{ route('pesanan') }}" class="{{ request()->routeIs('pesanan') ? 'active' : '' }}">Pesanan</a>
    <a href="{{ route('pesanan.history') }}"
        class="{{ request()->routeIs('pesanan.history') ? 'active' : '' }}">Riwayat</a>
    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
</nav>

<!-- js toggle menu nav -->
<script>
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const categoryMenu = document.getElementById('categoryMenu');
    const navbar = document.querySelector('.navbar');

    if (hamburgerMenu && categoryMenu) {
        hamburgerMenu.addEventListener('click', () => {
            hamburgerMenu.classList.toggle('active');
            categoryMenu.classList.toggle('show');
            navbar.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navbar.contains(e.target) && categoryMenu.classList.contains('show')) {
                hamburgerMenu.classList.remove('active');
                categoryMenu.classList.remove('show');
                navbar.classList.remove('menu-open');
            }
        });

        // Close menu when clicking on a link
        categoryMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburgerMenu.classList.remove('active');
                categoryMenu.classList.remove('show');
                navbar.classList.remove('menu-open');
            });
        });
    }
</script>

<!-- ===== SECTION CHARBOT ===== -->
<div id="bk-chatbot" data-token="{{ csrf_token() }}"
    style="position: fixed; right: 20px; bottom: 20px; z-index: 9999; font-family: 'Poppins', sans-serif;">
    <div id="bk-chatbot-window"
        style="width: 400px; height: 550px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); display: none; flex-direction: column; overflow: hidden;">
        <div
            style="background:#111827; color:#fff; padding:14px 16px; display:flex; align-items:center; justify-content:space-between;">
            <div style="font-weight:600; font-size:16px;">Asisten BarangKarung</div>
            <button id="bk-chatbot-close"
                style="background:transparent; border:none; color:#fff; font-size:20px; cursor:pointer;">×</button>
        </div>
        <div id="bk-chatbot-messages" style="flex:1; padding:16px; overflow-y:auto; background:#f9fafb;"></div>
        <div id="bk-chatbot-quick-replies"
            style="padding:10px 14px; border-top:1px solid #e5e7eb; background:#fff; display:none; flex-wrap:wrap; gap:6px; max-height:120px; overflow-y:auto;">
        </div>
        <div style="padding:12px; border-top:1px solid #e5e7eb; background:#fff; display:flex; gap:8px;">
            <input id="bk-chatbot-input" type="text" placeholder="Tulis pertanyaan..."
                style="flex:1; padding:12px 14px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
            <button id="bk-chatbot-send"
                style="background:#111827; color:#fff; border:none; border-radius:8px; padding:12px 16px; font-size:14px; cursor:pointer;">Kirim</button>
        </div>
    </div>
    <button id="bk-chatbot-toggle"
        style="width:56px; height:56px; border-radius:50%; background:#111827; color:#fff; border:none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:22px;">💬</span>
    </button>

    <script>
        (function() {
            const root = document.getElementById('bk-chatbot');
            const token = root.getAttribute('data-token');
            const toggle = document.getElementById('bk-chatbot-toggle');
            const win = document.getElementById('bk-chatbot-window');
            const closeBtn = document.getElementById('bk-chatbot-close');
            const messages = document.getElementById('bk-chatbot-messages');
            const input = document.getElementById('bk-chatbot-input');
            const send = document.getElementById('bk-chatbot-send');

            function formatText(text) {
                // Escape HTML untuk keamanan
                const div = document.createElement('div');
                div.textContent = text;
                text = div.innerHTML;

                // Format kategori (📌 KATEGORI) dengan styling khusus
                text = text.replace(/(📌\s*)([A-Z\s]+)(<br>)/g,
                    '<div style="margin-top:12px; margin-bottom:8px;"><span style="font-size:18px; vertical-align:middle;">$1</span><strong style="color:#111827; font-size:15px; font-weight:700;">$2</strong></div>'
                );

                // Format nomor urut dengan indentasi (   1. pertanyaan)
                text = text.replace(/(<br>)\s{3,}(\d+\.\s)(.+?)(?=<br>|$)/g,
                    '<div style="margin-left:16px; margin-top:4px; margin-bottom:4px; padding-left:8px; border-left:2px solid #e5e7eb;"><strong style="color:#111827;">$2</strong>$3</div>'
                );

                // Replace double newlines dengan paragraf
                text = text.replace(/\n\n+/g, '</p><p style="margin:8px 0;">');

                // Replace single newlines dengan <br>
                text = text.replace(/\n/g, '<br>');

                // Wrap dengan <p> tag
                text = '<p style="margin:0;">' + text + '</p>';

                // Format nomor urut (1., 2., etc) menjadi bold jika belum diformat
                text = text.replace(/(\d+\.\s)/g, '<strong style="color:#111827;">$1</strong>');

                // Format emoji dan simbol agar lebih besar
                text = text.replace(/([📌💡▫️📋])/g, '<span style="font-size:18px; vertical-align:middle;">$1</span>');

                // Format teks yang diawali dengan "   " (indentasi) menjadi block dengan padding
                text = text.replace(/(<br>)\s{3,}(.+?)(?=<br>|$)/g,
                    '$1<span style="display:block; margin-left:16px; padding-left:8px; border-left:2px solid #e5e7eb; margin-top:4px; margin-bottom:4px;">$2</span>'
                );

                // Format pertanyaan terkait dengan styling khusus
                text = text.replace(/(💡\s*Pertanyaan terkait:)/g,
                    '<strong style="display:block; margin-top:12px; margin-bottom:8px; color:#111827; font-size:15px;">$1</strong>'
                );

                // Format bullet points (▫️) dengan styling
                text = text.replace(/(▫️\s*)(.+?)(?=<br>|$)/g,
                    '<span style="display:block; margin-top:6px; margin-bottom:6px;"><span style="font-size:16px; margin-right:6px;">▫️</span><strong style="color:#111827;">$2</strong></span>'
                );

                // Format daftar pertanyaan (📋)
                text = text.replace(/(📋\s*Berikut adalah daftar pertanyaan)/g,
                    '<strong style="display:block; margin-bottom:12px; color:#111827; font-size:15px;">$1</strong>');

                return text;
            }

            function appendBubble(text, role) {
                const wrap = document.createElement('div');
                wrap.style.margin = '10px 0';
                wrap.style.display = 'flex';
                wrap.style.justifyContent = role === 'user' ? 'flex-end' : 'flex-start';
                const bubble = document.createElement('div');
                bubble.style.maxWidth = '85%';
                bubble.style.padding = '14px 16px';
                bubble.style.borderRadius = '12px';
                bubble.style.fontSize = '14px';
                bubble.style.lineHeight = '1.6';
                bubble.style.whiteSpace = 'pre-wrap';
                bubble.style.wordBreak = 'break-word';
                bubble.style.boxShadow = '0 1px 2px rgba(0,0,0,0.1)';
                if (role === 'user') {
                    bubble.style.background = '#111827';
                    bubble.style.color = '#fff';
                } else {
                    bubble.style.background = '#ffffff';
                    bubble.style.color = '#111827';
                    bubble.style.border = '1px solid #e5e7eb';
                }

                // Format teks dengan HTML
                bubble.innerHTML = formatText(text);
                wrap.appendChild(bubble);
                messages.appendChild(wrap);
                messages.scrollTop = messages.scrollHeight;
            }

            function greet() {
                appendBubble(
                    'Halo! Saya asisten BarangKarung. Tanyakan soal pakaian, ukuran, pengiriman, atau cara belanja ya.\n\n💡 Ketik "bantuan" atau "pertanyaan" untuk melihat daftar pertanyaan yang bisa ditanyakan.',
                    'bot');
                loadQuickReplies();
            }

            function loadQuickReplies() {
                const quickReplies = document.getElementById('bk-chatbot-quick-replies');
                fetch("{{ route('chatbot.faqs') }}")
                    .then(r => r.json())
                    .then(data => {
                        if (data.faqs && data.faqs.length > 0) {
                            quickReplies.innerHTML = '';
                            quickReplies.style.display = 'flex';
                            data.faqs.forEach(faq => {
                                const btn = document.createElement('button');
                                btn.textContent = faq.question;
                                btn.style.cssText =
                                    'padding:8px 12px; font-size:12px; background:#f3f4f6; border:1px solid #e5e7eb; border-radius:6px; cursor:pointer; color:#111827; white-space:nowrap;';
                                btn.addEventListener('click', function() {
                                    input.value = faq.question;
                                    sendMessage();
                                });
                                quickReplies.appendChild(btn);
                            });
                        }
                    })
                    .catch(() => {});
            }

            toggle.addEventListener('click', function() {
                win.style.display = 'flex';
                toggle.style.display = 'none';
                if (!messages.hasChildNodes()) greet();
                input.focus();
            });
            closeBtn.addEventListener('click', function() {
                win.style.display = 'none';
                toggle.style.display = 'flex';
            });

            function sendMessage() {
                const text = (input.value || '').trim();
                if (!text) return;

                // Sembunyikan quick replies setelah user mengirim pesan
                const quickReplies = document.getElementById('bk-chatbot-quick-replies');
                quickReplies.style.display = 'none';

                appendBubble(text, 'user');
                input.value = '';
                fetch("{{ route('chatbot.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        message: text
                    })
                }).then(r => r.json()).then(data => {
                    appendBubble(data.reply || 'Maaf, terjadi kendala. Coba lagi ya.', 'bot');
                }).catch(() => {
                    appendBubble('Maaf, jaringan bermasalah. Coba lagi nanti.', 'bot');
                });
            }

            send.addEventListener('click', sendMessage);
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') sendMessage();
            });
        })();
    </script>
</div>
