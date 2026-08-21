@extends('Website.layouts.app')

@section('title', 'Contact Us - ' . site_name())

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-20 min-h-[70vh] flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1200" 
                 alt="Contact Us" 
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
                <span class="text-white font-medium">Contact Us</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Get in Touch with Us
            </h1>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Have questions? We're here to help you find your dream plot
            </p>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Phone -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-phone text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Phone</h3>
                    <p class="text-gray-600 mb-4">Call us directly for immediate assistance</p>
                    @php
                        $phonePrimary = \App\Models\WebsiteSetting::get('phone_primary', '+880 1322-902986');
                        $phoneSecondary = \App\Models\WebsiteSetting::get('phone_secondary', '+880 1322-902987');
                        $officeHours = \App\Models\WebsiteSetting::get('office_hours', '9 AM - 9 PM (Daily)');
                    @endphp
                    <a href="tel:{{ str_replace([' ', '-'], '', $phonePrimary) }}" class="text-primary font-bold hover:text-primary-dark transition">
                        {{ $phonePrimary }}
                    </a>
                    @if($phoneSecondary)
                        <br>
                        <a href="tel:{{ str_replace([' ', '-'], '', $phoneSecondary) }}" class="text-primary font-bold hover:text-primary-dark transition">
                            {{ $phoneSecondary }}
                        </a>
                    @endif
                    <p class="text-sm text-gray-500 mt-3">Available: {{ $officeHours }}</p>
                </div>

                <!-- Email -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30">
                        <i class="fas fa-envelope text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Email</h3>
                    <p class="text-gray-600 mb-4">Send us your queries anytime</p>
                    @php
                        $contactEmail = \App\Models\WebsiteSetting::get('contact_email', 'info@londonabd.com');
                        $supportEmail = \App\Models\WebsiteSetting::get('support_email_contact', 'help@londonabd.com');
                    @endphp
                    <a href="mailto:{{ $contactEmail }}" class="text-primary font-bold hover:text-primary-dark transition">
                        {{ $contactEmail }}
                    </a>
                    @if($supportEmail)
                        <br>
                        <a href="mailto:{{ $supportEmail }}" class="text-primary font-bold hover:text-primary-dark transition">
                            {{ $supportEmail }}
                        </a>
                    @endif
                    <p class="text-sm text-gray-500 mt-3">Response within 2 hours</p>
                </div>

                <!-- Office -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-purple-500/30">
                        <i class="fas fa-map-marker-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Office</h3>
                    <p class="text-gray-600 mb-4">Visit our office for in-person consultation</p>
                    @php
                        $officeAddress = \App\Models\WebsiteSetting::get('office_address', "House #123, Road #4\nDhanmondi, Dhaka-1205\nBangladesh");
                        $officeHoursDisplay = \App\Models\WebsiteSetting::get('office_hours', 'Saturday - Thursday');
                    @endphp
                    <p class="text-gray-700 font-semibold">
                        {!! nl2br(e($officeAddress)) !!}
                    </p>
                    <p class="text-sm text-gray-500 mt-3">Open: {{ $officeHoursDisplay }}</p>
                </div>
            </div>

            <!-- Contact Form and Map Section -->
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <!-- Contact Form -->
                <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Send Us a Message</h2>
                    <p class="text-gray-600 mb-8">Fill out the form below and we'll get back to you within 24 hours</p>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                                <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                       placeholder="John">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                                <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                       placeholder="Doe">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="john@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" required value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="+880 1XXX-XXXXXX">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                            <select name="subject" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                                <option value="">Select a subject</option>
                                <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="plot" {{ old('subject') == 'plot' ? 'selected' : '' }}>Plot Information</option>
                                <option value="booking" {{ old('subject') == 'booking' ? 'selected' : '' }}>Booking Query</option>
                                <option value="payment" {{ old('subject') == 'payment' ? 'selected' : '' }}>Payment Related</option>
                                <option value="visit" {{ old('subject') == 'visit' ? 'selected' : '' }}>Site Visit Request</option>
                                <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                            <textarea name="message" rows="5" required 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"
                                      placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-primary text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-lg shadow-primary/30 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span>Send Message</span>
                        </button>

                        <p class="text-sm text-gray-500 text-center">
                            We respect your privacy. Your information is safe with us.
                        </p>
                    </form>
                </div>

                <!-- Map and Additional Info -->
                <div class="space-y-8">
                    <!-- Map -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="h-80 bg-gray-200">
                            @php
                                $googleMapEmbed = \App\Models\WebsiteSetting::get('google_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.0947347290393!2d90.37611831498185!3d23.74394298459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhanmondi%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1234567890123!5m2!1sen!2sbd');
                            @endphp
                            <iframe 
                                src="{{ $googleMapEmbed }}" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gradient-to-br from-primary to-primary-dark p-8 rounded-2xl text-white shadow-xl">
                        <h3 class="text-2xl font-bold mb-6">Quick Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('plots.index') }}" 
                               class="flex items-center justify-between p-4 bg-white/10 rounded-lg hover:bg-white/20 transition group">
                                <span class="font-semibold">Browse Available Plots</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="{{ route('faq') }}" 
                               class="flex items-center justify-between p-4 bg-white/10 rounded-lg hover:bg-white/20 transition group">
                                <span class="font-semibold">View FAQs</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="{{ route('about') }}" 
                               class="flex items-center justify-between p-4 bg-white/10 rounded-lg hover:bg-white/20 transition group">
                                <span class="font-semibold">About Our Company</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white p-8 rounded-2xl shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Follow Us</h3>
                        <p class="text-gray-600 mb-6">Stay connected on social media for latest updates</p>
                        @php
                            $facebookUrl = \App\Models\WebsiteSetting::get('facebook_url', 'https://www.facebook.com/londonabasonbd');
                            $twitterUrl = \App\Models\WebsiteSetting::get('twitter_url', '');
                            $instagramUrl = \App\Models\WebsiteSetting::get('instagram_url', '');
                            $linkedinUrl = \App\Models\WebsiteSetting::get('linkedin_url', '');
                            $youtubeUrl = \App\Models\WebsiteSetting::get('youtube_url', '');
                        @endphp
                        <div class="flex space-x-4">
                            @if($facebookUrl)
                                <a href="{{ $facebookUrl }}" target="_blank" class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white hover:bg-blue-700 transition">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </a>
                            @endif
                            @if($twitterUrl)
                                <a href="{{ $twitterUrl }}" target="_blank" class="w-12 h-12 bg-sky-500 rounded-lg flex items-center justify-center text-white hover:bg-sky-600 transition">
                                    <i class="fab fa-twitter text-xl"></i>
                                </a>
                            @endif
                            @if($instagramUrl)
                                <a href="{{ $instagramUrl }}" target="_blank" class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center text-white hover:bg-pink-700 transition">
                                    <i class="fab fa-instagram text-xl"></i>
                                </a>
                            @endif
                            @if($linkedinUrl)
                                <a href="{{ $linkedinUrl }}" target="_blank" class="w-12 h-12 bg-blue-700 rounded-lg flex items-center justify-center text-white hover:bg-blue-800 transition">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                            @endif
                            @if($youtubeUrl)
                                <a href="{{ $youtubeUrl }}" target="_blank" class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center text-white hover:bg-red-700 transition">
                                    <i class="fab fa-youtube text-xl"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Hours Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Business Hours</h2>
                <p class="text-gray-600 text-lg">We're here when you need us</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-primary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Office Hours</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">Saturday - Thursday:</span>
                            <span class="text-gray-900 font-bold">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">Friday:</span>
                            <span class="text-gray-900 font-bold">Closed</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">Public Holidays:</span>
                            <span class="text-gray-900 font-bold">Closed</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-primary/5 to-white p-8 rounded-2xl border border-primary/20">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-phone-volume text-primary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Call Center</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">Phone Support:</span>
                            <span class="text-gray-900 font-bold">24/7 Available</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">WhatsApp:</span>
                            <span class="text-gray-900 font-bold">24/7 Available</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700 font-medium">Email Response:</span>
                            <span class="text-gray-900 font-bold">Within 2 hours</span>
                        </div>
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to Find Your Perfect Plot?
            </h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Let's discuss your requirements and find the ideal plot for your dream home
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('plots.index') }}" class="bg-primary text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-xl transform hover:scale-105 inline-flex items-center space-x-2">
                    <i class="fas fa-search"></i>
                    <span>Browse Plots</span>
                </a>
                <a href="tel:+8801XXXXXXXXX" class="bg-white text-primary px-10 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-xl inline-flex items-center space-x-2">
                    <i class="fas fa-phone"></i>
                    <span>Call Us Now</span>
                </a>
            </div>
        </div>
    </section>
@endsection
