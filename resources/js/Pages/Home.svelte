<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    import Footer from "../Components/Footer.svelte";
</script>

<style>
    :global(body, html) {
        margin: 0;
        padding: 0;
        height: 2000px;
        display: flex;
        flex-direction: column;
    }
    :global(#app) {
        height: 100%; /* Ensure #app takes up full height */
        display: flex;
        flex-direction: column; /* Flex column for app layout */
    }

    .app-container {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
</style>

<Navbar></Navbar>
<main class="app-container">
    <h1>Welcome to Svelte</h1>
    <p>This is a Svelte app with full height.</p>
</main>
<Footer></Footer>
