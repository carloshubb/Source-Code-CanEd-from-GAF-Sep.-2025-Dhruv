@php
$defaultLang = getDefaultLanguage(1);
$page = '';
if (!empty($slug) && $slug != $defaultLang->abbreviation) {
$page = App\Models\Page::with([
'pageDetail' => function ($q) use ($defaultLang) {
$q->where('language_id', $defaultLang->id);
},
])
->where('slug', $slug)
->first();
} elseif (!empty($lange) && $lange == $defaultLang->abbreviation) {
$page = App\Models\Page::with([
'pageDetail' => function ($q) use ($defaultLang) {
$q->where('language_id', $defaultLang->id);
},
])
->where('set_as_home', 1)
->first();
}
@endphp
@extends($page == '' || $page == null ? 'front.layouts.app' : 'front.layouts.app')

@section('content')

<section class="py-10 bg-white-100">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow space-y-8">
        {{-- Coffee Wall Section --}}

        <div class="pb-2">
            <h1 class="text-red-700">Coffee on the Wall</h1>
        </div>
        <div class="pb-2">
            <p class="" data-start="58" data-end="245">The <strong data-start="62" data-end="86">“Coffee on the
                    Wall”</strong> initiative was inspired by <a
                    href="https://www.kindspring.org/story/view.php?sid=44089" target="_blank" rel="noopener">this
                    beautiful story</a><br data-start="143" data-end="146">It’s a wonderful example of how a simple act
                of kindness can change the way someone sees the world.</p>
            <p>&nbsp;</p>
            <p class="MsoNormal" style="text-align: center;"><span
                    style="font-size: 16.0pt; line-height: 107%; font-family: 'Futura BdCn BT',sans-serif;">FAQ
                    (Frequently Asked Questions)</span></p>
            <p><strong>Q1: Do I need to provide proof that I really need this?</strong><br>A: Not at all! Your word is
                enough. We trust that you’re a good person, and we believe you.</p>
            <p>&nbsp;</p>
            <p><strong>Q2: What happens if all the “Coffee on the Wall” coffees are used up?</strong><br>A: No worries!
                If “Coffee on the Wall” runs out, ProximaRide will cover it for you. We’re committed to kindness—just
                like our generous donors—so your coffee is always on us.</p>
            <p>&nbsp;</p>
        </div>
        <div class="text-right  text-red-500 text-lg">
            <span class="text-red-500">*</span> Indicates required fields
        </div>
        {{-- Form --}}
        <form action="{{ route('coffee-on-wall.store', ['lang' => $defaultLang->abbreviation]) }}" method="POST">
            @csrf

            {{-- Amount Selection --}}
            <div x-data="{ billingCycle: 'monthly', selectedAmount: null }" class="border border-gray-300 rounded-lg"
                x-cloak>
                <h3 class="text-2xl text-white bg-red-700 p-3 rounded-t-lg mb-0">Please Select Your Amount <span
                        class="text-white">*</span></h3>
                <div class="p-4">
                    {{-- Frequency --}}
                    <div
                        class="flex flex-col sm:flex-row bg-gray-100 rounded-md overflow-hidden w-full shadow-inner text-sm font-semibold">
                        @foreach(['One Time', 'Weekly', 'Monthly'] as $tag)
                        <label class="w-full sm:w-1/3">
                            <input type="radio" name="frequency" value="{{ strtolower(str_replace(' ', '_', $tag)) }}" @if(strtolower($tag) === 'monthly') checked @endif
                                class="peer hidden" />
                            <div style="font-family: 'Futura', sans-serif;"
                                class="px-4 py-4 h-16 sm:h-24 border flex justify-center items-center text-center text-base cursor-pointer peer-checked:text-gray-700 peer-checked:bg-gray-200 border-gray-300 w-full">
                                {{ $tag }}
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Amount --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 mt-2 w-full">
                        @foreach($packages as $package)
                        <label>
                            <input type="radio" name="package" value="{{ $package->id }}" class="peer hidden" />
                            <div
                                class="w-full text-center cursor-pointer border rounded py-3 font-semibold peer-checked:border-red-500 peer-checked:bg-red-100 transition">
                                ${{ $package->price }}
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Custom Amount --}}
                    <div class="relative mt-4">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">$</span>
                        <input type="number" name="custom_amount" placeholder="Enter Your Own Amount"
                            class="pl-7 w-full border px-4 py-3 rounded-lg border-gray-300" />
                    </div>
                </div>
            </div>

            {{-- Beneficiary --}}
            <div class="border border-gray-300 rounded-lg">
                <h3 class="text-2xl text-white bg-red-700 p-3 rounded-t-lg mb-0">Beneficiary</h3>
                <div class="sm:flex flex-wrap gap-2 p-4">
                    @foreach(['All', 'Students', 'Female Passengers', 'Visible Minorities'] as $tag)
                    <label>
                        <input type="radio" name="beneficiary" value="{{ $tag }}" class="peer hidden" />
                        <div
                            class="px-4 py-4 lg:w-48 md:w-40 md:h-24 sm:w-28 sm:h-24 w-full h-16 mb-2 border rounded-lg flex justify-center items-center text-center text-base cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-100 border-gray-300">
                            {{ $tag }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="border border-gray-300 rounded-lg">
                <h3 class="text-2xl text-white bg-red-700 p-3 rounded-t-lg mb-0">Your contact information</h3>
                <div x-data="{ anonymous: false }" class="p-4">
                    <label class="block font-semibold text-gray-700">
                        <input type="checkbox" name="anonymous" x-model="anonymous" class="mr-2">
                        Make Donation Anonymous
                    </label>
                    <div x-show="!anonymous" x-transition class="mt-4 space-y-4">
                        <input type="text" name="name" placeholder="Your Name *"
                            class="w-full border px-4 py-3 rounded-lg border-gray-300">
                        <input type="email" name="email" placeholder="Your Email *"
                            class="w-full border px-4 py-3 rounded-lg border-gray-300">
                        <input type="text" name="phone" placeholder="Phone Number (Optional)"
                            class="w-full border px-4 py-3 rounded-lg border-gray-300">
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div x-data="{ method: '' }" class="border border-gray-300 rounded-lg">
                <h3 class="text-2xl text-white bg-red-700 p-3 rounded-t-lg mb-0">Select Your Payment Method</h3>
                <div class="p-4 space-y-3">
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="payment_method" value="stripe" x-model="method"
                                @change="document.getElementById('sub_method').value='card'">
                            <span>Debit or Credit Card</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="payment_method" value="Stripe" x-model="method"
                                @change="document.getElementById('sub_method').value='google_apple_pay'">
                            <span>Google Pay / Apple Pay</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="payment_method" value="paypal" x-model="method"
                                @change="document.getElementById('sub_method').value='paypal'">
                            <span>PayPal</span>
                        </label>
                    </div>
                    <input type="hidden" name="sub_method" id="sub_method" value="">
                    <input type="hidden" name="gPayApplePayId" id="gPayApplePayId">
                </div>
                <!-- Card Details Visible Only If Debit/Credit Selected -->
                <div x-show="method === 'stripe'" class="mt-4 space-y-4 p-4">
                    <input type="text" name="cardholder_name" id="cardholder_name" placeholder="Cardholder's Name"
                        class="w-full border px-4 py-3 rounded-lg border-gray-300" />

                    <label class="block font-medium text-sm text-gray-700">Card Details</label>
                    <div id="card-element" class="border border-gray-300 p-3 rounded-lg bg-white"></div>
                    <div id="card-errors" class="text-red-600 text-sm mt-1"></div>

                    <input type="hidden" name="payment_method_id" id="payment_method_id">
                </div>
                <div x-show="method === 'Stripe'" class="mt-2 p-2">
                    <label class="block font-medium text-sm text-gray-700">Quick Pay with Card, Google Pay, or Apple
                        Pay</label>
                    <div id="payment-request-button" class="w-full"></div>
                </div>
            </div>

            {{-- Terms --}}
            <div class="space-y-4 mt-4">
                <div class="flex items-start space-x-2">
                    <input type="checkbox" id="terms" name="agree_terms"
                        class="h-4 w-4 text-red-700 border-gray-300 rounded focus:ring-red-500">
                    <label for="terms" class="text-sm text-gray-600">
                        By clicking <strong>“Make Someone’s Day”</strong>, you agree to our
                        <a href="#" class="text-red-700 underline">Terms and Conditions</a> and
                        <a href="#" class="text-red-700 underline">Privacy Policy</a>.
                    </label>
                </div>
                <div class="flex justify-center">
                    <button type="submit" id="submitBtn"
                        class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                        Make Someone’s Day
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const terms = document.getElementById('terms');
    const submitBtn = document.getElementById('submitBtn');
    terms.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.querySelector("form");
        form.addEventListener("submit", async function (e) {
            const method = document.querySelector('input[name="payment_method"]:checked')?.value;
            if (method === 'stripe') {
                e.preventDefault();

                const cardholderName = document.getElementById('cardholder_name').value;
                const clientSecret = "{{ $clientSecret ?? '' }}";

                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret,
                    {
                        payment_method: {
                            card: card,
                            billing_details: { name: cardholderName }
                        }
                    }
                );

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    document.getElementById('payment_method_id').value = setupIntent.payment_method;
                    form.submit();
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", async function () {
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");

    // Check for GPay/ApplePay support
    const paymentRequest = stripe.paymentRequest({
        country: 'US',
        currency: 'usd',
        total: {
            label: 'Coffee Donation',
            amount: {{ isset($amount) ? $amount * 100 : 1000 }},
        },
        requestPayerName: true,
        requestPayerEmail: true,
    });

    const elements = stripe.elements();
    const prButton = elements.create('paymentRequestButton', {
        paymentRequest: paymentRequest,
    });

    paymentRequest.canMakePayment().then(function (result) {
        if (result) {
            prButton.mount('#payment-request-button');
        } else {
            document.getElementById('payment-request-button').style.display = 'none';
        }
    });

    paymentRequest.on('paymentmethod', async function (ev) {
        try {
            const {error, paymentIntent} = await stripe.confirmCardPayment("{{ $gpayClientSecret ?? '' }}", {
                payment_method: ev.paymentMethod.id,
            }, { handleActions: true });

            if (error) {
                ev.complete('fail');
                alert(error.message);
            } else {
                ev.complete('success');
                document.getElementById('gPayApplePayId').value = paymentIntent.id;
                document.querySelector("form").submit();
            }
        } catch (e) {
            ev.complete('fail');
            alert('Payment failed.');
        }
    });
});
</script>
@endsection