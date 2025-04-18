<script lang="ts">
    export let order: any;
    console.log(order);

    const formatDate = (date: string): string => {
        const options: Intl.DateTimeFormatOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        };
        return new Date(date).toLocaleDateString('sk-SK', options);
    };

    const getStatusName = (status: number): string => {
        switch (status) {
            case 0:
                return 'Nezaplatené';
            case 1:
                return 'Zaplatené';
            case 2:
                return 'Doručené';
            case 3:
                return 'Prevzaté';
            default:
                return String(status);
        }
    };

    const sendOrderDelivered = async (orderId: number): Promise<void> => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        try {
            const response = await fetch(`/admin/order-delivered/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            });

            if (response.ok) {
                alert(`Email sent successfully for order ID: ${orderId}`);
                location.reload();
            } else {
                const errorData = await response.json();
                console.error('Error sending email:', errorData);
                alert(`Failed to send email for order ID: ${orderId}`);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        }
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

    .action-btn {
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .action-btn:hover {
        background-color: #4338ca;
    }

    .action-btn:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }

    @media (max-width: 784px) {
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
        .products > thead, .products > tbody {
            display:inline-block;
        }
    }
</style>

<main>
    <h1>Informácie o objednávke</h1>

    <div class="section">
        <h2>Údaje o zákazníkovi</h2>
        <p><strong>Meno:</strong> {order.first_name} {order.last_name}</p>
        <p><strong>Email:</strong> {order.email}</p>
        <p><strong>Telefón:</strong> {order.phone}</p>
        <p><strong>Adresa:</strong> {order.address}</p>
        <p><strong>Byt/Suite:</strong> {order.apartment_suite || 'N/A'}</p>
        <p><strong>Mesto:</strong> {order.city}</p>
        <p><strong>PSČ:</strong> {order.postal_code}</p>
        <p><strong>Ip adresa:</strong> {order.ip_address}</p>
    </div>

    <div class="section">
        <h2>Detaily objednávky</h2>
        <p><strong>ID objednávky:</strong> {order.id}</p>
        <p><strong>Unikátne ID:</strong> {order.unique_order_id}</p>
        <p><strong>Spôsob doručenia:</strong> {order.shipping_option_id}</p>
        <p>
            <strong>Status:</strong>
            <span class="status">
                {getStatusName(order.status)}
            </span>
        </p>
        <p><strong>Zľavový kód:</strong> {order.discount_code || 'N/A'}</p>
        <p><strong>Vytvorené:</strong> {formatDate(order.created_at)}</p>
        <p><strong>Aktualizované:</strong> {formatDate(order.updated_at)}</p>
    </div>

    <div class="section">
        <h2>Produkty</h2>
        {#if window.innerWidth > 768}
            <table class="products horizontal-table">
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
                        <td>{product.id}</td>
                        <td>{product.name}</td>
                        <td>{product.size}</td>
                        <td>{product.quantity}</td>
                        <td>{product.price}</td>
                        <td>{(product.price * product.quantity).toFixed(2)}</td>
                    </tr>
                {/each}
                </tbody>
            </table>
        {:else}
            {#each order.products as product}
                <table class="products vertical-table">
                    <tr>
                        <th>ID produktu:</th>
                        <td>{product.id}</td>
                    </tr>
                    <tr>
                        <th>Názov:</th>
                        <td>{product.name}</td>
                    </tr>
                    <tr>
                        <th>Veľkosť:</th>
                        <td>{product.size}</td>
                    </tr>
                    <tr>
                        <th>Množstvo:</th>
                        <td>{product.quantity}</td>
                    </tr>
                    <tr>
                        <th>Cena (€):</th>
                        <td>{product.price}</td>
                    </tr>
                    <tr>
                        <th>Spolu (€):</th>
                        <td>{(product.price * product.quantity).toFixed(2)}</td>
                    </tr>
                </table>
            {/each}
        {/if}
        <p><strong>Celková suma:</strong> {order.totalPrice.toFixed(2)}€</p>
    </div>

    <div class="section">
        <h2>Akcie</h2>
        <button class="action-btn" on:click={() => sendOrderDelivered(order.id)} disabled={order.status !== 1}>
            Doručené
        </button>
    </div>

    <button on:click={() => window.history.back()}>Späť</button>
</main>
