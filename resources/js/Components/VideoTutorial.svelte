<script lang="ts">
    import start_button from '/resources/assets/start_button.png';
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    section {
        background-color: $secondary-purple;
        color: $text-color;
        padding: 2rem;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .title {
        font-size: 3.5rem;
        font-weight: bold;
        color: $secondary-deep-blue;
        margin-bottom: 2rem;
        margin-top: 0;
    }

    .subtitle {
        font-size: 1.2rem;
        color: $secondary-deep-blue;
        margin-bottom: 2rem;
    }

    .image-container {
        width: 100%;
        max-width: 1000px;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .image {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .button {
        width: 100px;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: none;
        background: none;
        cursor: pointer;
        transition: transform 0.3s ease;

        &:hover {
            transform: translate(-50%, -50%) scale(1.1);
        }

        img {
            width: 100%;
            height: auto;
        }
    }

    @media (max-width: 768px) {
        .title {
            font-size: 2rem;
        }

        .subtitle {
            font-size: 1rem;
        }

        .image-container {
            max-width: 100%;
        }

        .button {
            width: 80px;
        }
    }
</style>

<section>
    <h2 class="title">Videotutoriál na použitie produktu</h2>
    <div class="image-container">
        <img class="image" src="https://testaima.my.canva.site/media/a1536b55f6bfa3582cd44bd9e41fe4c2.jpg" alt="">
        <button class="button">
            <img src={start_button} alt="Start Button">
        </button>
    </div>
</section>
