<script lang="ts">
    export let orders: Array<any> = [];
    let offset: number = 0;
    let perPage: number = 25;

    // Read URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    offset = parseInt(urlParams.get('page') || '0');
    perPage = parseInt(urlParams.get('per_page') || String(perPage));

    const logout = async (): Promise<void> => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        const response: Response = await fetch('/logout', {
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

    const nextPage = () => {
        window.location.search = `?offset=${offset + perPage}&per_page=${perPage}`;
    };

    const prevPage = () => {
        if (offset > 0) {
            window.location.search = `?offset=${Math.max(0, offset - perPage)}&per_page=${perPage}`;
        }
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    main {
        background-color: $background-color;
        color: $text-color;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: $neutral-white;
    }

    th, td {
        border: 1px solid $gray-white;
        padding: 8px;
    }

    th {
        background-color: $secondary-deep-blue;
        color: $neutral-white;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: $gray-white;
    }

    tr:hover {
        background-color: $secondary-purple;
        color: $text-color;
    }

    button {
        margin-bottom: 20px;
        padding: 10px 20px;
        background-color: $button-background;
        color: $neutral-white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: $button-hover;
        color: $secondary-dark-blue;
    }

    p {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>

<main>
    <h1>Orders</h1>
    <button on:click={logout}>Logout</button>

    {#if orders.length > 0}
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Postal Code</th>
                <th>City</th>
                <th>Phone</th>
                <th>Delivery Method</th>
                <th>Products</th>
                <th>Order ID</th>
                <th>Verified</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            {#each orders as order}
                <tr>
                    <td>{order.id}</td>
                    <td>{order.email}</td>
                    <td>{order.first_name}</td>
                    <td>{order.last_name}</td>
                    <td>{order.address}</td>
                    <td>{order.postal_code}</td>
                    <td>{order.city}</td>
                    <td>{order.phone}</td>
                    <td>{order.delivery_method}</td>
                    <td>{JSON.stringify(order.products)}</td>
                    <td>{order.unique_order_id}</td>
                    <td>{order.paid ? "Yes" : "No"}</td>
                    <td>{new Date(order.created_at).toLocaleDateString()}</td>
                </tr>
            {/each}
            </tbody>
        </table>

        <div class="pagination">
            <button on:click={prevPage} disabled={offset === 0}>Previous</button>
            <button on:click={nextPage}>Next</button>
        </div>
    {:else}
        <p>No orders found.</p>
    {/if}
</main>
