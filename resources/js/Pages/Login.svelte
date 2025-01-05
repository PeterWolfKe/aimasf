<script>
    import { onMount } from 'svelte';
    let email = '';
    let password = '';
    let error = '';

    const handleSubmit = async () => {
        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ email, password }),
            });

            if (response.ok) {
                window.location.href = '/admin';
            } else {
                const data = await response.json();
                error = data.message || 'Invalid credentials. Please try again.';
            }
        } catch (err) {
            error = 'An error occurred. Please try again later.';
        }
    };
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :global(body) {
        background-color: $background-color;
        color: $text-color;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .login-form-container {
        max-width: 900px;
        width: 400px;
        margin: 3rem auto;
        padding: 2.5rem;
        background-color: $neutral-white;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
    }

    h2 {
        text-align: center;
        margin-bottom: 2rem;
        font-size: 1.75rem;
        color: $text-color;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: bold;
        font-size: 1rem;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 1rem;
        border: 1px solid $gray-white;
        border-radius: 6px;
        background-color: $neutral-white;
        color: $text-color;
        font-size: 1rem;
        box-sizing: border-box;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: $primary-blue;
        box-shadow: 0 0 8px $primary-blue;
    }

    .submit-button {
        width: 100%;
        padding: 1rem;
        background-color: $button-background;
        border: none;
        border-radius: 6px;
        color: $neutral-white;
        font-size: 1.25rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: $button-hover;
    }

    .error-message {
        color: $dark-red;
        font-size: 1rem;
        margin-top: 1rem;
        text-align: center;
    }
</style>

<div class="login-form-container">
    <h2>Login</h2>
    <form on:submit|preventDefault={handleSubmit}>
        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                bind:value={email}
                placeholder="Enter your email"
                required
            />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                bind:value={password}
                placeholder="Enter your password"
                required
            />
        </div>
        <button type="submit" class="submit-button">Login</button>
    </form>
    {#if error}
        <p class="error-message">{error}</p>
    {/if}
</div>
