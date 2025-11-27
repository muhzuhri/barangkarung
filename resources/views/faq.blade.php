@extends('layouts.app')

@section('title', 'FAQ - BarangKarung')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Pertanyaan yang Sering Ditanyakan</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div id="faq-content">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat FAQ...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch("{{ route('chatbot.all-faqs') }}")
        .then(response => response.json())
        .then(data => {
            const faqContent = document.getElementById('faq-content');

            if (data.faqs && data.faqs.length > 0) {
                // Group FAQs by category
                const grouped = {};
                data.faqs.forEach(faq => {
                    if (!grouped[faq.category]) {
                        grouped[faq.category] = [];
                    }
                    grouped[faq.category].push(faq);
                });

                let html = '';
                for (const [category, faqs] of Object.entries(grouped)) {
                    html += `
                        <div class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4 text-blue-600 border-b-2 border-blue-200 pb-2">
                                📌 ${category.toUpperCase()}
                            </h2>
                            <div class="space-y-4">
                    `;

                    faqs.forEach((faq, index) => {
                        html += `
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button class="w-full text-left p-4 bg-gray-50 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 faq-toggle" data-target="faq-${faq.id}">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-800">${index + 1}. ${faq.question}</span>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>
                                <div id="faq-${faq.id}" class="faq-answer hidden p-4 bg-white border-t border-gray-200">
                                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">${faq.answer}</div>
                                </div>
                            </div>
                        `;
                    });

                    html += `
                            </div>
                        </div>
                    `;
                }

                faqContent.innerHTML = html;

                // Add click handlers for FAQ toggles
                document.querySelectorAll('.faq-toggle').forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const answer = document.getElementById(targetId);
                        const icon = this.querySelector('.faq-icon');

                        if (answer.classList.contains('hidden')) {
                            answer.classList.remove('hidden');
                            icon.classList.add('rotate-180');
                        } else {
                            answer.classList.add('hidden');
                            icon.classList.remove('rotate-180');
                        }
                    });
                });
            } else {
                faqContent.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada FAQ</h3>
                        <p class="text-gray-600">FAQ akan segera ditambahkan oleh admin.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading FAQs:', error);
            document.getElementById('faq-content').innerHTML = `
                <div class="text-center py-12">
                    <div class="text-red-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gagal Memuat FAQ</h3>
                    <p class="text-gray-600">Terjadi kesalahan saat memuat FAQ. Silakan coba lagi nanti.</p>
                </div>
            `;
        });
});
</script>

<style>
.faq-icon.rotate-180 {
    transform: rotate(180deg);
}

.faq-answer {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 1000px;
    }
}
</style>
@endsection
