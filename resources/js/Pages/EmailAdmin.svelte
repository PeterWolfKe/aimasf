<script>
    import { onMount } from "svelte";

    let email = "";
    let successMessage = "";
    let errorMessage = [];
    export let emails = [];

    onMount(async () => {
        try {
            let response = await fetch("/admin/email/emails");
            let data = await response.json();

            if (response.ok) {
                emails = data.emails || [];
            } else {
                errorMessage.push(data.error || "An error occurred while fetching emails.");
            }
        } catch (error) {
            errorMessage.push("Failed to fetch emails.");
        }
    });

    async function addEmail() {
        try {
            let response = await fetch("/admin/email/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ email }),
            });

            let data = await response.json();

            if (response.ok) {
                email = "";
                successMessage = data.message || "Email added successfully!";
                errorMessage = [];
                emails.push(email);
            } else {
                errorMessage.push(data.error || "An error occurred.");
                successMessage = "";
            }
        } catch (error) {
            errorMessage.push("Failed to add email.");
            successMessage = "";
        }
    }

    async function sendEmails() {
        try {
            let response = await fetch("/admin/email/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            let data = await response.json();

            if (response.ok) {
                successMessage = data.message || "Emails sent successfully!";
                errorMessage = [];
            } else {
                errorMessage.push(data.error || "An error occurred.");
                successMessage = "";
            }
        } catch (error) {
            errorMessage.push("Failed to send emails.");
            successMessage = "";
        }
    }
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :global(body, html) {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        background-color: $background-color;
        font-family: Arial, sans-serif;
    }

    .newsletter-container {
        color: $text-color;
        max-width: 800px;
        margin: 40px auto;
        padding: 40px;
        background-color: $neutral-white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        font-size: 2rem;
        margin-bottom: 24px;
        color: $primary-blue;
    }

    h3 {
        font-size: 1.5rem;
        margin: 24px 0 16px;
        color: $dark-gray;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;

        input {
            padding: 12px;
            border: 1px solid $dark-gray;
            border-radius: 6px;
            font-size: 1rem;
            width: 100%;
            outline: none;
            transition: border-color 0.3s ease;

            &:focus {
                border-color: $primary-blue;
            }
        }

        .btn {
            background-color: $button-background;
            color: $neutral-white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;

            &:hover {
                background-color: $button-hover;
            }
        }
    }

    ul {
        list-style: none;
        padding: 0;
        width: 100%;
        max-width: 400px;
        margin: 20px auto;

        li {
            background: $neutral-white;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }

    .send-btn {
        width: 100%;
        max-width: 400px;
        margin: 24px auto 0;
    }

    .success-message {
        color: $primary-blue;
        font-weight: bold;
        margin: 16px 0;
    }

    .error-message {
        color: $dark-red;
        font-weight: bold;
        margin: 16px 0;
    }

    @media (max-width: 600px) {
        .newsletter-container {
            padding: 24px;
        }

        h2 {
            font-size: 1.75rem;
        }

        h3 {
            font-size: 1.25rem;
        }

        .input-group {
            gap: 12px;
        }

        .btn, .send-btn {
            font-size: 1rem;
        }
    }
</style>

<main class="newsletter-container">
    <h2>Newsletter Subscription</h2>

    {#if successMessage}
        <p class="success-message">{successMessage}</p>
    {/if}

    {#each errorMessage as message}
        <p class="error-message">{message}</p>
    {/each}

    <div class="input-group">
        <input type="email" bind:value={email} placeholder="Enter email">
        <button on:click={addEmail} class="btn">Add Email</button>
    </div>

    <h3>Email List</h3>
    <ul>
        {#each emails as email}
            <li>{email}</li>
        {/each}
    </ul>

    <button on:click={sendEmails} class="btn send-btn">Send Email to All</button>
</main>
