<script lang="ts">
    export let orders: Array<any> = [];
    console.log(orders);

    let page: number = 0; // Default page
    let perPage: number = 25; // Default items per page

    // Read URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    page = parseInt(urlParams.get('page') || '0');
    perPage = parseInt(urlParams.get('per_page') || String(perPage));

    // Functions for handling pagination
    const nextPage = () => {
        window.location.search = `?page=${page + 1}&per_page=${perPage}`;
    };

    const prevPage = () => {
        if (page > 0) {
            window.location.search = `?page=${page - 1}&per_page=${perPage}`;
        }
    };

    const logout = async (): Promise<void> => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (response.ok) {
            window.location.href = '/login';
        } else {
            console.error('Logout failed', response);
        }
    };

    // Calculate total price for an order
    const calculateTotalPrice = (products: Array<any>): number => {
        return products.reduce((sum, product) => {
            return sum + (product.price * product.quantity);
        }, 0);
    };
</script>

<style lang="scss">
    main {
        background-color: #f9f9f9;
        padding: 20px;
        font-family: Arial, sans-serif;

        @media (max-width: 768px) {
            padding: 10px;
        }
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background-color: white;
        white-space: nowrap;

        @media (max-width: 768px) {
            font-size: 14px;
        }
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;

        @media (max-width: 768px) {
            padding: 5px;
        }
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    button {
        margin: 5px;
        padding: 10px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;

        &:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            font-size: 14px;
            padding: 8px 12px;
        }
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;

        @media (max-width: 768px) {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    }

    .card {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);

        p {
            margin: 5px 0;
            color: #333;
        }

        strong {
            color: #4CAF50;
        }
    }
</style>

<main>
    <h1>Objednávky</h1>
    <button on:click={logout}>Logout</button>

    {#if orders.length > 0}
        {#if window.innerWidth > 768}
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Krstné meno</th>
                        <th>Priezvisko</th>
                        <th>Adresa</th>
                        <th>PSČ</th>
                        <th>Mesto</th>
                        <th>Telefónne číslo</th>
                        <th>Metóda doručenia</th>
                        <th>ID produktu</th>
                        <th>Meno produktu</th>
                        <th>Veľkosť produktu</th>
                        <th>Počet produktov</th>
                        <th>Celková suma</th>
                        <th>Zaplatené</th>
                        <th>Objednávka vytvorená</th>
                    </tr>
                    </thead>
                    <tbody>
                    {#each orders as order}
                        {#each order.products as product, index (index === 0 ? true : null)}
                            <tr on:click={() => window.location.href = `/admin/order/${order.id}`} style="cursor: pointer;">
                                {#if index === 0}
                                    <td rowspan={order.products.length}>{order.id}</td>
                                    <td rowspan={order.products.length}>{order.email}</td>
                                    <td rowspan={order.products.length}>{order.first_name}</td>
                                    <td rowspan={order.products.length}>{order.last_name}</td>
                                    <td rowspan={order.products.length}>{order.address}</td>
                                    <td rowspan={order.products.length}>{order.postal_code}</td>
                                    <td rowspan={order.products.length}>{order.city}</td>
                                    <td rowspan={order.products.length}>{order.phone}</td>
                                    <td rowspan={order.products.length}>{order.shipping_option_id}</td>
                                {/if}
                                <td>{product.product_id}</td>
                                <td>{product.name}</td>
                                <td>{product.size}</td>
                                <td>{product.quantity}</td>
                                {#if index === 0}
                                    <td rowspan={order.products.length}>
                                        {calculateTotalPrice(order.products).toFixed(2)}€
                                    </td>
                                    <td rowspan={order.products.length}>
                                        {order.paid ? "Áno" : "Nie"}
                                    </td>
                                    <td rowspan={order.products.length}>
                                        {new Date(order.created_at).toLocaleDateString()}
                                    </td>
                                {/if}
                            </tr>
                        {/each}
                    {/each}
                    </tbody>
                </table>
            </div>
        {:else}
            {#each orders as order}
                <div class="card">
                    <p><strong>ID:</strong> {order.id}</p>
                    <p><strong>Email:</strong> {order.email}</p>
                    <p><strong>Total:</strong> {calculateTotalPrice(order.products).toFixed(2)}€</p>
                </div>
            {/each}
        {/if}

        <div class="pagination">
            <button on:click={prevPage} disabled={page === 0}>Previous</button>
            <button on:click={nextPage}>Next</button>
        </div>
    {:else}
        <p>No orders found.</p>
    {/if}
</main>
