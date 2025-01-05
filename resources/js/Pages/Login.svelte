<script>
    let email = '';
    let password = '';
    let error = '';

    const handleSubmit = async () => {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email, password })
        });

        if (response.ok) {
            window.location.href = '/admin';
        } else {
            const data = await response.json();
            error = data.message || 'Invalid credentials';
        }
    };
</script>

<main>
    <form on:submit|preventDefault={handleSubmit}>
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" bind:value={email} required />
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" bind:value={password} required />
        </div>
        {#if error}
            <div class="error">{error}</div>
        {/if}
        <button type="submit">Login</button>
    </form>
</main>
