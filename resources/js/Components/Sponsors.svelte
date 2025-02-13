<script>
    let datacomp = '/storage/images/datacomp.webp';
    let kvety_interesante = '/storage/images/kvety-interesante.webp';
    let repro_centrum = '/storage/images/repro-centrum.webp';
    let rezke = '/storage/images/rezke.webp';
    let vlny_sk = '/storage/images/vlny-sk.webp';

    let links = {
        datacomp: 'https://datacomp.sk/',
        kvety_interesante: 'http://www.interesante.sk/',
        repro_centrum: 'https://www.reprocentrum.sk/',
        rezke: 'https://rezke.sk/',
        vlny_sk: 'https://www.vlny.sk/'
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    #sponsors {
        padding-bottom: 40px;
        background-color: white;
        border-top: white solid;
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
        background-color: $primary-blue;
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
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .image-container img:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
        <a href={links.datacomp} target="_blank">
            <img src={datacomp} alt="Datacomp" />
        </a>
        <a href={links.kvety_interesante} target="_blank">
            <img src={kvety_interesante} alt="Kvety Interesante" />
        </a>
        <a href={links.repro_centrum} target="_blank">
            <img src={repro_centrum} alt="Repro Centrum" />
        </a>
        <a href={links.rezke} target="_blank">
            <img src={rezke} alt="Rezke" />
        </a>
        <a href={links.vlny_sk} target="_blank">
            <img src={vlny_sk} alt="Vlny SK" />
        </a>
    </div>
</section>
