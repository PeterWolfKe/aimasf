<script lang="ts">
    export let order: { unique_order_id: string, amount: number };
    export let amount: number;
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    /* Apply border-box box-sizing for all elements */
    * {
        box-sizing: border-box;
    }

    /* Full screen container */
    .success-container {
        background-color: $background-color;
        color: $text-color;
        padding: 2rem;
        text-align: center;
        border-radius: 10px;
        width: 100%;
        height: 100vh; /* Full height */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: $primary-blue;
    }

    p {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        color: $dark-gray;
    }

    .order-info {
        font-size: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background-color: $secondary-purple;
        border-radius: 5px;
        color: $secondary-dark-blue;
    }

    .back-button {
        background-color: $button-background;
        color: $neutral-white;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        margin-top: 2rem;
    }

    .back-button:hover {
        background-color: $button-hover;
    }

    /* Mobile responsiveness */
    @media (max-width: 600px) {
        h1 {
            font-size: 2rem; /* Adjust font size for smaller screens */
        }

        p {
            font-size: 1rem; /* Adjust paragraph text for mobile */
        }

        .order-info {
            font-size: 0.9rem; /* Reduce font size for smaller screens */
        }

        .back-button {
            padding: 0.6rem 1.2rem; /* Smaller padding on mobile */
            font-size: 0.9rem; /* Adjust font size for mobile */
        }
    }
</style>

<div class="success-container">
    <h1>Platba bola úspešná!</h1>
    <p>Ďakujeme za vašu platbu. Vaša transakcia bola úspešne dokončená.</p>

    <div class="order-info">
        <p><strong>ID objednávky:</strong> {order.unique_order_id}</p>
        <p><strong>Suma zaplatená:</strong> {amount} EUR</p>
    </div>

    <a href="/" class="back-button">Návrat na domovskú stránku</a>
</div>
