<script lang="ts">
    import { loadStripe } from '@stripe/stripe-js';
    import { onMount } from 'svelte';
    import ShippingOptions from './Components/ShippingOptions.svelte';
    import UserDetailsForm from './Components/UserDetailsForm.svelte';
    import DiscountCodeForm from "./Components/DiscountCodeForm.svelte";
    import OrderSummary from "./Components/OrderSummary.svelte";

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
    let baseTotalPrice: number = 0;
    let totalPrice: number = 0;
    let shippingPrice: string = '0';
    let shippingPriceDisplay: string;
    export let appliedDiscount: number = 0;


    export let shippingOptions: {
        id: string,
        title: string,
        price: string,
        address: string,
    }[] = [];

    interface UserDetails {
        [key: string]: string | boolean | undefined;
        email: string;
        firstName: string;
        lastName: string;
        address: string;
        apartment?: string;
        postalCode: string;
        city: string;
        phone: string;
        deliveryMethod: string;
        isFirm: boolean;
        ico?: string;
        dic?: string;
        note?: string;
    }

    let userDetails: UserDetails = {
        email: '',
        firstName: '',
        lastName: '',
        address: '',
        apartment: '',
        postalCode: '',
        city: '',
        phone: '',
        deliveryMethod: '',
        isFirm: false,
        ico: '',
        dic: '',
        note: '',
    };

    const errorMessages: { [key: string]: string } = {
        'email': 'Prosím, zadajte svoj e-mail.',
        'firstName': 'Prosím, zadajte svoje meno.',
        'lastName': 'Prosím, zadajte svoje priezvisko.',
        'address': 'Prosím, zadajte svoju adresu.',
        'postalCode': 'Prosím, zadajte svoje PSČ.',
        'city': 'Prosím, zadajte svoje mesto.',
        'phone': 'Prosím, zadajte svoje telefónne číslo.',
        'deliveryMethod': 'Prosím, vyberte spôsob doručenia.'
    };

    onMount(() => {
        loadStripe(stripePublicKey).then((loadedStripe) => {
            stripe = loadedStripe;
        });
    });

    const recalculateTotal = () => {
        totalPrice = (productsData || []).reduce((total, product) => total + product.price * product.quantity, 0);
        const selectedShippingOption = shippingOptions.find(option => option.id === userDetails.deliveryMethod);
        if (selectedShippingOption && selectedShippingOption.price !== '0') {
            shippingPriceDisplay = selectedShippingOption.price + " €";
            totalPrice += parseFloat(selectedShippingOption.price);
        }else if(selectedShippingOption && selectedShippingOption.price == '0'){
            shippingPriceDisplay = "ZADARMO";
        }else {
            shippingPriceDisplay = "";
        }
        console.log(shippingPriceDisplay);
        if (appliedDiscount != 0){
            totalPrice -= totalPrice*(appliedDiscount/100);
        }
    }
    $: productsData, shippingOptions, userDetails.deliveryMethod, appliedDiscount, recalculateTotal();

    const handlePayment = async () => {
        const excludedFields = userDetails.isFirm
            ? ['apartment', 'isFirm', 'note']
            : ['apartment', 'isFirm', 'ico', 'dic', 'note'];

        const missingField = Object.keys(userDetails).find(field =>
            !excludedFields.includes(field) && !userDetails[field]
        );

        if (missingField) {
            cardError = errorMessages[missingField] || 'Chyba pri vyplňovaní formulára.';
            console.log(missingField);
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
                    amount: Math.round(totalPrice * 100),
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
    }

    .form-container {
        background-color: $secondary-purple;
        padding: 2rem 2rem 2rem 10vw;
        box-sizing: border-box;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 50%;
        color: $text-color;
    }

    .summary-container {
        position: sticky;
        top: 0;
        background-color: $neutral-white;
        box-sizing: border-box;
        width: 100%;
        color: $text-color;
        display: flex;
        flex-direction: column;
        margin-bottom: 35vw;
    }

    .submit-button-container {
        position: sticky;
        bottom: 0;
        width: 100%;
        background-color: $neutral-white;
        box-sizing: border-box;
        z-index: 10;
        padding: 1rem 0;
        margin-top: auto;
    }

    .summary-buy {
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        width: 50%;
        padding: 2rem 10vw 2rem 2rem;
        box-sizing: border-box;
        justify-content: space-between;
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

    .data-processing-note {
        font-size: 0.76rem;
        color: #555;
        margin-top: 1rem;
        text-align: left
    }
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .summary-container, .submit-button-container {
            position: static;
            margin-bottom: 0;
        }

        .form-container, .summary-container, .summary-buy, .submit-button-container {
            width: 100%;
            padding: 1rem;
        }

        .form-segment {
            flex-direction: column;
        }

        .form-segment .form-section {
            width: 100%;
        }

        .submit-button {
            width: 100%;
        }
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        position: relative;
        font-size: 1rem;
        font-weight: 500;
        color: #333;
    }

    .checkbox-label input[type="checkbox"] {
        display: none;
    }

    /* Custom checkbox appearance */
    .checkbox-custom {
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid #555;
        border-radius: 4px;
        display: inline-block;
        position: relative;
        transition: all 0.3s ease;
    }

    .checkbox-custom::after {
        content: '';
        position: absolute;
        width: 0.6rem;
        height: 0.6rem;
        top: 50%;
        left: 50%;
        background-color: #4caf50;
        transform: translate(-50%, -50%) scale(0);
        border-radius: 2px;
        transition: transform 0.2s ease;
    }

    .checkbox-label input[type="checkbox"]:checked + .checkbox-custom::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .dynamic-fields {
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .dynamic-fields.visible {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="container">
    <div class="form-container">
        <UserDetailsForm {userDetails}/>
        <ShippingOptions {shippingOptions} bind:userDetails />
        <DiscountCodeForm on:apply-discount={event => { appliedDiscount = event.detail; recalculateTotal(); }}/>
    </div>
    <div class="summary-buy">
        <div class="summary-container">
            <OrderSummary {productsData} {shippingPriceDisplay} {appliedDiscount} {totalPrice}/>
        </div>
        <div class="submit-button-container">
            {#if cardError}
                <div class="error-card">
                    <p>{cardError}</p>
                </div>
            {/if}
            <button class="submit-button" on:click={handlePayment} disabled={isProcessing || productsData.length === 0}>
                {isProcessing ? 'Spracuváva sa objednávka' : 'Zaplatiť'}
            </button>
            <p class="data-processing-note">
                *Kliknutím na tlačidlo „Zaplatiť“ súhlasíte so spracovaním vašich osobných údajov za účelom vybavenia objednávky v súlade s našimi zásadami ochrany osobných údajov.
            </p>
        </div>
    </div>
</div>
