    </div>

    </body>

    </html>

    {{-- Script --}}
    <script>
        function toggleAddProductForm() {
            const form = document.getElementById('addProductForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                form.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('adminDropdown');
            dropdown.classList.toggle('show');
        }

        function toggleMobileMenu() {
            const hamburgerMenu = document.getElementById('adminHamburgerMenu');
            const navMenu = document.querySelector('.nav-menu');

            if (hamburgerMenu && navMenu) {
                hamburgerMenu.classList.toggle('active');
                navMenu.classList.toggle('show');
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const hamburgerMenu = document.getElementById('adminHamburgerMenu');
            const navMenu = document.querySelector('.nav-menu');
            const header = document.querySelector('.header');

            if (hamburgerMenu && navMenu && header) {
                if (!header.contains(e.target) && navMenu.classList.contains('show')) {
                    hamburgerMenu.classList.remove('active');
                    navMenu.classList.remove('show');
                }
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                const hamburgerMenu = document.getElementById('adminHamburgerMenu');
                const navMenu = document.querySelector('.nav-menu');

                if (hamburgerMenu && navMenu) {
                    hamburgerMenu.classList.remove('active');
                    navMenu.classList.remove('show');
                }
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('adminDropdown');
            const toggle = document.querySelector('.admin-dropdown-toggle');

            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close form when clicking outside
        var addProductForm = document.getElementById('addProductForm');
        if (addProductForm) {
            addProductForm.addEventListener('click', function(e) {
                if (e.target === this) {
                    toggleAddProductForm();
                }
            });
        }

        // Close form with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const form = document.getElementById('addProductForm');
                if (form.style.display === 'flex') {
                    toggleAddProductForm();
                }
            }
        });
    </script>
