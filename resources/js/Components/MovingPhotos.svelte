<script>
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    #MovingPhotos {
        background-color: white;
        padding: 40px 20px;
        text-align: center;
    }

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
        flex-direction: row-reverse;
        gap: 150px;
    }

    .text-container {
        width: 50%;
        color: $text-color;
        position: relative;
        padding-bottom: 60px;
    }

    h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 16px;
        color: $secondary-deep-blue;
    }

    p {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 20px;
        color: $secondary-dark-blue;
    }

    button {
        background-color: $secondary-deep-blue;
        color: white;
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.2rem;
        transition: background-color 0.3s ease;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);

        &:hover {
            background-color: $button-hover;
        }

        &::after {
            content: '→';
            font-size: 1.5rem;
            color: white;
        }
    }

    .image-container {
        width: 45%;
    }

    .image-container img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            align-items: center;
            padding: 20px;
            gap: 0;
        }

        .text-container {
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
            padding-bottom: 0;
        }

        .image-container {
            width: 100%;
            margin-bottom: 20px;
        }

        button {
            margin-top: 15px;
            position: static;
            transform: none;
        }

        h2 {
            font-size: 1.8rem;
        }

        p {
            font-size: 1rem;
        }
    }
</style>

<section id="MovingPhotos">
    <div class="container">
        <div class="image-container">
            <img src="https://testaima.my.canva.site/media/70231485861fc1121af1433da880708d.jpg" alt="Product Image" />
        </div>
        <div class="text-container">
            <h2>Čím sa zaoberáme?</h2>
            <p>
                Krvavé škvrny predstavujú pre ženy častý a nepríjemný problém, ktorý sa môže objaviť v tých najnevhodnejších momentoch. Nezáleží na tom, či ide o hektický pracovný deň, spoločenskú akciu alebo obyčajnú chvíľu – jedna škvrna dokáže poriadne rozhodiť.
            </p>
            <button></button>
        </div>
    </div>
</section>
