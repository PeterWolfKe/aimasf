<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    import Footer from "../Components/Footer.svelte";
    import PaymentForm from "../Auth/PaymentForm.svelte";

    // Props
    export let stripePublicKey;
    export let productsData;
    export let shippingOptions;
    export let discount;
    let isSticky = false;
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :global(body, html) {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        scroll-behavior: smooth;
    }
    :global(#app) {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .app-container {
        display: flex;
        flex-direction: column;
        font-family: Arial, sans-serif;
        background-color: $neutral-white;
    }
    :global(.animate-big) {
        animation: fadeInUpBig 1s ease;
    }
    :global(.animate-small) {
        animation: fadeInUpSmall 1s ease;
    }
    @keyframes fadeInUpBig {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeInUpSmall {
        0% {
            opacity: 0;
            transform: translateY(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<Navbar isSticky={false}></Navbar>
<main class="app-container class:sticky={isSticky}">
    <PaymentForm stripePublicKey={stripePublicKey} productsData={productsData} shippingOptions={shippingOptions} appliedDiscount={discount}/>
</main>
<Footer></Footer>
