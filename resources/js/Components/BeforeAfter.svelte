<script>
    let aimaBefore = '/storage/images/aima_before.jpg'
    let aimaAfter = '/storage/images/aima_after.jpg'
</script>

<style>
    .container {
        max-width: 100%;
        text-align: center;
        background-color: #f9f9f9;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .title {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-family: 'Arial', sans-serif;
    }

    .image-wrapper {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 40px;
        align-items: center;
    }

    .image-wrapper img {
        width: 350px;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .image-caption {
        font-size: 20px;
        font-weight: 600;
        color: #444;
        margin-top: 15px;
        text-transform: capitalize;
        letter-spacing: 1px;
    }
</style>

<div class="container">
    <div class="title">Pred a po použití produktu</div>

    <div class="image-wrapper">
        <div>
            <img src={aimaBefore} alt="Pred použitím" />
            <div class="image-caption">Pred použitím</div>
        </div>
        <div>
            <img src={aimaAfter} alt="Po použití" />
            <div class="image-caption">Po použití</div>
        </div>
    </div>
</div>
