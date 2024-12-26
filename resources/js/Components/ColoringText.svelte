<script>
    import { onMount } from 'svelte';

    let words = [
        "Váš", "čas", "je", "cenný,", "naša", "misia", "jasná.",
        "Čistenie", "krvi", "bez", "nutnosti", "prania.",
        "Akoby", "sa", "nič", "nestalo."
    ]
    let startingFraction = 0.6;
    let endingFraction = 2;
    $: one_point = (endingFraction - startingFraction) / words.join('').length;

    let scrollValues = [];
    let scrollFraction = 0;

    const handleScroll = () => {
        const scrollPos = window.scrollY;
        const sectionHeight = document.querySelector('.textblock').offsetHeight;
        const maxScroll = sectionHeight - window.innerHeight;
        scrollFraction = Math.abs(Math.min(scrollPos / maxScroll, 1));
        scrollValues = [];

        for (let index = 0; index < words.length; index++) {
            let characterCount = 0;

            for (let i = 0; i < index; i++) {
                characterCount += words[i].length;
            }
            let scroll = scrollFraction - startingFraction - one_point * characterCount;

            if (scroll > one_point * words[index].length) {
                scroll = 0;
            } else if (scroll < 0) {
                scroll = 100;
            } else {
                scroll = 100 - scroll / (one_point * words[index].length) * 100;
            }
            scrollValues.push(scroll);
        }
    };

    const calculateFractions = () => {
        const section = document.querySelector('.textblock');
        const windowHeight = window.innerHeight;

        let sectionTop = section.offsetTop;
        let sectionHeight = section.offsetHeight;

        let sectionMiddle = sectionTop + sectionHeight * 1.5;

        startingFraction = Math.max(0, sectionTop / windowHeight);
        endingFraction = Math.max(0, sectionMiddle / windowHeight);

        console.log("Starting Fraction:", startingFraction);
        console.log("Ending Fraction:", endingFraction);
    };

    onMount(() => {
        calculateFractions();
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
        min-height: 60vh;
        overflow: hidden;
    }

    .video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 60vh;
        z-index: -1;
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        box-sizing: border-box;
    }

    .text-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 60vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: $neutral-white;
        text-align: center;
        z-index: 1;
        background: rgba($secondary-deep-blue, 0.5);
        padding: 0 3rem;
        box-sizing: border-box;
        background: $button-background;
    }

    .text {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }

    .word {
        font-size: 3rem;
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

    @media (max-width: 768px) {
        .text-content {
            padding: 0 2rem;
        }

        .word {
            font-size: 2.5rem;
        }

        .subtext {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .text-content {
            padding: 0 1rem;
        }

        .word {
            font-size: 2rem;
        }

        .subtext {
            font-size: 1rem;
        }
    }
</style>

<section class="textblock">
    <div class="video-container">
        <!-- <img src="https://picsum.photos/id/25/2000/3000"/> -->
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
