<script lang="ts">
    type Product = {
        id: string;
        name: string;
        description: string;
        price: string;
        image_url: string;
        size: string;
    };

    export let product: Product;
    export let productImages: string[] = [];

    let quantity: number = 1;
    let selectedImage: string = productImages[0];

    function increaseQuantity(): void {
        quantity++;
    }

    function decreaseQuantity(): void {
        if (quantity > 1) quantity--;
    }

    async function buyNow(): Promise<void> {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            alert('CSRF token not found');
            return;
        }

        const payload = {
            "id": product.id,
            "selected_size": product.size,
            "quantity": quantity
        };

        const response = await fetch('/buy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(payload),
        });

        if (response.ok) {
            window.location.href = '/payment';
        } else {
            alert('Error processing your order.');
        }
    }

    function selectImage(image: string): void {
        selectedImage = image;
    }
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    #product {
        scroll-margin-top: 50px;
    }

    .product-card {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        background-color: $neutral-white;
        color: $text-color;
        box-sizing: border-box;
        border-radius: 8px;

        .right {
            flex: 1 1 50%;
            display: flex;
            flex-direction: column;

            h1 {
                font-size: 2rem;
                color: $secondary-dark-blue;
                margin-bottom: 1rem;
            }

            .description {
                font-size: 1rem;
                color: $dark-gray;
                margin-bottom: 2rem;
            }

            .price {
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 1rem;

                small {
                    display: block;
                    font-size: 0.875rem;
                    color: $dark-gray;
                }
            }

            .options {
                margin-bottom: 2rem;

                h3 {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;
                }

                .size-buttons {
                    display: flex;
                    gap: 1rem;

                    button {
                        background-color: $button-background;
                        color: $neutral-white;
                        padding: 0.5rem 1rem;
                        font-size: 1rem;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;

                        &.selected {
                            background-color: $button-hover;
                        }
                    }
                }
            }

            .quantity {
                margin-bottom: 2rem;

                h3 {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;
                }

                .quantity-control {
                    display: flex;
                    align-items: center;
                    gap: 1rem;

                    span {
                        font-size: 1.2rem;
                    }
                }
            }

            .actions {
                display: flex;
                gap: 1rem;

                button {
                    flex: 1;
                    padding: 1rem;
                    font-size: 1rem;
                    background-color: $primary-blue;
                    color: $neutral-white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    text-align: center;

                    &:hover {
                        background-color: $secondary-dark-blue;
                    }
                }
            }
        }
    }

    .oddiel {
        font-family: "Montserrat", sans-serif;
        margin: 0;
        background-color: #b53631;
        padding: 50px;
    }

    .hlavicka {
        text-align: center;
        padding: 10px 0;
        margin-bottom: 10px;

        h1 {
            font-weight: bold;
            color: white;
            font-size: 70px;
            margin: 0;
        }
    }

    .galeria-obrazkov {
        margin-top: 1cm;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hlavny-obrazok {
        width: 100%;
        height: 300px;
        border-radius: 10px;
        width: 320px;
        margin: 20px;
        margin-bottom: 0;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .hlavny-obrazok:hover {
        transform: scale(1.05);
    }

    .galeria-nahladov {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .nahlad {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.2s ease-in-out;
    }

    #product {
        scroll-margin-top: 50px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hlavicka h1 {
        font-weight: bold;
        color: white;
        font-size: 50px;
        margin: 0;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .hlavny-obrazok:hover {
        transform: scale(1.1);
    }

    .galeria-nahladov {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .nahlad {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .nahlad:hover {
        transform: scale(1.1);
    }

    .price {
        font-size: 1.8rem;
        font-weight: bold;
        color: #d72638;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .quantity-control button {
        background-color: #d72638;
        color: white;
        font-size: 1.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .quantity-control button:hover {
        background-color: #d72638;
    }

    .actions button {
        background-color: #d72638;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1.2rem;
        transition: background-color 0.3s, transform 0.2s;
    }

    .actions button:hover {
        background-color: #d72638;
        transform: scale(1.05);
    }
    .nahlad:hover {
        border: 2px solid $primary-blue;
    }

    .nahlad img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .quantity h3 {
            margin: 0;
        }

        .product-card .right .description {
            margin-bottom: 10px;
        }
        .product-card {
            gap: 0;
        }
        .hlavicka h1 {
            font-size: 40px;
        }

        .oddiel {
            padding: 10px;
        }

        .produkt-kontajner {
            grid-template-columns: 1fr;
            margin: 0;
            padding: 10px;
            gap: 0;
        }

        .hlavny-obrazok {
            margin: 0;
        }

        .galeria-nahladov {
            gap: 5px;
            margin-top: 5px;
        }

        .nahlad {
            width: 40px;
            height: 40px;
        }

        .detaily-produktu {
            margin-top: 10px;
            margin-right: 0;
            padding: 5px;
        }

        .nazov-produktu {
            font-size: 18px;
            font-weight: bold;
        }

        .popis-produktu-velke {
            font-size: 14px;
        }

        .popis-produktu {
            font-size: 12px;
        }

        .vratane-dph {
            font-size: 10px;
        }

        .vyber-mnozstva button {
            padding: 4px 8px;
            font-size: 14px;
        }

        .vyber-mnozstva input {
            font-size: 14px;
            width: 40px;
        }

        .tlacidlo button {
            font-size: 16px;
            width: 180px;
            margin-left: 0;
        }
        .galeria-obrazkov {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 0;
            gap: 10px;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hlavicka h1 {
        font-weight: bold;
        color: white;
        font-size: 50px;
        margin: 0;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .nahlad:hover {
        transform: scale(1.1);
    }

    .price {
        font-size: 1.8rem;
        font-weight: bold;
        color: #d72638;
    }

    .quantity-control button {
        background-color: #d72638;
        color: white;
        font-size: 1.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .quantity-control button:hover {
        background-color: #d72638;
    }

    .actions button {
        background-color: #d72638;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1.2rem;
        transition: background-color 0.3s, transform 0.2s;
    }

    .actions button:hover {
        background-color: #d72638;
        transform: scale(1.05);
    }
    .actions button {
        background: linear-gradient(135deg, #d72638, #d72638);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: bold;
        box-shadow: 0px 4px 10px rgba(255, 77, 109, 0.3);
        transition: background 0.3s, transform 0.2s, box-shadow 0.3s;

        &:hover {
            background: linear-gradient(135deg, #d72638, #a81d2b);
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(215, 38, 56, 0.4);
        }
    }

    .quantity-control button {
        background-color: #d72638;
        color: white;
        font-size: 1.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;

        &:hover {
            background-color: #d72638;
            transform: scale(1.1);
        }
    }
</style>

<div class="oddiel" id="product">
    <div class="hlavicka">
        <h1>Nevieš čo na Valentína? Kúp jej Aimu!</h1>
    </div>

    <div class="product-card">
        <div class="galeria-obrazkov">
            <img class="hlavny-obrazok" src="/storage/products/{product.id}/{selectedImage}" alt="Hlavný obrázok produktu"/>
            <div class="galeria-nahladov">
                {#each productImages as image}
                    <button
                        type="button"
                        class="nahlad"
                        on:click={() => selectImage(image)}
                        aria-label="Select image {image}">
                        <img src="/storage/products/{product.id}/{image}" alt="Náhľad produktu" />
                    </button>
                {/each}
            </div>
        </div>

        <div class="right">
            <h1>{product.name}</h1>
            <div class="description">
                {product.description}
            </div>
            <div class="price">
                {product.price} €
                <small>vrátane dane</small>
            </div>
            <!--<div class="options">
                <h3>Vyberte si veľkosť</h3>
                <div class="size-buttons">
                    <button
                        class:selected={selectedSize === "10ml"}
                        on:click={() => (selectedSize = "10ml")}
                    >
                        10ml
                    </button>
                    <button
                        class:selected={selectedSize === "3ml"}
                        on:click={() => (selectedSize = "3ml")}
                    >
                        3ml
                    </button>
                </div>
            </div>-->
            <div class="quantity">
                <h3>Množstvo</h3>
                <div class="quantity-control">
                    <button on:click={decreaseQuantity}>-</button>
                    <span>{quantity}</span>
                    <button on:click={increaseQuantity}>+</button>
                </div>
            </div>
            <div class="actions">
                <button on:click={buyNow}>Kúpiť</button>
            </div>
        </div>
    </div>
</div>
