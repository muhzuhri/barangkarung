    </div>

</body>

</html>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('adminDropdown');
        dropdown.classList.toggle('show');
    }

    function toggleMobileMenu() {
        // Mobile menu functionality can be added here
        alert('Mobile menu akan ditambahkan');
    }

    function toggleAddProductForm() {
        const modal = document.getElementById('addProductModal');
        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
        }
    }

    function resetForm() {
        document.getElementById('addProductForm').reset();
        document.getElementById('loadingIndicator').style.display = 'none';
        document.getElementById('submitBtn').disabled = false;
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('adminDropdown');
        const toggle = document.querySelector('.admin-dropdown-toggle');

        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Close modal when clicking outside
    document.getElementById('addProductModal').addEventListener('click', function(e) {
        if (e.target === this) {
            toggleAddProductForm();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('addProductModal');
            if (modal.style.display === 'flex') {
                toggleAddProductForm();
            }
        }
    });

    // Handle form submission
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');

        // Show loading state
        submitBtn.disabled = true;
        loadingIndicator.style.display = 'block';

        // Send AJAX request
        fetch('{{ route('admin.products.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Produk berhasil ditambahkan!', 'success');

                    // Close modal
                    toggleAddProductForm();

                    // Reload page to show new product
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showNotification(data.message || 'Terjadi kesalahan saat menyimpan produk', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menyimpan produk', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.disabled = false;
                loadingIndicator.style.display = 'none';
            });
    });

    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '3000';
        notification.style.minWidth = '300px';
        notification.style.padding = '1rem';
        notification.style.borderRadius = '8px';
        notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>


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

    // Initialize Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const monthlyRevenueData = @json($monthlyRevenue);

    const labels = monthlyRevenueData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });

    const data = monthlyRevenueData.map(item => parseFloat(item.revenue));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    // Initialize Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const monthlyOrdersData = @json($monthlyOrders);
    const ordersLabels = monthlyOrdersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const ordersCounts = monthlyOrdersData.map(item => parseInt(item.count, 10));
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ordersLabels,
            datasets: [{
                label: 'Orders',
                data: ordersCounts,
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    // Initialize Users Chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const monthlyUsersData = @json($monthlyUsers);
    const usersLabels = monthlyUsersData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const usersCounts = monthlyUsersData.map(item => parseInt(item.count, 10));
    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: usersLabels,
            datasets: [{
                label: 'User Baru',
                data: usersCounts,
                backgroundColor: 'rgba(99, 102, 241, 0.5)',
                borderColor: 'rgb(99, 102, 241)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    // Initialize Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    const monthlyProductsData = @json($monthlyProducts);
    const productsLabels = monthlyProductsData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('id-ID', {
            month: 'short',
            year: 'numeric'
        });
    });
    const productsCounts = monthlyProductsData.map(item => parseInt(item.count, 10));
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: productsLabels,
            datasets: [{
                label: 'Produk Baru',
                data: productsCounts,
                backgroundColor: 'rgba(234, 179, 8, 0.5)',
                borderColor: 'rgb(234, 179, 8)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>