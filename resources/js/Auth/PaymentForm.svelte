<script>
    import { loadStripe } from '@stripe/stripe-js';
    import { onMount } from 'svelte';

    export let stripePublicKey;
    export let sessionData;
    console.log(sessionData);

    let stripe;
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

    $:totalPrice = products.reduce((total, product) => total + product.price, 0);

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
        stripe = await loadStripe(stripePublicKey);
    });


    const handlePayment = async () => {
        if (!userDetails.deliveryMethod) {
            cardError = 'Please select a delivery method.';
            isProcessing = false;
            return;
        }

        isProcessing = true;
        cardError = '';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch('/payment/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    amount: totalPrice * 100,
                    userDetails,
                }),
            });

            const {checkoutUrl, error, success} = await response.json();

            if (!success || error) {
                cardError = error || 'Failed to initiate payment.';
                return;
            }

            window.location.href = checkoutUrl;
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

    .payment-order {
        display: flex;
        flex-direction: column;
        margin-bottom: auto;
    }

    .payment-wrapper {
        display: flex;
        flex-direction: column;
    }

    .shipping-methods {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-top: 1rem;
        box-sizing: border-box;
    }

    .shipping-option {
        display: flex;
        width: 100%;
        align-items: center;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
        box-sizing: border-box;
        font-size: 0.9rem;
    }

    .shipping-option:hover {
        border-color: #0077ff;
    }

    .shipping-option input {
        appearance: none;
        width: 0.5rem;
        height: 0.5rem;
        transform: scale(0.8);
        margin-right: 0.8rem;
        border: 2px solid #777;
        border-radius: 50%;
        background-color: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .shipping-option input:checked {
        border-color: black;
        background-color: black;
    }

    .shipping-option input:checked::before {
        content: '';
        width: 0.6rem;
        height: 0.6rem;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: block;
    }

    .shipping-option label {
        display: flex;
        width: 100%;
    }

    .option-details {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .option-details .title {
        font-weight: bold;
        color: #333;
    }

    .option-details .address {
        color: #777;
        font-size: 0.85rem;
    }

    .price-wrapper{
        display: flex;
        justify-content: space-between;
    }

    .price {
        font-weight: bold;
        color: #0077ff;
        text-align: right;
    }

    .error-card {
        background-color: #fce4e4;
        color: #d8000c;
        border: 1px solid #d8000c;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        text-align: center;
    }

    .error-card p {
        margin: 0;
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

        .payment-order {
            flex-direction: column-reverse;
            margin-bottom: 0;
        }

        .order-summary {
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
        <div class="shipping-methods">
            <div class="shipping-option">
                <input
                    type="radio"
                    id="reprocentrum"
                    name="deliveryMethod"
                    value="Odberné miesto - Reprocentrum"
                    bind:group={userDetails.deliveryMethod}
                />
                <label for="reprocentrum">
                    <div class="option-details">
                        <div class="price-wrapper">
                            <span class="title">Odberné miesto - Reprocentrum</span>
                            <span class="price">ZADARMO</span>
                        </div>
                        <span class="address">Vodárenská 2, 040 01 Košice, Slovakia</span>
                    </div>
                </label>
            </div>

            <div class="shipping-option">
                <input
                    type="radio"
                    id="datacomp"
                    name="deliveryMethod"
                    value="Odberné miesto - Datacomp showroom"
                    bind:group={userDetails.deliveryMethod}
                />
                <label for="datacomp">
                    <div class="option-details">
                        <div class="price-wrapper">
                            <span class="title">Odberné miesto - Datacomp showroom</span>
                            <span class="price">ZADARMO</span>
                        </div>
                        <span class="address">Moldavská cesta 32, 040 11 Košice</span>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class="summary-container">
        <div class="payment-order">
            <div class="order-summary">
                <h2>Order Summary</h2>
                {#each products as product}
                    <div class="summary-product">
                        <img src={product.image} alt={product.title}/>
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
        {#if cardError}
            <div class="error-card">
                <p>{cardError}</p>
            </div>
        {/if}
        <button class="submit-button" on:click={handlePayment} disabled={isProcessing}>
            {isProcessing ? 'Processing...' : 'Pay Now'}
        </button>
    </div>
</div>
