<script>
    import { onMount } from "svelte";

    let count = 0;
    const targetCount = 475000000;
    const duration = 2000;
    let observed = false;
    let container;

    function easeOut(t) {
        return t * (2 - t);
    }

    function startCount() {
        const startTime = performance.now();

        function animate(time) {
            const elapsed = time - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeOut(progress);
            count = Math.floor(easedProgress * targetCount);

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                count = targetCount;
            }
        }

        requestAnimationFrame(animate);
    }

    onMount(() => {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && !observed) {
                        observed = true;
                        startCount();
                    }
                });
            },
            { threshold: 0.1 }
        );

        if (container) observer.observe(container);

        return () => {
            if (container) observer.unobserve(container);
        };
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :global(body) {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        width: 100%;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: $secondary-purple;
        color: $secondary-deep-blue;
        padding: 20px;
        box-sizing: border-box;
    }

    .text {
        font-size: 1rem;
        margin-bottom: 20px;
        text-align: center;
    }

    .number {
        font-size: 4rem;
        font-weight: bold;
        color: #365b6d;
    }

    @media (min-width: 768px) {
        .container {
            height: 400px;
        }

        .text {
            font-size: 2rem;
        }

        .number {
            font-size: 6rem;
        }
    }
</style>

<section class="container" bind:this={container}>
    <div class="text">
        POČET ŽIEN, KTORÉ DENNE TRÁPI STRACH Z KRVAVÉHO OBLEČENIA
    </div>
    <div class="number">{count.toLocaleString()}</div>
</section>
