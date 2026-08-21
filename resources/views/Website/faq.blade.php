@extends('Website.layouts.app')

@section('title', 'FAQ - ' . site_name())

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-20 min-h-[70vh] flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1200" 
                 alt="FAQ" 
                 class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-gray-800/80"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <!-- Breadcrumb -->
            <div class="flex items-center justify-center space-x-2 text-sm mb-8">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                <span class="text-white font-medium">FAQ</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Frequently Asked Questions
            </h1>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Find answers to common questions about buying plots with {{ site_name() }}
            </p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What documents are required to book a plot?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            You'll need a copy of your National ID Card, 2 passport-sized photos, and proof of address. For payment, you can use cash, bank transfer, or cheque. Our team will assist you with all the paperwork and documentation process to ensure a smooth transaction.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What are the payment options available?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            We offer flexible payment plans including lump sum payment, monthly installments, and quarterly installments. The down payment starts from 20% with installment periods ranging from 12 to 36 months. No hidden charges or processing fees - everything is transparent from day one.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">Are the plots legally verified and RAJUK approved?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes, all our plots are 100% legally verified with clear titles and RAJUK approved layout plans. We provide complete documentation including land deed, mutation certificate, and approval papers. Our legal team ensures every plot has no disputes or encumbrances.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">Can I visit the plot location before booking?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Absolutely! We encourage all potential buyers to visit the plot locations before making a decision. Our team can arrange site visits during weekdays and weekends. We provide free transportation for site visits and our representatives will guide you through the entire property and nearby facilities.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What happens if I miss an installment payment?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            We understand that circumstances can change. We provide a grace period of 7 days for missed payments. You'll receive SMS reminders before the due date. If you face financial difficulties, please contact our team - we can discuss payment rescheduling options to help you complete your purchase.
                        </p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">When will I receive the ownership documents?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Once you complete all payments, we'll process your ownership documents within 30 working days. This includes land deed registration, mutation, and all legal paperwork. You'll receive the original documents along with a registered deed in your name. Our team handles all the government formalities.
                        </p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What infrastructure facilities are provided?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            All our projects include paved roads, street lighting, drainage system, electricity connections, and water supply facilities. We also provide security services, children's play areas, and green spaces in selected projects. Each plot has proper boundary demarcation and corner marking.
                        </p>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">Can I resell my plot before completing payments?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes, you can transfer or resell your plot with prior approval from our management. There's a transfer fee applicable, and the new buyer must meet our standard criteria. You'll get back all your paid amounts minus any applicable charges. We facilitate smooth plot transfers with proper legal documentation.
                        </p>
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What is the expected appreciation rate?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Based on our track record, plots in our projects have shown an average appreciation of 15-20% annually. Location, infrastructure development, and market conditions influence the appreciation rate. However, past performance doesn't guarantee future returns - we recommend buying for long-term ownership rather than short-term speculation.
                        </p>
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">Do you provide after-sales support?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes! We provide comprehensive after-sales support including construction assistance, utility connection guidance, and property maintenance advice. Our customer service team is available 24/7 to address any concerns. We also organize annual meetups for plot owners to discuss community development.
                        </p>
                    </div>
                </div>

                <!-- FAQ 11 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">Is there any booking fee or advance payment?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes, to book a plot you need to pay a booking fee which is typically 10-20% of the total plot price. This amount is adjustable against the down payment. The booking fee secures your plot and starts the documentation process. It's refundable if the company fails to deliver as per agreement.
                        </p>
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 pr-8">What are the nearby amenities and facilities?</span>
                        <i class="fas fa-plus text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Our plot locations are strategically chosen near essential amenities like schools, hospitals, shopping centers, and mosques. Most projects are within 5-10 km from main highways with excellent transportation links. We provide detailed location maps showing all nearby facilities during site visits.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Still Have Questions CTA -->
            <div class="text-center mt-12 p-8 bg-white rounded-2xl shadow-lg">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-question-circle text-primary text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Still Have Questions?</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Our friendly team is here to help you 24/7. Contact us and we'll get back to you within 2 hours.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="tel:+880123456789" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition inline-flex items-center shadow-lg shadow-primary/30">
                        <i class="fas fa-phone mr-2"></i>
                        <span>Call Now</span>
                    </a>
                    <a href="{{ route('contact') }}" class="bg-gray-100 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition inline-flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>Send Message</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Trust {{ site_name() }}?</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    We've built our reputation on transparency, reliability, and exceptional service
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-primary text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">RAJUK Approved</h4>
                    <p class="text-sm text-gray-600">All projects certified</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-primary text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Award Winning</h4>
                    <p class="text-sm text-gray-600">Best Developer 2025</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-primary text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">1000+ Families</h4>
                    <p class="text-sm text-gray-600">Happy customers</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-primary text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">100% Legal</h4>
                    <p class="text-sm text-gray-600">Clear documentation</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // FAQ Toggle
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Close other open FAQs
            document.querySelectorAll('.faq-answer').forEach(item => {
                if (item !== answer) {
                    item.classList.add('hidden');
                    item.previousElementSibling.querySelector('i').classList.remove('fa-minus');
                    item.previousElementSibling.querySelector('i').classList.add('fa-plus');
                }
            });
            
            // Toggle current FAQ
            answer.classList.toggle('hidden');
            icon.classList.toggle('fa-plus');
            icon.classList.toggle('fa-minus');
        });
    });
</script>
@endpush
