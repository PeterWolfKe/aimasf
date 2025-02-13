<script lang="ts">
    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();

    let discountCode = '';

    let discountMessage = '';
    let discountError = false;

    const applyDiscount = async () => {
        discountMessage = '';
        discountError = false;

        if (!discountCode.trim()) {
            discountMessage = 'Prosím, zadajte zľavový kód.';
            discountError = true;
            return;
        }

        try {
            const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content;

            const response = await fetch('/payment/apply-discount', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ code: discountCode }),
            });

            const data = await response.json();

            if (data.success) {
                const appliedDiscount = data.discount.percentage;
                dispatch('apply-discount', appliedDiscount);
                discountMessage = `Zľava ${appliedDiscount}% bola úspešne uplatnená.`;
            } else {
                discountMessage = data.message || 'Neplatný zľavový kód.';
                discountError = true;
            }
        } catch (error) {
            discountMessage = 'Nastala chyba pri uplatňovaní kódu.';
            discountError = true;
        }
    };
</script>

<style lang="scss">
    .discount-code-section {
        margin-top: 1.5rem;
        padding: 1rem;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;

        label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }

        .discount-code-input {
            display: flex;
            gap: 0.5rem;

            input {
                flex: 1;
                padding: 0.5rem;
                font-size: 1rem;
                border: 1px solid #ddd;
                border-radius: 4px;
                outline: none;
                margin: 0;
                transition: border-color 0.3s ease;

                &:focus {
                    border-color: #0077ff;
                }
            }

            .apply-discount-button {
                padding: 0.5rem 1rem;
                background-color: #0077ff;
                color: #fff;
                border: none;
                border-radius: 4px;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s;

                &:hover {
                    background-color: #005bb5;
                }
            }
        }

        .discount-message {
            margin: 0;
            margin-top: 8px;
            font-size: 0.9rem;

            &.success {
                color: #2e7d32;
            }

            &.error {
                color: #d32f2f;
            }
        }
    }
</style>

<div class="discount-code-section">
    <label for="discountCode">Zadajte zľavový kód</label>
    <div class="discount-code-input">
        <input
            type="text"
            id="discountCode"
            bind:value={discountCode}
            placeholder="Váš zľavový kód"
        />
        <button type="button" class="apply-discount-button" on:click={applyDiscount}>
            Uplatniť
        </button>
    </div>
    {#if discountMessage}
        <p class="discount-message {discountError ? 'error' : 'success'}">{discountMessage}</p>
    {/if}
</div>
