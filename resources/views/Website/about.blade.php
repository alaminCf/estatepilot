@extends('Website.layouts.app')

@section('title', 'About Us - London Abason')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-20 min-h-[70vh] flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200" 
                 alt="About London Abason" 
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
                <span class="text-white font-medium">About Us</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                About London Abason
            </h1>
            <div class="w-24 h-1 bg-primary mx-auto"></div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="space-y-6">
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider">Our Story</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Your Trusted Partner in
                        <span class="text-primary">Real Estate</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Founded with a vision to provide quality residential plots to aspiring homeowners, London Abason Limited has grown to become one of Bangladesh's most trusted real estate developers.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Our journey began with a simple mission: to make land ownership accessible and transparent for everyone. Over the years, we have successfully delivered hundreds of projects, creating thriving communities across the country.
                    </p>
                    <div class="pt-4">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Customer-Centric Approach</h4>
                                <p class="text-gray-600">We prioritize customer satisfaction in every aspect of our service.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Transparency & Trust</h4>
                                <p class="text-gray-600">100% legal documentation with complete transparency in all transactions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800" 
                             alt="London Abason Office" 
                             class="w-full h-[500px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-3xl opacity-90 flex items-center justify-center shadow-2xl animate-bounce-slow">
                        <i class="fas fa-home text-white text-4xl opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Our Purpose</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Mission & Vision</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Mission -->
                <div class="bg-gradient-to-br from-primary to-primary-dark p-10 rounded-3xl text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-bullseye text-white text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Our Mission</h3>
                        <p class="text-green-100 text-lg leading-relaxed">
                            To provide affordable, legally verified, and strategically located residential plots to aspiring homeowners, ensuring complete transparency, excellent customer service, and long-term value creation for our clients.
                        </p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-10 rounded-3xl text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-eye text-white text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Our Vision</h3>
                        <p class="text-gray-300 text-lg leading-relaxed">
                            To become Bangladesh's most trusted and customer-friendly real estate developer, recognized for creating sustainable communities and making land ownership accessible to families across the nation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">What Drives Us</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Our Core Values</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    The principles that guide everything we do
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Integrity</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We operate with complete honesty and transparency, ensuring our clients always know exactly what they're getting.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gem text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Excellence</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We strive for excellence in every project, from plot selection to documentation and customer service.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-handshake text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Trust</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Building lasting relationships based on trust, reliability, and consistent delivery of our promises.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Innovation</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Continuously improving our processes and services to provide better value to our customers.
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Community</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Creating more than just plots - we build communities where families can thrive together.
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Sustainability</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Committed to environmentally responsible development that benefits current and future generations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Why Us</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">What Makes Us Different</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">100% Legal</h4>
                        <p class="text-gray-600 text-sm">All plots are legally verified with clear documentation.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-credit-card text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">Flexible Payment</h4>
                        <p class="text-gray-600 text-sm">Easy installment plans tailored to your budget.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marked-alt text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">Prime Locations</h4>
                        <p class="text-gray-600 text-sm">Strategic locations with excellent connectivity.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-headset text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">24/7 Support</h4>
                        <p class="text-gray-600 text-sm">Dedicated customer service team always available.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">High ROI</h4>
                        <p class="text-gray-600 text-sm">15-20% annual appreciation guaranteed.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="flex items-start space-x-4 p-6 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-certificate text-primary text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">RAJUK Approved</h4>
                        <p class="text-gray-600 text-sm">All projects are officially approved and certified.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Ready to Find Your Perfect Plot?
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Join thousands of happy families who have already secured their dream plots with London Abason Limited.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('plots.index') }}" class="bg-primary text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-xl transform hover:scale-105 inline-flex items-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Browse Available Plots</span>
                    </a>
                    <a href="{{ route('home') }}#contact" class="bg-white text-primary px-10 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-xl inline-flex items-center space-x-2">
                        <i class="fas fa-phone"></i>
                        <span>Contact Us Today</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
