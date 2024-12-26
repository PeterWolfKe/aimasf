<script>

</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .about-us {
        background-color: $background-color;
        color: $text-color;
        padding: 6rem 2rem;
        border-radius: 0.5rem;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        h2 {
            color: $secondary-dark-blue;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        p {
            font-size: 1.5rem;
            line-height: 1.6;
            max-width: 1500px;
            margin-bottom: 1rem;
        }

        .highlight {
            color: $dark-red;
            font-weight: bold;
        }
    }

    @media (max-width: 768px) {
        .about-us {
            padding: 2rem 1rem;

            h2 {
                font-size: 1.5rem;
            }

            p {
                font-size: 0.9rem;
                max-width: 100%;
            }
        }
    }
</style>

<div class="about-us">
    <h2>Čím sa zaoberáme?</h2>
    <p>
        <strong>Problematika, ktorou sa zaoberáme: </strong> <span class="highlight">Krvavé škvrny</span>
        predstavujú pre ženy častý a nepríjemný problém, ktorý sa môže objaviť v tých najnevhodnejších momentoch. Nezáleží na tom, či ide o hektický pracovný deň,
        spoločenskú akciu alebo obyčajnú chvíľu – jedna škvrna dokáže poriadne rozhodiť.
    </p>
    <p>
        <strong>Naše riešenie:</strong> Aima prináša okamžitý odstraňovač krvi, ktorý je
        navrhnutý tak, aby sa pohodlne zmestil do tašky aj kabelky. Tento praktický produkt
        pomáha ženám cítiť sa sebavedomo aj počas menštruačných dní, čím eliminuje obavy z
        nepríjemných škvŕn na oblečení.
    </p>
</div>
