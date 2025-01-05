<script lang="ts">
    import { loadStripe } from '@stripe/stripe-js';
    import { onMount } from 'svelte';

    export let stripePublicKey: string;
    export let productsData: {
        id: number,
        name: string,
        description: string,
        price: number,
        size: string,
        quantity: number,
        image?: string
    }[] = [];


    let stripe: any;
    let cardError: string = '';
    let isProcessing: boolean = false;
    let totalPrice: number = 0;

    $: {
        totalPrice = (productsData || []).reduce((total, product) => total + product.price * product.quantity, 0);

        const selectedShippingOption = shippingOptions.find(option => option.title === userDetails.deliveryMethod);
        if (selectedShippingOption && selectedShippingOption.price !== 'ZADARMO') {
            totalPrice += parseFloat(selectedShippingOption.price);
        }
    }

    interface UserDetails {
        [key: string]: string | undefined;
        email: string;
        firstName: string;
        lastName: string;
        address: string;
        apartment?: string;
        postalCode: string;
        city: string;
        phone?: string;
        deliveryMethod: string;
    }

    const userDetails: UserDetails = {
        email: '',
        firstName: '',
        lastName: '',
        address: '',
        apartment: '',
        postalCode: '',
        city: '',
        phone: '',
        deliveryMethod: ''
    };

    const shippingOptions = [
        {
            id: 'reprocentrum',
            title: 'Odberné miesto - Reprocentrum',
            price: 'ZADARMO',
            address: 'Vodárenská 2, 040 01 Košice',
        },
        {
            id: 'datacomp',
            title: 'Odberné miesto - Datacomp showroom',
            price: 'ZADARMO',
            address: 'Moldavská cesta 32, 040 11 Košice',
        },
        {
            id: 'rezke',
            title: 'Odberné miesto - Rezke',
            price: 'ZADARMO',
            address: 'Mäsiarska 26, 040 01 Košice',
        },
        {
            id: 'vlny',
            title: 'Odberné miesto - Vlny',
            price: 'ZADARMO',
            address: 'Mäsiarska 13, 040 01 Košice',
        },
        {
            id: 'interesante',
            title: 'Odberné miesto - Interesante kvetinarstvo',
            price: 'ZADARMO',
            address: 'Hlavná 26, 040 01 Košice',
        }
    ];

    const errorMessages: { [key: string]: string } = {
        'email': 'Prosím, zadajte svoj e-mail.',
        'firstName': 'Prosím, zadajte svoje meno.',
        'lastName': 'Prosím, zadajte svoje priezvisko.',
        'address': 'Prosím, zadajte svoju adresu.',
        'postalCode': 'Prosím, zadajte svoje PSČ.',
        'city': 'Prosím, zadajte svoje mesto.',
        'deliveryMethod': 'Prosím, vyberte spôsob doručenia.'
    };

    onMount(async () => {
        stripe = await loadStripe(stripePublicKey);
    });

    const handlePayment = async () => {
        let missingField = Object.keys(userDetails).find(field => {
            return field !== 'apartment' && field !== 'phone' && !userDetails[field];
        });

        if (missingField) {
            console.log(missingField);
            cardError = errorMessages[missingField] || 'Chyba pri vyplňovaní formulára.';
            isProcessing = false;
            return;
        }

        isProcessing = true;
        cardError = '';

        const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content;

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

            const { checkoutUrl, error, success } = await response.json();

            if (!success || error) {
                cardError = error || 'Failed to initiate payment.';
                return;
            }

            window.location.href = checkoutUrl;
        } catch (error: any) {
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
        max-height: 80vh;
        overflow-y: auto;
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

    .form-contact-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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

    .summary-product {
        position: relative;
    }

    .image-container {
        position: relative;
    }

    .image-container img {
        display: block;
        width: 100%;
    }

    .quantity {
        position: absolute;
        top: 2px;
        right: 2px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 3px 3px;
        border-radius: 9999px;
        font-size: 12px;
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
            align-items: flex-start;
        }

        .summary-price {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
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
            placeholder="Váš e-mail"
            required
        />
        <div style="display: flex; gap: 1rem;">
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="firstName">Meno</label>
                <input
                    type="text"
                    id="firstName"
                    bind:value={userDetails.firstName}
                    placeholder="Karol"
                    required
                />
            </div>
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="lastName">Priezvisko</label>
                <input
                    type="text"
                    id="lastName"
                    bind:value={userDetails.lastName}
                    placeholder="Dubovský"
                    required
                />
            </div>
        </div>
        <div style="display: flex; gap: 1rem;">
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="address">Adresa</label>
                <input
                    type="text"
                    id="address"
                    bind:value={userDetails.address}
                    placeholder="Karpatská 14"
                    required
                />
            </div>
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="apartment">Byt, Apartmán, atď. (Voliteľné)</label>
                <input
                    type="text"
                    id="apartment"
                    bind:value={userDetails.apartment}
                    placeholder="Byt alebo Apartmán"
                />
            </div>
        </div>
        <div style="display: flex; gap: 1rem;">
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="postalCode">PSČ</label>
                <input
                    type="text"
                    id="postalCode"
                    bind:value={userDetails.postalCode}
                    placeholder="12345"
                    required
                />
            </div>
            <div class="form-contact-wrapper" style="flex: 1;">
                <label for="city">Mesto</label>
                <input
                    type="text"
                    id="city"
                    bind:value={userDetails.city}
                    placeholder="Prešov"
                    required
                />
            </div>
        </div>
        <label for="phone">Telefón (Voliteľné)</label>
        <input
            type="text"
            id="phone"
            bind:value={userDetails.phone}
            placeholder="Vaše telefónne číslo"
        />
        <h2>Doprava</h2>
        <div class="shipping-methods">
            {#each shippingOptions as option}
                <div class="shipping-option">
                    <input
                        type="radio"
                        id={option.id}
                        name="deliveryMethod"
                        value={option.title}
                        bind:group={userDetails.deliveryMethod}
                    />
                    <label for={option.id}>
                        <div class="option-details">
                            <div class="price-wrapper">
                                <span class="title">{option.title}</span>
                                <span class="price">{option.price}</span>
                            </div>
                            <span class="address">{option.address}</span>
                        </div>
                    </label>
                </div>
            {/each}
        </div>
    </div>
    <div class="summary-container">
        <div class="payment-order">
            <div class="order-summary">
                <h2>Zhrnutie objednávky</h2>
                {#if productsData.length === 0}
                    <p style="font-size: 2rem; font-weight: bold">Nemáte žiadne produkty na platbu.</p>
                {:else}
                    {#each productsData as product}
                        <div class="summary-product">
                            <div class="image-container">
                                <img src={product.image || 'https://via.placeholder.com/150'} alt={product.name || 'No Image'} />
                                <span class="quantity">{product.quantity}</span>
                            </div>
                            <div class="details">
                                <span class="title">{product.name || 'Nemenovaný produkt'}</span>
                                <span>€{(Number(product.price) || 0).toFixed(2)}</span>
                            </div>
                        </div>
                    {/each}
                <div class="summary-product">
                    <div class="details">
                    <span>
                        Cena dopravy:
                        <span>{shippingOptions.find(option => option.title === userDetails.deliveryMethod)?.price || 'ZADARMO'}</span>
                    </span>
                    </div>
                </div>
                <div class="summary-price">
                    Celkom: {(Number(totalPrice) || 0).toFixed(2)} €
                </div>
                {/if}
            </div>
        </div>
        {#if cardError}
            <div class="error-card">
                <p>{cardError}</p>
            </div>
        {/if}
        <button class="submit-button" on:click={handlePayment} disabled={isProcessing || productsData.length === 0}>
            {isProcessing ? 'Spracuváva sa objednávka' : 'Zaplatiť'}
        </button>
    </div>
</div>
