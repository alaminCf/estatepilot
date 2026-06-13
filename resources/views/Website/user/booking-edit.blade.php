@extends('Website.user.layouts.account')

@section('title', 'Edit Booking - London Abason')

@section('account_content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('account.bookings') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Booking</h1>
        </div>
        <p class="text-gray-600">Update your pending booking details</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                <p class="text-red-800 font-semibold">Please fix the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-red-700 space-y-1 ml-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('account.bookings.update', $booking) }}" method="POST" id="editBookingForm">
        @csrf
        @method('PUT')

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left: Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Plot Selection -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-map-marked-alt text-primary mr-2"></i>Select Plot
                    </h2>

                    <div>
                        <label for="plot_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Plot <span class="text-red-500">*</span>
                        </label>
                        <select name="plot_id" id="plot_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('plot_id') border-red-500 @enderror"
                                onchange="handlePlotChange()">
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}" 
                                        data-price="{{ $plot->price }}" 
                                        data-booking-payment="{{ $plot->booking_payment }}"
                                        data-size="{{ $plot->size_katha }}"
                                        data-block="{{ $plot->block }}"
                                        data-facing="{{ $plot->facing }}"
                                        data-road="{{ $plot->road_no }}"
                                        data-status="{{ $plot->status }}"
                                        {{ old('plot_id', $booking->plot_id) == $plot->id ? 'selected' : '' }}>
                                    Plot #{{ $plot->plot_no }} — {{ $plot->size_katha }} Katha — Block {{ $plot->block }} — ৳{{ format_bd_number($plot->price, 0) }}
                                    @if($plot->id == $booking->plot_id) (Current) @endif
                                    @if($plot->status === 'available' && $plot->id != $booking->plot_id) (Available) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('plot_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selected Plot Info -->
                    <div id="plotInfo" class="mt-4 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500">Size:</span>
                                <span class="font-semibold text-gray-900 ml-1" id="plotSize">{{ $booking->plot->size_katha }} Katha</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Block:</span>
                                <span class="font-semibold text-gray-900 ml-1" id="plotBlock">{{ $booking->plot->block }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Facing:</span>
                                <span class="font-semibold text-gray-900 ml-1" id="plotFacing">{{ $booking->plot->facing }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Road:</span>
                                <span class="font-semibold text-gray-900 ml-1" id="plotRoad">{{ $booking->plot->road_no ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Type -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-credit-card text-primary mr-2"></i>Payment Plan
                    </h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Payment Type <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col items-center p-5 border-2 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group
                                {{ old('payment_type', $booking->installment_plan ? 'installment' : 'one_time') === 'one_time' ? 'border-primary bg-gradient-to-br from-primary/5 to-blue-50 shadow-lg' : 'border-gray-200' }}" id="oneTimeLabel">
                                <input type="radio" name="payment_type" value="one_time" class="sr-only" onchange="handlePaymentTypeChange()" required
                                    {{ old('payment_type', $booking->installment_plan ? 'installment' : 'one_time') === 'one_time' ? 'checked' : '' }}>
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-gray-900 text-base mb-1">One Time</div>
                                    <div class="text-xs text-gray-500">Full payment at once</div>
                                </div>
                            </label>
                            <label class="relative flex flex-col items-center p-5 border-2 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group
                                {{ old('payment_type', $booking->installment_plan ? 'installment' : 'one_time') === 'installment' ? 'border-primary bg-gradient-to-br from-primary/5 to-green-50 shadow-lg' : 'border-gray-200' }}" id="installmentLabel">
                                <input type="radio" name="payment_type" value="installment" class="sr-only" onchange="handlePaymentTypeChange()" required
                                    {{ old('payment_type', $booking->installment_plan ? 'installment' : 'one_time') === 'installment' ? 'checked' : '' }}>
                                <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-gray-900 text-base mb-1">Installment</div>
                                    <div class="text-xs text-gray-500">Pay in monthly/quarterly</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Installment Options -->
                    <div id="installmentPlanSection" class="{{ old('payment_type', $booking->installment_plan ? 'installment' : 'one_time') === 'installment' ? '' : 'hidden' }} mt-4 space-y-4">
                        <div>
                            <label for="installment_plan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Installment Plan <span class="text-red-500">*</span>
                            </label>
                            <select name="installment_plan" id="installmentPlan"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    onchange="calculateInstallment()">
                                <option value="">Select installment plan</option>
                                <option value="monthly" {{ old('installment_plan', $booking->installment_plan) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('installment_plan', $booking->installment_plan) === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            </select>
                        </div>

                        <div>
                            <label for="total_installments" class="block text-sm font-semibold text-gray-700 mb-2">
                                Number of Installments <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_installments" id="totalInstallments" min="1"
                                   value="{{ old('total_installments', $booking->total_installments) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="Enter number of installments" onchange="calculateInstallment()" oninput="calculateInstallment()">
                        </div>
                    </div>

                    <hr class="border-gray-200 mt-6">

                    <!-- Booking Money Option -->
                    @php
                        $currentBookingMoneyOption = old('booking_money_option', $booking->custom_booking_amount ? 'custom' : 'full');
                    @endphp
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Booking Money Option <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 gap-3">
                            <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group
                                {{ $currentBookingMoneyOption === 'full' ? 'border-primary bg-gradient-to-br from-primary/5 to-blue-50 shadow-lg' : 'border-gray-200' }}" id="fullBookingLabel">
                                <input type="radio" name="booking_money_option" value="full" class="sr-only" onchange="handleBookingMoneyOptionChange()" required
                                    {{ $currentBookingMoneyOption === 'full' ? 'checked' : '' }}>
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-money-bill-wave text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-sm">Paying Full Booking Money</div>
                                    <div class="text-xs text-gray-500">Pay full booking amount as specified by the plot</div>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group
                                {{ $currentBookingMoneyOption === 'custom' ? 'border-primary bg-gradient-to-br from-primary/5 to-orange-50 shadow-lg' : 'border-gray-200' }}" id="customBookingLabel">
                                <input type="radio" name="booking_money_option" value="custom" class="sr-only" onchange="handleBookingMoneyOptionChange()" required
                                    {{ $currentBookingMoneyOption === 'custom' ? 'checked' : '' }}>
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-hand-holding-usd text-orange-600 text-lg"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-sm">I want to pay other amount for booking money</div>
                                    <div class="text-xs text-gray-500">Pay a partial amount now (Pre-Booking)</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Custom Booking Amount -->
                    <div id="customBookingAmountSection" class="{{ $currentBookingMoneyOption === 'custom' ? '' : 'hidden' }} mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Enter Your Booking Amount (৳) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="custom_booking_amount" id="customBookingAmount" min="1" step="0.01"
                               value="{{ old('custom_booking_amount', $booking->custom_booking_amount) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Enter amount you want to pay"
                               onchange="updateCustomBookingDisplay()" oninput="updateCustomBookingDisplay()">
                        <p class="text-xs text-gray-500 mt-1">Amount must be less than the full booking money</p>
                        @error('custom_booking_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pre-Booking Notice -->
                    <div id="preBookingNotice" class="{{ $currentBookingMoneyOption === 'custom' ? '' : 'hidden' }} mt-4">
                        <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-amber-500 text-xl mt-0.5 flex-shrink-0"></i>
                                <div class="ml-3">
                                    <h4 class="text-sm font-bold text-amber-800">Pre-Booking Notice</h4>
                                    <p class="text-sm text-amber-700 mt-1">
                                        This booking will be valid for <strong>15 days</strong>. If the full booking money is not paid before this timeline, the booking will be cancelled automatically.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Referral Agent & Additional Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-primary mr-2"></i>Other Details
                    </h2>

                    <div class="space-y-4">
                        <!-- Referral Agent -->
                        <div>
                            <label for="referral_agent_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Referral Agent
                            </label>
                            <select name="referral_agent_id" id="referral_agent_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">No agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('referral_agent_id', $booking->referral_agent_id) == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }} ({{ $agent->referral_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label for="additional_info" class="block text-sm font-semibold text-gray-700 mb-2">
                                Additional Information
                            </label>
                            <textarea name="additional_info" id="additional_info" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none @error('additional_info') border-red-500 @enderror"
                                      placeholder="Any special requests or information...">{{ old('additional_info', $booking->additional_info) }}</textarea>
                            @error('additional_info')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Owners -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-users text-primary mr-2"></i>Additional Owners
                        </h2>
                        <button type="button" id="addOwnerBtn"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition">
                            <i class="fas fa-plus"></i> Add Additional Owner
                        </button>
                    </div>

                    <div id="ownersContainer" class="space-y-4"></div>

                    <div id="noOwnersMessage" class="hidden border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-gray-50">
                        <i class="fas fa-user-friends text-3xl text-gray-300 mb-2 block"></i>
                        <p class="text-gray-400 text-sm">No additional owners added. Click "Add Additional Owner" to add one.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Update Booking
                    </button>
                    <a href="{{ route('account.bookings') }}"
                       class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Right: Payment Overview Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-calculator text-primary mr-2"></i>Payment Overview
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Total Plot Price:</span>
                            <span class="font-bold text-gray-900" id="overviewPrice">৳{{ format_bd_number($booking->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Booking Money:</span>
                            <span class="font-semibold text-primary" id="overviewBookingPayment">৳{{ format_bd_number($booking->booking_payment, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Remaining Amount:</span>
                            <span class="font-semibold text-gray-900" id="overviewRemaining">৳{{ format_bd_number($booking->remaining_payment, 2) }}</span>
                        </div>

                        <!-- Custom Booking Amount Overview -->
                        <div id="customBookingOverview" class="{{ $booking->custom_booking_amount ? '' : 'hidden' }} space-y-2 pt-2 border-t-2 border-orange-300">
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Your Booking Amount:</span>
                                <span class="font-bold text-orange-600" id="customAmountDisplay">৳{{ $booking->custom_booking_amount ? format_bd_number($booking->custom_booking_amount, 2) : '0' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Remaining Booking Money:</span>
                                <span class="font-semibold text-gray-900" id="remainingBookingMoneyDisplay">৳{{ $booking->custom_booking_amount ? format_bd_number($booking->booking_payment - $booking->custom_booking_amount, 2) : '0' }}</span>
                            </div>
                        </div>

                        <!-- Installment Details -->
                        <div id="installmentDetails" class="{{ $booking->installment_plan ? '' : 'hidden' }} space-y-2 pt-2 border-t-2 border-primary/30">
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Payment Plan:</span>
                                <span class="font-semibold text-primary" id="planType">{{ ucfirst($booking->installment_plan ?? '-') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Per Installment:</span>
                                <span class="font-bold text-lg text-primary" id="perInstallment">৳{{ $booking->installment_payment ? format_bd_number($booking->installment_payment, 2) : '0' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Total Installments:</span>
                                <span class="font-semibold text-gray-900" id="totalInstallmentsDisplay">{{ $booking->total_installments ?? '0' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold text-gray-900" id="duration">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Booking Date:</span>
                                <span class="font-semibold text-gray-900">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
                                    @endif">{{ ucfirst($booking->status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function getSelectedPlotData() {
            const select = document.getElementById('plot_id');
            const option = select.options[select.selectedIndex];
            return {
                price: parseFloat(option.dataset.price) || 0,
                bookingPayment: parseFloat(option.dataset.bookingPayment) || 0
            };
        }

        function handlePlotChange() {
            const select = document.getElementById('plot_id');
            const option = select.options[select.selectedIndex];
            
            const plot = getSelectedPlotData();
            const remaining = plot.price - plot.bookingPayment;

            // Update plot info
            document.getElementById('plotSize').textContent = option.dataset.size + ' Katha';
            document.getElementById('plotBlock').textContent = option.dataset.block;
            document.getElementById('plotFacing').textContent = option.dataset.facing;
            document.getElementById('plotRoad').textContent = option.dataset.road || 'N/A';

            // Update payment overview
            document.getElementById('overviewPrice').textContent = '৳' + plot.price.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('overviewBookingPayment').textContent = '৳' + plot.bookingPayment.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('overviewRemaining').textContent = '৳' + remaining.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            calculateInstallment();
            updateCustomBookingDisplay();
        }

        function handlePaymentTypeChange() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
            const installmentSection = document.getElementById('installmentPlanSection');
            const installmentDetails = document.getElementById('installmentDetails');
            const oneTimeLabel = document.getElementById('oneTimeLabel');
            const installmentLabel = document.getElementById('installmentLabel');

            // Reset styles
            oneTimeLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
            installmentLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-green-50', 'shadow-lg');

            if (paymentType === 'installment') {
                installmentSection.classList.remove('hidden');
                installmentLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-green-50', 'shadow-lg');
                document.getElementById('installmentPlan').setAttribute('required', 'required');
                document.getElementById('totalInstallments').setAttribute('required', 'required');
                calculateInstallment();
            } else {
                installmentSection.classList.add('hidden');
                installmentDetails.classList.add('hidden');
                oneTimeLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
                document.getElementById('installmentPlan').removeAttribute('required');
                document.getElementById('totalInstallments').removeAttribute('required');
            }
        }

        function handleBookingMoneyOptionChange() {
            const option = document.querySelector('input[name="booking_money_option"]:checked')?.value;
            const customSection = document.getElementById('customBookingAmountSection');
            const preBookingNotice = document.getElementById('preBookingNotice');
            const customOverview = document.getElementById('customBookingOverview');
            const fullBookingLabel = document.getElementById('fullBookingLabel');
            const customBookingLabel = document.getElementById('customBookingLabel');

            // Reset styles
            fullBookingLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
            customBookingLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-orange-50', 'shadow-lg');

            if (option === 'custom') {
                customSection.classList.remove('hidden');
                preBookingNotice.classList.remove('hidden');
                customOverview.classList.remove('hidden');
                customBookingLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-orange-50', 'shadow-lg');
                document.getElementById('customBookingAmount').setAttribute('required', 'required');
                updateCustomBookingDisplay();
            } else {
                customSection.classList.add('hidden');
                preBookingNotice.classList.add('hidden');
                customOverview.classList.add('hidden');
                fullBookingLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
                document.getElementById('customBookingAmount').removeAttribute('required');
                document.getElementById('customBookingAmount').value = '';
            }
        }

        function updateCustomBookingDisplay() {
            const plot = getSelectedPlotData();
            const customAmount = parseFloat(document.getElementById('customBookingAmount').value) || 0;
            const remainingBooking = plot.bookingPayment - customAmount;

            document.getElementById('customAmountDisplay').textContent = '৳' + customAmount.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('remainingBookingMoneyDisplay').textContent = '৳' + Math.max(0, remainingBooking).toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function calculateInstallment() {
            const installmentPlan = document.getElementById('installmentPlan').value;
            const totalInstallments = parseInt(document.getElementById('totalInstallments').value) || 0;
            const installmentDetails = document.getElementById('installmentDetails');

            if (!installmentPlan || !totalInstallments) {
                installmentDetails.classList.add('hidden');
                return;
            }

            const select = document.getElementById('plot_id');
            const option = select.options[select.selectedIndex];
            const price = parseFloat(option.dataset.price) || 0;
            const bookingPayment = parseFloat(option.dataset.bookingPayment) || 0;
            const remainingAmount = price - bookingPayment;
            const perInstallment = remainingAmount / totalInstallments;

            // Calculate duration
            let duration = '';
            if (installmentPlan === 'monthly') {
                const years = Math.floor(totalInstallments / 12);
                const months = totalInstallments % 12;
                if (years > 0) duration += years + (years === 1 ? ' Year' : ' Years');
                if (months > 0) duration += (years > 0 ? ' ' : '') + months + (months === 1 ? ' Month' : ' Months');
            } else if (installmentPlan === 'quarterly') {
                const years = Math.floor(totalInstallments / 4);
                const quarters = totalInstallments % 4;
                if (years > 0) duration += years + (years === 1 ? ' Year' : ' Years');
                if (quarters > 0) duration += (years > 0 ? ' ' : '') + quarters + (quarters === 1 ? ' Quarter' : ' Quarters');
            }

            document.getElementById('planType').textContent = installmentPlan.charAt(0).toUpperCase() + installmentPlan.slice(1);
            document.getElementById('perInstallment').textContent = '৳' + perInstallment.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totalInstallmentsDisplay').textContent = totalInstallments;
            document.getElementById('duration').textContent = duration || '-';

            installmentDetails.classList.remove('hidden');
        }

        // ---- Additional Owners ----
        let ownerIndex = 0;
        const existingOwners = @json($booking->owners ?? []);

        function createOwnerCard(index, data) {
            data = data || {};
            return `<div class="border border-gray-200 rounded-xl p-4 bg-gray-50" id="ownerCard${index}">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-800"><i class="fas fa-user text-primary mr-2"></i>Additional Owner <span class="owner-number"></span></h4>
                    <button type="button" class="remove-owner-btn text-red-500 hover:text-red-700 text-sm flex items-center gap-1 transition" data-index="${index}">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="owners[${index}][name]" value="${data.name || ''}" required placeholder="Full name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="owners[${index}][phone]" value="${data.phone || ''}" required placeholder="Phone number"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">NID Number <span class="text-red-500">*</span></label>
                        <input type="text" name="owners[${index}][nid]" value="${data.nid || ''}" required placeholder="NID number"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Address <span class="text-red-500">*</span></label>
                        <input type="text" name="owners[${index}][address]" value="${data.address || ''}" required placeholder="Address"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Father's Name</label>
                        <input type="text" name="owners[${index}][father_name]" value="${data.father_name || ''}" placeholder="Father's name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Mother's Name</label>
                        <input type="text" name="owners[${index}][mother_name]" value="${data.mother_name || ''}" placeholder="Mother's name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Spouse's Name</label>
                        <input type="text" name="owners[${index}][spouse_name]" value="${data.spouse_name || ''}" placeholder="Spouse's name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nominee Info</label>
                        <textarea name="owners[${index}][nominee_info]" rows="3" placeholder="Nominee name, relation, NID, phone, address, etc."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">${data.nominee_info || ''}</textarea>
                    </div>
                </div>
            </div>`;
        }

        function updateOwnerNumbers() {
            const cards = document.querySelectorAll('#ownersContainer > div[id^="ownerCard"]');
            cards.forEach((card, i) => {
                card.querySelector('.owner-number').textContent = '#' + (i + 1);
            });
            const noMsg = document.getElementById('noOwnersMessage');
            if (cards.length === 0) {
                noMsg.classList.remove('hidden');
            } else {
                noMsg.classList.add('hidden');
            }
        }

        document.getElementById('addOwnerBtn').addEventListener('click', function() {
            const container = document.getElementById('ownersContainer');
            container.insertAdjacentHTML('beforeend', createOwnerCard(ownerIndex));
            ownerIndex++;
            updateOwnerNumbers();
        });

        document.getElementById('ownersContainer').addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-owner-btn');
            if (btn) {
                const idx = btn.dataset.index;
                document.getElementById('ownerCard' + idx).remove();
                updateOwnerNumbers();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateInstallment();
            // Pre-populate existing owners
            existingOwners.forEach(function(owner) {
                const container = document.getElementById('ownersContainer');
                container.insertAdjacentHTML('beforeend', createOwnerCard(ownerIndex, owner));
                ownerIndex++;
            });
            updateOwnerNumbers();
        });
    </script>
@endsection
