<script lang="ts">
    import start_button from '/resources/assets/start_button.png';

    let isVideoPlaying = false;
    const videoUrl = '/storage/videos/aima_tutorial.mp4';
    const videoThumbnail = '/storage/images/tutorial_thumbnail.webp'

    const playVideo = () => {
        isVideoPlaying = true;
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    section {
        background-color: $secondary-purple;
        color: $text-color;
        padding: 2rem;
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
        display: block;
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

    .video {
        width: 100%;
        max-width: 1000px;
        border-radius: 8px;
        display: block;
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

<section id="VideoTutorial">
    <h2 class="title">Videotutoriál</h2>
    <div class="image-container">
        {#if !isVideoPlaying}
            <img class="image" src={videoThumbnail} alt="">
            <button class="button" on:click={playVideo}>
                <img src={start_button} alt="Start Button">
            </button>
        {:else}
            <video class="video" controls autoplay>
                <source src={videoUrl} type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        {/if}
    </div>
</section>
