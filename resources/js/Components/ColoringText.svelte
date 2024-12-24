<script>
    import { onMount } from 'svelte';

    let words = [
        "Menstruation", "is", "painful,", "frustrating,", "and",
        "often", "exhausting.", "The", "blood", "is", "a", "reminder",
        "of", "endless", "cycles,", "that", "feel", "never-ending."
    ];
    const startingFraction = 0.6;
    const endingFraction = 3.17
    const one_point = (endingFraction - startingFraction) / words.length;

    let scrollValues = [];
    let scrollFraction = 0;


    const handleScroll = () => {
        const scrollPos = window.scrollY;
        const sectionHeight = document.querySelector('.textblock').offsetHeight;
        const maxScroll = sectionHeight - window.innerHeight;
        scrollFraction = Math.abs(Math.min(scrollPos / maxScroll, 1));
        scrollValues = [];

        for (let index = 0; index < words.length; index++) {
            let scroll = scrollFraction - startingFraction - one_point * index;

            if (scroll > one_point) {
                scroll = 0;
            } else if (scroll < 0) {
                scroll = 100;
            } else {
                scroll = 100-scroll/one_point*100;
            }
            scrollValues.push(scroll);
            console.log(scroll);
        }
    };

    onMount(() => {
        window.addEventListener('scroll', handleScroll);

        return () => {
            window.removeEventListener('scroll', handleScroll);
        };
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .textblock {
        position: relative;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
        min-height: 80vh;
    }

    .video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 80vh;
        z-index: -1;
    }

    video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .text-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: $neutral-white;
        text-align: center;
        z-index: 1;
        background: rgba($secondary-purple, 0.6);
        padding: 0 12rem;
        box-sizing: border-box;
    }

    .text {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 1rem;
    }

    .word {
        font-size: 2rem;
        font-weight: bold;
        position: relative;
        display: inline-block;
        overflow: hidden;
        color: $dark-gray;
        letter-spacing: 0.05rem;
    }

    .word-mask {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        color: $neutral-white;
        clip-path: inset(0% 100% 0% 0%);
    }

    .subtext {
        margin-top: 1rem;
        font-size: 1.5rem;
    }
</style>
<section class="textblock">
    <div class="video-container">
        <video id="textBlockVideo" autoplay muted loop playsinline>
            <source src="https://view.vzaar.com/14b701c3-86ec-4735-9601-202149d2eac2/video" />
        </video>
    </div>

    <div class="text-content">
        <div class="text">
            {#each words as word, index}
                <div class="word">
                    {word}
                    <span
                        class="word-mask"
                            style="clip-path: inset(0% {scrollValues[index]}% 0% 0%)"
                    >{word}</span>
                </div>
            {/each}
        </div>
    </div>
</section>
