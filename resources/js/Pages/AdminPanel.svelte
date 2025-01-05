<script>
    const logout = async () => {
        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        if (response.ok) {
            window.location.href = '/login';
        }
    };
</script>

<main>
    <h1>Welcome to Admin Panel</h1>
    <button on:click={logout}>Logout</button>
</main>
