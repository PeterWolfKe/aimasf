<script lang="ts">
    export let orders: Array<any> = [];
    console.log(orders);

    let page: number = 0;
    let perPage: number = 25;

    const urlParams = new URLSearchParams(window.location.search);
    page = parseInt(urlParams.get('page') || '0');
    perPage = parseInt(urlParams.get('per_page') || String(perPage));

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

    const calculateTotalPrice = (products: Array<any>): number => {
        return products.reduce((sum, product) => {
            return sum + (product.price * product.quantity);
        }, 0);
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
                return 'unknown';
        }
    };

    const getStatusClass = (status: number): string => {
        switch (status) {
            case 0:
                return 'pending';
            case 1:
                return 'success';
            case 2:
                return 'delivered';
            case 3:
                return 'completed';
            default:
                return String(status);
        }
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

        p {
            margin: 5px 0;
            color: #333;
        }

        strong {
            color: #4CAF50;
        }
    }

    .status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;

        &.pending {
            color: #f59e0b;
            background: #fef3c7;
        }

        &.success {
            color: #10b981;
            background: #d1fae5;
        }

        &.delivered {
            color: #3b82f6;
            background: #dbeafe;
        }

        &.completed {
            color: #9333ea;
            background: #ede9fe;
        }

        &.unknown {
            color: #6b7280;
            background: #f3f4f6;
        }
    }

    .action-btn {
        padding: 6px 12px;
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
                        <th>Order</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Delivery</th>
                        <th>Items</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {#each orders as order}
                        <tr>
                            <td>#{order.id}</td>
                            <td>{new Date(order.created_at).toLocaleDateString()}</td>
                            <td>{order.first_name} {order.last_name}</td>
                            <td>
                                <span class="status {getStatusClass(order.status)}">
                                    {getStatusName(order.status)}
                                </span>
                            </td>
                            <td>{order.totalPrice.toFixed(2)}€</td>
                            <td>{order.shipping_option_id || 'N/A'}</td>
                            <td>{order.products.length} items</td>
                            <td>
                                <button class="action-btn" on:click={() => window.location.href = `/admin/order/${order.id}`}>
                                    Details
                                </button>
                            </td>
                        </tr>
                    {/each}
                    </tbody>
                </table>
            </div>
        {:else}
            {#each orders as order}
                <div
                    class="card"
                    role="button"
                    tabindex="0"
                    on:click={() => window.location.href = `/admin/order/${order.id}`}
                    on:keydown={(e) => (e.key === 'Enter' || e.key === ' ') && (window.location.href = `/admin/order/${order.id}`)}
                >
                    <p><strong>ID:</strong> {order.id}</p>
                    <p><strong>Email:</strong> {order.email}</p>
                    <p><strong>Total:</strong> {order.totalPrice.toFixed(2)}€</p>
                    <p><strong>Status:</strong>
                        <span class="status {getStatusClass(order.status)}">
                            {getStatusName(order.status)}
                        </span>
                    </p>
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
