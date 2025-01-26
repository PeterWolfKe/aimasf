<script lang="ts">
    let heading = "AIMA";
    let subheading = "rýchly a účinný odstraňovač krvi";  // Smaller text
    let imageSrc = "/storage/products/00000001/1.webp";
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        height: 800px;
        margin-top: 70px;
    }

    .image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(50%);
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .heading {
        position: absolute;
        font-size: 8rem;
        font-weight: bold;
        font-family: holiday;
        color: $neutral-white;
        text-transform: uppercase;
        z-index: 2;
        text-align: center;
    }

    .subheading {
        position: absolute;
        font-size: 2rem;  // Smaller size
        color: $neutral-white;
        text-align: center;
        z-index: 2;
        top: 60%;  // Position it below the heading
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .heading {
            font-size: 4rem;
        }

        .subheading {
            font-size: 1.5rem;
        }

        .container {
            height: 600px;
        }
    }

    @media (max-width: 480px) {
        .heading {
            font-size: 3rem;
        }

        .subheading {
            font-size: 1.2rem;
        }

        .container {
            height: 400px;
        }
    }
</style>

<svelte:head>
    <link rel="preload" href={imageSrc} as="image" type="image/webp" />
</svelte:head>

<div class="container">
    <img src={imageSrc} alt="Background" class="image" />
    <div class="overlay"></div>
    <div class="heading">{heading}</div>
    <div class="subheading">{subheading}</div>
</div>
