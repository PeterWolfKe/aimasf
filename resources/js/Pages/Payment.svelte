<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    import Footer from "../Components/Footer.svelte";
    import PaymentForm from "../Auth/PaymentForm.svelte";

    // Props
    export let stripePublicKey;
    export let productsData;
    export let shippingOptions;
</script>

<style>
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

<Navbar></Navbar>
<main class="app-container">
    <PaymentForm stripePublicKey={stripePublicKey} productsData={productsData} shippingOptions={shippingOptions}/>
</main>
<Footer></Footer>
