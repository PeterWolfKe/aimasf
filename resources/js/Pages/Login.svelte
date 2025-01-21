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

    body {
        background-color: $background-color;
        color: $text-color;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .login-form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-card {
        background-color: $neutral-white;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 2rem 2.5rem;
        width: 100%;
        max-width: 450px;
        transition: transform 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-5px);
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        color: $primary-blue;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        font-size: 1rem;
        color: $text-color;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 1.1rem;
        border: 1px solid $gray-white;
        border-radius: 8px;
        background-color: $neutral-white;
        color: $text-color;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: $primary-blue;
        box-shadow: 0 0 8px $primary-blue;
    }

    .submit-button {
        width: 100%;
        padding: 1.2rem;
        background-color: $primary-blue;
        border: none;
        border-radius: 8px;
        color: $neutral-white;
        font-size: 1.1rem;
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
        margin-top: 1.2rem;
        text-align: center;
    }

    .forgot-password {
        text-align: center;
        margin-top: 1rem;
        font-size: 1rem;
        color: $primary-blue;
        text-decoration: underline;
        cursor: pointer;
    }

    .forgot-password:hover {
        color: $primary-blue;
    }
</style>

<div class="login-form-container">
    <div class="form-card">
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
</div>
