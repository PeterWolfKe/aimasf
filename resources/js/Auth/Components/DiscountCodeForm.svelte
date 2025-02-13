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
