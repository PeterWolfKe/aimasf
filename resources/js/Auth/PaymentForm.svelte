<script>
    import { loadStripe } from '@stripe/stripe-js';
    import { onMount } from 'svelte';

    export let stripePublicKey;

    let stripe;
    let elements;
    let cardNumberElement;
    let cardExpiryElement;
    let cardCvcElement;
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
        deliveryMethod: '',
    };

    // PRODUCTS
    let products = [
        {
            image: 'https://via.placeholder.com/150',
            title: 'Product 1',
            description: 'This is a great product.',
            price: 6.49
        }
    ];
    onMount(async () => {
        stripe = await loadStripe(stripePublicKey); // Replace with your actual public key
        elements = stripe.elements();

        // Create and mount individual elements
        cardNumberElement = elements.create('cardNumber', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#a0aec0',
                    },
                },
            },
        });
        cardNumberElement.mount('#card-number-element');

        cardExpiryElement = elements.create('cardExpiry', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#a0aec0',
                    },
                },
            },
        });
        cardExpiryElement.mount('#card-expiry-element');

        cardCvcElement = elements.create('cardCvc', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#a0aec0',
                    },
                },
            },
        });
        cardCvcElement.mount('#card-cvc-element');

        const handleCardErrors = (event) => {
            cardError = event.error ? event.error.message : '';
        };

        cardNumberElement.on('change', handleCardErrors);
        cardExpiryElement.on('change', handleCardErrors);
        cardCvcElement.on('change', handleCardErrors);
    });

    let totalPrice = products.reduce((total, product) => total + product.price, 0);

    const handlePayment = async () => {
        cardError = '';
        isProcessing = true;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const {paymentMethod, error: createError} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardNumberElement,
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
            });
            console.log(`PaymentMethod error: ${createError}`);
            if (createError) {
                cardError = createError.message;
                return;
            }

            const response = await fetch('/api/payment/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    amount: totalPrice * 100,
                    userDetails,
                    paymentMethodId: paymentMethod.id,
                }),
            });

            const {clientSecret, error, success} = await response.json();

            if (success) {
                alert('Payment successful and data stored!');
                return;
            }
            console.log(`CleintSecret error: ${error}`);
            if (error) {
                cardError = error;
                return;
            }

            const {error: stripeError} = await stripe.confirmCardPayment(clientSecret);

            if (stripeError) {
                cardError = stripeError.message;
            } else {
                alert('Payment successful and data stored!');
            }
            console.log(`CardPayment error: ${stripe}`);
        } catch (error) {
            cardError = error.message;
        } finally {
            isProcessing = false;
        }
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .container {
        display: flex;
        justify-content: space-between;
        width: 100%;
        box-sizing: border-box;
        flex-wrap: wrap;
    }

    .form-container {
        background-color: $background-color;
        padding: 2rem 2rem 2rem 10vw;
        box-sizing: border-box;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 50%;
        color: $text-color;
    }

    .summary-container {
        background-color: $neutral-white;
        padding: 2rem 10vw 2rem 2rem;
        box-sizing: border-box;
        width: 50%;
        color: $text-color;
        display: flex;
        flex-direction: column;
    }

    .summary-product {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .summary-product img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .summary-product .details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .summary-product .title {
        font-weight: bold;
    }

    .summary-price {
        font-size: 3rem;
        font-weight: bold;
        text-align: left;
        margin-top: auto;
    }

    .form-container h2, .summary-container h2 {
        margin-bottom: 1rem;
        color: $text-color;
    }

    .form-container label {
        display: block;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-container input {
        box-sizing: border-box;
        width: 100%;
        padding: 12px;
        border: 1px solid $gray-white;
        border-radius: 4px;
        margin-bottom: 1rem;
        background-color: $neutral-white;
    }

    .form-segment {
        display: flex;
        gap: 2rem;
        width: 100%;
        flex-direction: row-reverse;
    }

    .form-segment .form-section {
        flex: 1;
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    #card-element {
        margin: 1rem 0;
        padding: 12px;
        border: 1px solid $gray-white;
        border-radius: 4px;
        background-color: $neutral-white;
    }

    .error {
        color: $dark-red;
        font-size: 0.9rem;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }

    .submit-button {
        background-color: $button-background;
        color: $neutral-white;
        border: none;
        border-radius: 4px;
        padding: 12px 16px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        margin-top: auto;
        transition: background-color 0.3s;
        width: 100%;
    }

    .submit-button:hover {
        background-color: $button-hover;
    }

    .submit-button:disabled {
        background-color: $gray-white;
        cursor: not-allowed;
    }

    .card-form {
        margin-top: 1rem;
        padding: 1.5rem;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-form label {
        font-weight: bold;
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }

    .input-field {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .input-field:focus {
        border-color: #0077ff;
        box-shadow: 0 0 5px rgba(0, 119, 255, 0.5);
        outline: none;
    }

    .input-group {
        display: flex;
        width: 100%;
        justify-content: space-between;
        gap: 1rem;
    }

    .input-group > div {
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: space-between;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .checkbox-group label {
        font-size: 0.9rem;
        color: #555;
    }

    .error {
        color: #e63946;
        font-size: 0.9rem;
        margin-top: 1rem;
    }

    .summary-container {
        font-family: 'Arial', sans-serif;
    }

    .summary-product {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .summary-product img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .summary-product .details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .summary-product .title {
        font-weight: bold;
        color: #333;
    }

    .summary-price {
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 2rem;
        text-align: left;
    }

    .payment-order{
        display: flex;
        flex-direction: column;
    }

    .payment-wrapper {
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .form-container, .summary-container {
            width: 100%;
            padding: 1rem;
        }

        .form-segment {
            flex-direction: column;
        }

        .form-segment .form-section {
            width: 100%;
        }

        .summary-product {
            flex-direction: column;
            align-items: flex-start;
        }

        .summary-price {
            font-size: 1.2rem;
        }

        .submit-button {
            width: 100%;
        }

        .payment-order{
            flex-direction: column-reverse;
        }

        .order-summary{
            flex-direction: column-reverse;
        }
    }
</style>

<div class="container">
    <div class="form-container">
        <h2>Kontakt</h2>
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
        <div style="display: flex; gap: 1rem;">
            <div style="flex: 1;">
                <label for="address">Address</label>
                <input
                    type="text"
                    id="address"
                    bind:value={userDetails.address}
                    placeholder="123 Street Name"
                    required
                />
            </div>
            <div style="flex: 1;">
                <label for="apartment">Apartment, Suite, etc. (Optional)</label>
                <input
                    type="text"
                    id="apartment"
                    bind:value={userDetails.apartment}
                    placeholder="Apartment or Suite"
                />
            </div>
        </div>
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
        <h2>Doprava</h2>
        <label for="deliveryMethod">Delivery Method</label>
        <select id="deliveryMethod" bind:value={userDetails.deliveryMethod}>
            <option value="standard">Standard</option>
            <option value="express">Express</option>
        </select>
    </div>
    <div class="summary-container">
        <div class="payment-order">
            <div class="payment-wrapper">
                <h2>Payment</h2>

                <!-- Card Number -->
                <label for="card-number-element">Card Number</label>
                <div id="card-number-element" class="input-field"></div>

                <!-- Expiry Date -->
                <label for="card-expiry-element">Expiry Date</label>
                <div id="card-expiry-element" class="input-field"></div>

                <!-- CVC -->
                <label for="card-cvc-element">CVC</label>
                <div id="card-cvc-element" class="input-field"></div>

                <!-- Error Display -->
                {#if cardError}
                    <p class="error">{cardError}</p>
                {/if}
            </div>
            <div class="order-summary">
                <h2>Order Summary</h2>
                {#each products as product}
                    <div class="summary-product">
                        <img src={product.image} alt={product.title} />
                        <div class="details">
                            <span class="title">{product.title}</span>
                            <span>{product.description}</span>
                        </div>
                    </div>
                {/each}
                <div class="summary-price">
                    Total: €{totalPrice}
                </div>
            </div>
        </div>

        <button class="submit-button" on:click={handlePayment} disabled={isProcessing}>
            {isProcessing ? 'Processing...' : 'Pay Now'}
        </button>
    </div>
</div>
