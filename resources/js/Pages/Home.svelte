<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    import Footer from "../Components/Footer.svelte";
    import ColoringText from "../Components/ColoringText.svelte";
    import SplashScreen from "../Components/SplashScreen.svelte";
    import AboutUs from "../Components/AboutUs.svelte";
</script>

<style>
    :global(body, html) {
        margin: 0;
        padding: 0;
        height: 2000px;
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
</style>

<SplashScreen></SplashScreen>
<Navbar></Navbar>
<main class="app-container">
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>


    <p>This is a Aima app with full height.</p>
    <ColoringText></ColoringText>

    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <AboutUs></AboutUs>
</main>
<Footer></Footer>
