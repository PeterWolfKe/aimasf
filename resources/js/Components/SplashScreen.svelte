<script>
    import { onMount } from 'svelte';
    import { fade } from 'svelte/transition';
    import logo from '/resources/assets/logo.webp';

    let showSplash = true;

    onMount(() => {
        setTimeout(() => {
            showSplash = false;
        }, 1200);
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .splash-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: $secondary-deep-blue;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        overflow: hidden;
    }

    .logo {
        width: 200px;
        height: auto;
        animation: shrink 1.2s ease forwards 0.4s;
    }

    @keyframes shrink {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(0.5);
        }
    }
</style>

{#if showSplash}
    <div class="splash-container" transition:fade={{ duration: 700 }}>
        <img class="logo" src={logo} alt="Logo" />
    </div>
{/if}
