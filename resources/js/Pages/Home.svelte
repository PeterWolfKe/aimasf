<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    import Footer from "../Components/Footer.svelte";
    import SplashScreen from "../Components/SplashScreen.svelte";
    import Problem from "../Components/Problem.svelte";
    import AboutUs from "../Components/AboutUs.svelte";
    import VideoTutorial from "../Components/VideoTutorial.svelte";
    import BackgroundStart from "../Components/BackgroundStart.svelte";

    import { onMount } from 'svelte';
    import ProductCard from "../Components/ProductCard.svelte";
    import Sponsors from "../Components/Sponsors.svelte";
    import ProductCardValentine from "../Components/ProductCardValentine.svelte";
    import ValentineCounter from "../Components/ValentineCounter.svelte";

    export let product;
    export let productImages: string[] = [];

    export let productValentine;
    export let productImagesValentine: string[] = [];

    onMount(() => {
        const observerBigAnimate = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-big');
                }
            });
        });

        const observerSmallAnimate = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-small');
                }
            });
        });

        const animatedElementsBig = document.querySelectorAll(
            '.footer-container .column,' +
            '.problem p, ' +
            '#about-us p'
        );
        animatedElementsBig.forEach((element) => observerBigAnimate.observe(element));

        const animatedElementsSmall = document.querySelectorAll(
            '.newsletter-container,' +
            '.footer-bottom p, ' +
            '.problem h2,' +
            '#about-us h2,'
        );
        animatedElementsSmall.forEach((element) => observerSmallAnimate.observe(element));
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :global(body, html) {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        scroll-behavior: smooth;
        background: white;
    }
    :global(#app) {
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: $primary-blue;
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

<SplashScreen></SplashScreen>
<Navbar></Navbar>
<main class="app-container">
    <BackgroundStart></BackgroundStart>
    <ValentineCounter></ValentineCounter>
    <ProductCardValentine product={productValentine} productImages={productImagesValentine}></ProductCardValentine>
    <Problem></Problem>
    <ProductCard product={product} productImages={productImages}></ProductCard>
    <VideoTutorial></VideoTutorial>
    <AboutUs></AboutUs>
    <Sponsors></Sponsors>
</main>
<Footer></Footer>
