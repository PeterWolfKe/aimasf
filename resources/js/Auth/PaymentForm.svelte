<script>
    import { loadStripe } from '@stripe/stripe-js';
    import { onMount } from 'svelte';

    export let stripePublicKey;

    let stripe;
    let elements;
    let cardElement;
    let cardError = '';
    let isProcessing = false;

    let userDetails = {
        email: '',
        firstName: '',
        lastName: '',
        address: '',
        apartment: '',
        postalCode: '',
        city: '',
        country: 'Slovensko',
        phone: '',
    };

    onMount(async () => {
        stripe = await loadStripe(stripePublicKey);
        elements = stripe.elements();
        cardElement = elements.create('card', {
            style: {
                base: {
                    color: '#20303a',
                    fontFamily: 'Arial, sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#8e8e8e',
                    },
                },
                invalid: {
                    color: '#980000',
                },
            },
        });
        cardElement.mount('#card-element');
    });

    const handlePayment = async () => {
        goto('https://buy.stripe.com/test_bIY3cH41ZeNd21a5kk');
        cardError = '';
        isProcessing = true;

        try {
            const response = await fetch('/payment/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    amount: 50,
                    userDetails,
                }),
            });

            const { clientSecret, error } = await response.json();

            if (error) {
                cardError = error;
                return;
            }

            const { error: stripeError } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: `${userDetails.firstName} ${userDetails.lastName}`,
                        email: userDetails.email,
                        phone: userDetails.phone,
                        address: {
                            line1: userDetails.address,
                            city: userDetails.city,
                            postal_code: userDetails.postalCode,
                            country: 'SK',
                        },
                    },
                },
            });

            if (stripeError) {
                cardError = stripeError.message;
            } else {
                alert('Payment successful!');
            }
        } catch (error) {
            cardError = error.message;
        } finally {
            isProcessing = false;
        }
    };
</script>

<style>
    /*.form-container {
        background-color: var(--background-color, #B8EAE7);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 2rem auto;
        color: var(--text-color, #20303a);
    }

    .form-container h2 {
        margin-bottom: 1rem;
        color: var(--text-color, #20303a);
    }

    .form-container label {
        display: block;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-container input {
        width: 100%;
        padding: 12px;
        border: 1px solid #D3D3D3;
        border-radius: 4px;
        margin-bottom: 1rem;
        background-color: var(--neutral-white, #ffffff);
    }

    #card-element {
        margin: 1rem 0;
        padding: 12px;
        border: 1px solid #D3D3D3;
        border-radius: 4px;
        background-color: var(--neutral-white, #ffffff);
    }

    .error {
        color: var(--dark-red, #980000);
        font-size: 0.9rem;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }

    .submit-button {
        background-color: var(--button-background, #89CFF0);
        color: var(--neutral-white, #ffffff);
        border: none;
        border-radius: 4px;
        padding: 12px 16px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    .submit-button:hover {
        background-color: var(--button-hover, #D6BBE8);
    }

    .submit-button:disabled {
        background-color: #D3D3D3;
        cursor: not-allowed;
    }*/
</style>

<div class="form-container">
    <h2>Checkout</h2>

    <label for="email">E-mail</label>
    <input
        type="email"
        id="email"
        bind:value={userDetails.email}
        placeholder="Your email"
        required
    />

    <div style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
            <label for="firstName">First Name</label>
            <input
                type="text"
                id="firstName"
                bind:value={userDetails.firstName}
                placeholder="John"
                required
            />
        </div>
        <div style="flex: 1;">
            <label for="lastName">Last Name</label>
            <input
                type="text"
                id="lastName"
                bind:value={userDetails.lastName}
                placeholder="Doe"
                required
            />
        </div>
    </div>

    <label for="address">Address</label>
    <input
        type="text"
        id="address"
        bind:value={userDetails.address}
        placeholder="123 Street Name"
        required
    />

    <label for="apartment">Apartment, Suite, etc. (Optional)</label>
    <input
        type="text"
        id="apartment"
        bind:value={userDetails.apartment}
        placeholder="Apartment or Suite"
    />

    <div style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
            <label for="postalCode">Postal Code</label>
            <input
                type="text"
                id="postalCode"
                bind:value={userDetails.postalCode}
                placeholder="12345"
                required
            />
        </div>
        <div style="flex: 1;">
            <label for="city">City</label>
            <input
                type="text"
                id="city"
                bind:value={userDetails.city}
                placeholder="City"
                required
            />
        </div>
    </div>

    <label for="phone">Phone (Optional)</label>
    <input
        type="text"
        id="phone"
        bind:value={userDetails.phone}
        placeholder="Your phone number"
    />

    <h2>Payment</h2>
    <div id="card-element"></div>
    {#if cardError}
        <p class="error">{cardError}</p>
    {/if}

    <button class="submit-button" on:click={handlePayment} disabled={isProcessing}>
        {isProcessing ? 'Processing...' : 'Pay Now'}
    </button>
</div>
