<script lang="ts">
    export let order: any;

    // Format the date to a readable format
    const formatDate = (date: string): string => {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString('sk-SK', options);
    };

    // Calculate total price of the order
    const calculateTotalPrice = (products: Array<any>): number => {
        return products.reduce((sum, product) => sum + (product.price * product.quantity), 0);
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    main {
        background-color: $background-color;
        color: $text-color;
        font-family: Arial, sans-serif;
        padding: 20px;
        max-width: 800px;
        margin: 10px auto;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: $secondary-deep-blue;
    }

    .section {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
        background-color: $neutral-white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .products {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    .products th, .products td {
        padding: 8px;
        border: 1px solid $gray-white;
        text-align: left;
        font-size: 14px;
    }

    .products th {
        background-color: $primary-blue;
        color: $neutral-white;
    }

    .products tr:nth-child(even) {
        background-color: $gray-white;
    }

    button {
        margin-top: 20px;
        padding: 10px 15px;
        background-color: $button-background;
        color: $neutral-white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: $button-hover;
    }

    @media (max-width: 600px) {
        main {
            padding: 15px;
        }

        h1, h2 {
            font-size: 18px;
        }

        .products th, .products td {
            font-size: 12px;
            padding: 6px;
        }

        button {
            font-size: 14px;
            padding: 8px 12px;
        }
    }
</style>

<main>
    <h1>Informácie o objednávke</h1>

    <div class="section">
        <h2>Údaje o zákazníkovi</h2>
        <p><strong>Meno:</strong> {order.first_name} {order.last_name}</p>
        <p><strong>Email:</strong> {order.email}</p>
        <p><strong>Telefón:</strong> {order.phone || 'N/A'}</p>
        <p><strong>Adresa:</strong> {order.address}</p>
        <p><strong>Byt/Suite:</strong> {order.apartment_suite || 'N/A'}</p>
        <p><strong>Mesto:</strong> {order.city}</p>
        <p><strong>PSČ:</strong> {order.postal_code}</p>
    </div>

    <div class="section">
        <h2>Detaily objednávky</h2>
        <p><strong>ID objednávky:</strong> {order.id}</p>
        <p><strong>Unikátne ID:</strong> {order.unique_order_id}</p>
        <p><strong>Spôsob doručenia:</strong> {order.shipping_option_id}</p>
        <p><strong>Zaplatené:</strong> {order.paid ? 'Áno' : 'Nie'}</p>
        <p><strong>Zľavový kód:</strong> {order.discount_code || 'N/A'}</p>
        <p><strong>Vytvorené:</strong> {formatDate(order.created_at)}</p>
        <p><strong>Aktualizované:</strong> {formatDate(order.updated_at)}</p>
    </div>

    <div class="section">
        <h2>Produkty</h2>
        <table class="products">
            <thead>
            <tr>
                <th>ID produktu</th>
                <th>Názov</th>
                <th>Veľkosť</th>
                <th>Množstvo</th>
                <th>Cena (€)</th>
                <th>Spolu (€)</th>
            </tr>
            </thead>
            <tbody>
            {#each order.products as product}
                <tr>
                    <td>{product.product_id}</td>
                    <td>{product.name}</td>
                    <td>{product.size}</td>
                    <td>{product.quantity}</td>
                    <td>{product.price}</td>
                    <td>{(product.price * product.quantity).toFixed(2)}</td>
                </tr>
            {/each}
            </tbody>
        </table>
        <p><strong>Celková suma:</strong> {calculateTotalPrice(order.products).toFixed(2)}€</p>
    </div>

    <button on:click={() => window.history.back()}>Späť</button>
</main>
