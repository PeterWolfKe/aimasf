<script lang="ts">
    export let productsData;
    export let shippingPriceDisplay;
    export let appliedDiscount: number = 0;
    export let totalPrice: number = 0;
</script>

<style lang="scss">
    @use '../../../scss/colors.scss' as *;

    .payment-order {
        display: flex;
        flex-direction: column;
        margin-bottom: auto;
    }

    .payment-wrapper {
        display: flex;
        flex-direction: column;
    }

    .summary-container {
        font-family: 'Arial', sans-serif;
    }

    .summary-product {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .summary-product img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .summary-product .details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .summary-product .title {
        font-weight: bold;
        color: #333;
    }

    .summary-price {
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 2rem;
        text-align: left;
    }

    .summary-product {
        position: relative;
    }

    .image-container {
        position: relative;
    }

    .image-container img {
        display: block;
        width: 100%;
    }

    .quantity {
        position: absolute;
        top: 2px;
        right: 2px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        width: 15px;
        height: 15px;
        border-radius: 9999px;
        font-size: 12px;
        display: flex;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 768px) {
        .summary-product {
            align-items: flex-start;
        }

        .summary-price {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .payment-order {
            flex-direction: column-reverse;
            margin-bottom: 0;
        }

        .order-summary {
            flex-direction: column-reverse;
        }
    }
</style>

<div class="payment-order">
    <div class="order-summary">
        <h2>Zhrnutie objednávky</h2>
        {#if productsData.length === 0}
            <p style="font-size: 2rem; font-weight: bold">Nemáte žiadne produkty na platbu.</p>
        {:else}
            {#each productsData as product}
                <div class="summary-product">
                    <div class="image-container">
                        <img src="{product.image ? '/storage/products/' + product.id + '/' + product.image : 'https://via.placeholder.com/150'}" alt="{product.name}">
                        <span class="quantity">{product.quantity}</span>
                    </div>
                    <div class="details">
                        <span class="title">{product.name || 'Nemenovaný produkt'}</span>
                        <span>{(Number(product.price) || 0).toFixed(2)} €</span>
                    </div>
                </div>
            {/each}
            <div class="summary-product">
                <div class="details">
                    {#if shippingPriceDisplay}
                        <span>
                            Cena dopravy:
                            <span>{shippingPriceDisplay}</span>
                        </span>
                    {/if}
                    {#if appliedDiscount}
                        <span>
                        Zľava: {appliedDiscount}%
                        </span>
                    {/if}
                </div>
            </div>
            <div class="summary-price">
                Celkom: {(Number(totalPrice) || 0).toFixed(2)} €
            </div>
        {/if}
    </div>
</div>
