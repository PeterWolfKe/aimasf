<script lang="ts">
    export let shippingOptions: { id: string, title: string, price: string, address: string }[] = [];
    export let userDetails: { deliveryMethod: string };
</script>

<style lang="scss">
    @use '../../../scss/colors.scss' as *;

    h2 {
        margin-bottom: 1rem;
    }
    .shipping-methods {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-top: 1rem;
        box-sizing: border-box;
    }

    .shipping-option {
        display: flex;
        width: 100%;
        align-items: center;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f9f9f9;
        transition: background-color 0.3s, border-color 0.3s;
        box-sizing: border-box;
        font-size: 0.9rem;
    }

    .shipping-option * {
        cursor: pointer;
    }

    .shipping-methods > label {
        margin: 0;
    }

    .shipping-option:hover {
        border-color: #0077ff;
    }

    .shipping-option input {
        appearance: none;
        width: 0.5rem;
        height: 0.5rem;
        padding: 12px;
        transform: scale(0.8);
        margin-right: 0.8rem;
        margin-bottom: 1rem;
        border: 2px solid #777;
        border-radius: 50%;
        background-color: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .shipping-option input:checked {
        border-color: black;
        background-color: black;
    }

    .shipping-option input:checked::before {
        content: '';
        width: 0.6rem;
        height: 0.6rem;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: block;
    }

    .shipping-option label {
        display: flex;
        width: 100%;
        margin-bottom: .5rem;
    }

    .option-details {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .option-details .title {
        font-weight: bold;
        color: #333;
    }

    .option-details .address {
        color: #777;
        font-size: 0.85rem;
    }

    .price-wrapper{
        display: flex;
        justify-content: space-between;
    }

    .price {
        font-weight: bold;
        color: #0077ff;
        text-align: right;
        margin-left: 5px;
    }
    @media (max-width: 768px) {
        .shipping-methods {
            max-height: none;
        }
    }
</style>

<h2>Doprava</h2>
<div class="shipping-methods">
    {#each shippingOptions as option}
        <label for={option.id}>
            <div class="shipping-option">
                <input
                    type="radio"
                    id={option.id}
                    name="deliveryMethodID"
                    value={option.id}
                    bind:group={userDetails.deliveryMethod}
                />
                <label for={option.id}>
                    <div class="option-details">
                        <div class="price-wrapper">
                            <span class="title">{option.title}</span>
                            <span class="price">
                                {#if option.price === '0'}
                                    ZADARMO
                                {:else}
                                    {option.price}€
                                {/if}
                            </span>
                        </div>
                        <span class="address">{option.address}</span>
                    </div>
                </label>
            </div>
        </label>
    {/each}
</div>
