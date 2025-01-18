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

    .oddiel {
        font-family: "Montserrat", sans-serif;
        margin: 0;
        background-color: #a9c6db;
        padding: 50px;
    }

    .hlavicka {
        text-align: center;
        padding: 10px 0;

        h1 {
            font-weight: bold;
            color: white;
            font-size: 50px;
            margin: 0;
        }
    }

    .produkt-kontajner {
        font-weight: 100;
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        margin: 15px 1cm;
        justify-content: start;
        color: #365a6e;
    }

    .galeria-obrazkov {
        margin-top: 1cm;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hlavny-obrazok {
        width: 100%;
        max-width: 400px; /* Adjusted max width */
        height: auto;
        border-radius: 10px;
        margin-top: 1cm;
        object-fit: contain; /* Maintain aspect ratio */
        transition: transform 0.3s ease; /* Smooth zoom effect */
    }

    .hlavny-obrazok:hover {
        transform: scale(1.1); /* Slight zoom effect */
    }

    .galeria-nahladov {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap; /* Allow wrapping for smaller screens */
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
        object-fit: cover; /* Crop image to fit */
        border-radius: 5px;
    }

    .detaily-produktu {
        margin-top: 1cm;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-right: 2cm;
    }

    .nazov-produktu {
        font-size: 35px;
        font-weight: bold;
    }

    .popis-produktu-velke {
        font-size: 25px;
        margin: 15px 0;
    }

    .popis-produktu {
        font-size: 14px;
    }

    .cena-produktu {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
    }

    .cena {
        background-color: #dbb4e7;
        padding: 6px 14px;
        font-weight: bold;
        border-radius: 15px;
        font-size: 30px;
        text-align: center;
        display: inline-block;
    }

    .vratane-dph {
        font-size: 12px;
    }

    .vyber-mnozstva {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .vyber-mnozstva button {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        background-color: #85b2d2;
        color: white;
        cursor: pointer;
        font-size: 16px;
    }

    .vyber-mnozstva input {
        width: 50px;
        text-align: center;
        font-size: 16px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .tlacidlo {
        margin: 0;
    }

    .tlacidlo button {
        font-family: "Montserrat";
        font-weight: bold;
        width: 250px;
        height: 50px;
        margin-left: 4cm;
        border: none;
        cursor: pointer;
        font-size: 25px;
        background-color: #dbb4e7;
        color: #365a6e;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 25px;
    }

    @media (max-width: 768px) {
        .produkt-kontajner {
            grid-template-columns: 1fr;
        }

        .hlavny-obrazok {
            max-width: 100%;
        }

        .galeria-nahladov {
            gap: 5px;
        }

        .nahlad {
            width: 50px;
            height: 50px;
        }
    }
</style>

<div class="oddiel">
    <div class="hlavicka">
        <h1>Zaujal vás náš produkt?</h1>
    </div>

    <div class="produkt-kontajner">
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

        <div class="detaily-produktu">
            <span class="nazov-produktu">{product.name}</span>
            <span class="popis-produktu-velke">{product.description}</span>

            <div class="cena-produktu">
                <div>
                    <span class="cena">{product.price}€</span>
                    <br />
                    <span class="vratane-dph">Vrátane DPH</span>
                </div>

                <div class="vyber-mnozstva">
                    <button on:click={decreaseQuantity}>&minus;</button>
                    <input type="number" value={quantity} min="1" max="10" />
                    <button on:click={increaseQuantity}>+</button>
                </div>

                <div class="tlacidlo">
                    <button on:click={buyNow}>Kúpiť</button>
                </div>
            </div>
        </div>
    </div>
</div>
