<script>
    import { onMount } from 'svelte';

    const testimonials = [
        {
            id: 1,
            name: "Teta z Optimy",
            image: "/storage/images/recenzia1.webp",
            text: "Ďakujem za záchranu bielych obliečok! Včera večer sa mi toto stalo, a dnes som vás náhodou stretla v Optime. Neskutočne dobre to funguje. Fandím vám, veľmi milí mladí ľudia ktorí robia niečo užitočné🙂🙂🙂"
        },
        {
            id: 2,
            name: "Katka",
            image: "/storage/images/recenzia2.webp",
            text: "Jedna z mála študentských firiem čo poznám, ktorá urobila reálne zmysluplnú vec."
        },
        {
            id: 3,
            name: "Lenka",
            image: "/storage/images/recenzia3.webp",
            text: "Wau! Som prekvapená ako to funguje. Nečakala som, že to bude fungovať, je to mega."
        }
    ];

    let currentIndex = 0;
    let touchStartX = 0;
    let touchEndX = 0;
    let interval;

    const startInterval = () => {
        clearInterval(interval);
        interval = setInterval(() => {
            nextTestimonial();
        }, 5000);
    };

    const nextTestimonial = () => {
        currentIndex = (currentIndex + 1) % testimonials.length;
        startInterval();
    };

    const prevTestimonial = () => {
        currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
        startInterval();
    };

    const handleTouchStart = (e) => {
        touchStartX = e.touches[0].clientX;
    };

    const handleTouchEnd = (e) => {
        touchEndX = e.changedTouches[0].clientX;
        const swipeDistance = touchEndX - touchStartX;

        if (swipeDistance > 50) {
            prevTestimonial();
        } else if (swipeDistance < -50) {
            nextTestimonial();
        }
    };

    onMount(() => {
        startInterval();

        return () => clearInterval(interval); // Cleanup on unmount
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .testimonials-container {
        background-color: $neutral-white;
        padding: 40px 20px;
        text-align: center;
        color: $primary-mint;
        font-family: Arial, sans-serif;
        position: relative;
    }

    .testimonials-title {
        font-size: 2.5em;
        margin-bottom: 30px;
        color: $secondary-dark-blue;
        position: relative;
        display: inline-block;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .testimonials-slider {
        display: none;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    .slider-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        transform: translateX(calc(-100% * var(--current-index)));
    }

    .testimonial-card {
        background-color: #f1f1f1;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        flex: 0 0 100%;
        max-width: 100%;
        margin: 0 auto;

        &:hover {
            transform: translateY(-5px);
        }
    }

    .testimonial-image {
        width: 200px;
        height: 100px;
        border-radius: 10%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid $primary-blue;
    }

    .testimonial-name {
        font-size: 1.2em;
        color: $secondary-dark-blue;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .testimonial-text {
        font-size: 1em;
        color: $secondary-dark-blue;
        line-height: 1.5;
    }

    .rating {
        color: $primary-blue;
        margin-bottom: 10px;
    }

    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba($button-background, 0);
        border: none;
        padding: 50% 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        z-index: 10;

        &:active, &:focus {
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            outline: none;
            background-color: rgba(0,0,0,0);
        }
    }

    .prev-arrow {
        left: 0;
    }

    .next-arrow {
        right: 0;
    }

    .dots-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .dot {
        width: 10px;
        height: 10px;
        background-color: $gray-white;
        border-radius: 50%;
        margin: 0 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;

        &.active {
            background-color: $primary-blue;
        }
    }

    @media (max-width: 768px) {
        .testimonials-grid {
            display: none;
        }

        .testimonials-slider {
            display: block;
        }

        .testimonials-title {
            font-size: 2em;
        }

        .testimonial-card {
            width: 374px;
            box-sizing: border-box;
            &:hover {
                transform: none;
            }
        }
    }
</style>

<div class="testimonials-container">
    <h2 class="testimonials-title">Recenzie</h2>

    <!-- Grid layout for desktop -->
    <div class="testimonials-grid">
        {#each testimonials as testimonial}
            <div class="testimonial-card">
                <img src={testimonial.image} alt={testimonial.name} class="testimonial-image" />
                <div class="testimonial-name">{testimonial.name}</div>
                <p class="testimonial-text">{testimonial.text}</p>
            </div>
        {/each}
    </div>

    <div
        class="testimonials-slider"
        on:touchstart={handleTouchStart}
        on:touchend={handleTouchEnd}
    >
        <div class="slider-track" style="--current-index: {currentIndex}">
            {#each testimonials as testimonial}
                <div class="testimonial-card">
                    <img src={testimonial.image} alt={testimonial.name} class="testimonial-image" />
                    <div class="testimonial-name">{testimonial.name}</div>
                    <p class="testimonial-text">{testimonial.text}</p>
                </div>
            {/each}
        </div>


        <div class="dots-container">
            <button class="nav-arrow prev-arrow" on:click={prevTestimonial}></button>
            <button class="nav-arrow next-arrow" on:click={nextTestimonial}></button>
            {#each testimonials as _, i}
        <span
            class="dot"
            class:active={i === currentIndex}
            on:click={() => (currentIndex = i)}
        ></span>
            {/each}
        </div>
    </div>
</div>
