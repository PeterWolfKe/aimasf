<script lang="ts">
    let heading = "AIMA";
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f0f0f0;
        height: 800px; // Very large height for a prominent hero section
        border-radius: 8px;
    }

    .image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%); // Fully black and white
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5); // Darker overlay for better contrast
    }

    .heading {
        position: absolute;
        font-size: 6rem; // Huge font size for maximum impact
        font-weight: bold;
        color: $neutral-white;
        text-transform: uppercase;
        z-index: 2;
        text-align: center;
    }

    @media (max-width: 768px) {
        .heading {
            font-size: 4rem; // Smaller size for tablets
        }

        .container {
            height: 600px; // Adjusted height for medium screens
        }
    }

    @media (max-width: 480px) {
        .heading {
            font-size: 3rem; // Smaller size for mobile
        }

        .container {
            height: 400px; // Adjusted height for small screens
        }
    }
</style>

<div class="container">
    <img src="https://testaima.my.canva.site/media/fa831f2cb3ea13950dc43ee6574f7521.jpg" alt="Background" class="image" />
    <div class="overlay"></div>
    <div class="heading">{heading}</div>
</div>
