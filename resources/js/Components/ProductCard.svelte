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

    let showDescription = false;
    let showZlozenie = false;

    const { shortDescription, longDescription } = splitDescription(product.description);
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

    function splitDescription(description: string): { shortDescription: string; longDescription: string } {
        const sentences = description.split('.');
        const shortDescription = sentences[0].trim() + '.';
        const longDescription = sentences.slice(1).join('.').trim();

        return { shortDescription, longDescription };
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
        border-radius: 32px;

        .right {
            flex: 1 1 50%;
            flex-direction: column;

            h1 {
                font-size: 2rem;
                color: $secondary-dark-blue;
                margin-bottom: 1rem;
            }

            .description {
                font-size: 1rem;
                color: $secondary-dark-blue;
            }

            .price {
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 1rem;
                margin-top: 1rem;

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

                    button {
                        background-color: $primary-blue;
                        color: $neutral-white;
                        font-size: 1.5rem;
                        padding: 0.5rem 1rem;
                        border: none;
                        height: 44px;
                        width: 44px;
                        border-radius: 4px;
                        cursor: pointer;
                        transition: background 0.3s, transform 0.2s, box-shadow 0.3s;

                        &:hover {
                            transform: scale(1.05);
                            box-shadow: 0px 6px 12px rgba($primary-blue, 0.4);
                        }
                    }

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
                    transition: background 0.3s, transform 0.2s, box-shadow 0.3s;

                    &:hover {
                        box-shadow: 0px 6px 12px rgba($primary-blue, 0.4);
                        transform: scale(1.05);
                    }
                }
            }
        }
    }

    .oddiel {
        font-family: "Montserrat", sans-serif;
        margin: 0;
        background-color: $background-color;
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
        height: 240px;
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

    .nahlad:hover {
        border: 2px solid $primary-blue;
    }

    .nahlad img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .zlozenie {
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .zlozenie.hidden {
        max-height: 0;
    }

    .zlozenie.visible {
        max-height: 500px;
    }

    .zlozenie p {
        margin: 0;
        margin-bottom: 1rem;
    }

    .toggle-button {
        display: inline-block;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        margin-bottom: 5px;
        margin-top: 5px;
        color: #002b5a;
    }

    .toggle-button::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 2px;
        background-color: black;
        transform: translateX(-50%);
        transition: width 0.3s ease;
    }

    .toggle-button:hover::after {
        width: 100%;
    }

    .arrow {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .description p {
        margin: 0;
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
</style>

<div class="oddiel" id="product">
    <div class="hlavicka">
        <h1>Zaujal vás náš produkt?</h1>
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
            <div class="toggle-container">
                <div class="toggle-button" on:click={() => (showDescription = !showDescription)}>
                    Popis produktu
                    <span class="arrow">{showDescription ? '▲' : '▼'}</span>
                </div>
            </div>
            <div class={`description zlozenie ${showDescription ? 'visible' : 'hidden'}`}>
                <p>{product.description}</p>
            </div>
            <div class="toggle-container">
                <div class="toggle-button" on:click={() => (showZlozenie = !showZlozenie)}>
                    Zloženie
                    <span class="arrow">{showZlozenie ? '▲' : '▼'}</span>
                </div>
            </div>
            <div class={`description zlozenie ${showZlozenie ? 'visible' : 'hidden'}`}>
                <p style="margin-top: 2px;">Voda, Bieliace činidlá na báze aktívneho kyslíka, Kyselina citrónová, Kokamidopropyl betaín, Hydrogenuhličitan sodný</p>
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
