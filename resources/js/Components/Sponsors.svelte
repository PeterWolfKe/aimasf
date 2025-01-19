<script>
    import datacomp from '/resources/assets/datacomp.png';
    import kvety_interesante from '/resources/assets/kvety-interesante.png';
    import repro_centrum from '/resources/assets/repro-centrum.jpg';
    import rezke from '/resources/assets/rezke.webp';
    import vlny_sk from '/resources/assets/vlny-sk.png';
</script>

<style lang="scss">
    #sponsors {
        padding-bottom: 40px;
        background-color: white;
    }

    .container {
        position: relative;
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .line {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #000;
    }

    .button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .image-container {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        max-height: 80px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    @media (max-width: 768px) {
        .button {
            padding: 10px 16px;
            font-size: 14px;
        }

        .image-container {
            gap: 20px;
            justify-content: center;
            flex-direction: row;
        }

        .image-container img {
            max-height: 60px;
        }
    }

    @media (max-width: 480px) {
        .image-container {
            gap: 10px;
            flex-direction: row;
        }

        .image-container img {
            max-height: 50px;
        }
    }
</style>

<section id="sponsors">
    <div class="container">
        <div class="line"></div>
        <button class="button">Naši partneri</button>
    </div>
    <div class="image-container">
        <img src={datacomp} alt="Datacomp" />
        <img src={kvety_interesante} alt="Kvety Interesante" />
        <img src={repro_centrum} alt="Repro Centrum" />
        <img src={rezke} alt="Rezke" />
        <img src={vlny_sk} alt="Vlny SK" />
    </div>
</section>
