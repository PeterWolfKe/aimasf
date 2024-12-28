<script>
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    #about-us {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: $neutral-white;
    }

    .content {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        text-align: left;
    }

    .text-content {
        margin-right: 20px;
        max-width: 600px;
    }

    h2 {
        font-size: 48px;
        color: $text-color;
        font-weight: 700;
    }

    p {
        font-size: 22px;
        color: $text-color;
        line-height: 1.6;
    }

    .image-container {
        max-width: 600px;
    }

    .about-image {
        width: 100%;
        height: auto;
        border-radius: 30px;
    }

    @media (max-width: 768px) {
        .content {
            flex-direction: column;
            text-align: center;
        }

        .text-content {
            margin-right: 0;
            margin-bottom: 20px;
            max-width: 100%;
        }

        h2 {
            font-size: 32px;
        }

        p {
            font-size: 18px;
        }

        .image-container {
            max-width: 100%;
        }
    }
</style>

<section id="about-us" >
    <div class="content">
        <div class="text-content">
            <h2>O nás</h2>
            <p>
                Sme Aima! Kolektív mladých a
                ambicióznych ľudí z Gymnázia
                Poštová 9, ktorý prišiel s víziou
                pomáhať ľuďom riešiť bežné
                problémy inovatívnym a
                funkčným spôsobom. V Aime
                nás spája tímový duch,
                kreativita a túžba naučiť sa
                niečo nové.
            </p>
        </div>
        <div class="image-container">
            <img src="https://testaima.my.canva.site/media/4f2e18099688604bd85b812a0c2435aa.jpg" alt="About Us" class="about-image" />
        </div>
    </div>
</section>
