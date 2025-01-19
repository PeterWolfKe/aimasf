<script>
    let aima_team = '/storage/images/aima_team.jpg';
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    #about-us {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 70px 20px 20px;
        background-color: $neutral-white;
    }

    .content {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        text-align: justify;
    }

    .text-content {
        margin-right: 80px;
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
        width: 500px;
        height: auto;
        border-radius: 30px;
    }

    @media (max-width: 768px) {
        #about-us {
            padding: 20px 20px;
        }
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
        .about-image {
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
        }
    }
</style>

<section id="about-us" >
    <div class="content">
        <div class="text-content">
            <h2>O nás</h2>
            <p>
                Sme študentská firma Aima z Gymnázia Poštová 9, Košice. Náš kolektív tvorí 23 mladých ľudí, ktorí chcú
                získať praktické skúsenosti a zručnosti v oblasti podnikania. Umožňuje nám to nezisková organizácia
                JA Slovensko, ktorá zastrešuje študentské firmy. Našou víziou je pomôcť ľuďom zbaviť sa strachu a poskytnúť
                im pocit istoty a bezpečia v tých najnepríjemnejších situáciách.
            </p>
        </div>
        <div class="image-container">
            <img src={aima_team} alt="About Us" class="about-image" />
        </div>
    </div>
</section>
