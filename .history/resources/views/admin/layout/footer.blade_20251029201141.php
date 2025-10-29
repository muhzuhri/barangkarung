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
        // Mobile menu functionality can be added here
        alert('Mobile menu akan ditambahkan');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('adminDropdown');
        const toggle = document.querySelector('.admin-dropdown-toggle');

        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Close form when clicking outside
    document.getElementById('addProductForm').addEventListener('click', function(e) {
        if (e.target === this) {
            toggleAddProductForm();
        }
    });

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