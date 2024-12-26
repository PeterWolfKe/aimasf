<script>
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .about-us {
        background-color: $neutral-white;
        color: $text-color;
        padding: 6rem 2rem;
        border-radius: 0.5rem;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        text-align: center;
        display: flex;
        justify-content: space-between; /* Align the items horizontally */
        align-items: flex-start; /* Align items at the top */
        gap: 2rem; /* Adds space between the columns */
        flex-wrap: wrap; /* Allows items to wrap on smaller screens */
    }

    .about-us .section {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 45%; /* Adjust to control the width of each section */
    }

    h2 {
        color: $secondary-dark-blue;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }

    p {
        font-size: 1.5rem;
        line-height: 1.6;
        max-width: 100%;
        margin-bottom: 1rem;
    }

    .highlight {
        color: $dark-red;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .about-us {
            padding: 2rem 1rem;
            flex-direction: column; /* Stack the sections vertically on small screens */
            align-items: center;
        }

        .about-us .section {
            max-width: 100%;
        }

        h2 {
            font-size: 1.5rem;
        }

        p {
            font-size: 0.9rem;
        }
    }
</style>

<div class="about-us">
    <div class="section">
        <h2>Problém:</h2>
        <p>
            <strong>Krvavé škvrny</strong>
            predstavujú pre ženy častý a nepríjemný problém, ktorý sa môže objaviť v tých najnevhodnejších momentoch. Nezáleží na tom, či ide o hektický pracovný deň,
            spoločenskú akciu alebo obyčajnú chvíľu – jedna škvrna dokáže poriadne rozhodiť.
        </p>
    </div>
    <div class="section">
        <h2>Naše riešenie:</h2>
        <p>
            Aima prináša okamžitý odstraňovač krvi, ktorý je
            navrhnutý tak, aby sa pohodlne zmestil do tašky aj kabelky. Tento praktický produkt
            pomáha ženám cítiť sa sebavedomo aj počas menštruačných dní, čím eliminuje obavy z
            nepríjemných škvŕn na oblečení.
        </p>
    </div>
</div>
