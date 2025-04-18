<script lang="ts">
    export let userDetails: {
        email: string;
        firstName: string;
        lastName: string;
        address: string;
        apartment?: string;
        postalCode: string;
        city: string;
        phone: string;
    };
</script>

<style lang="scss">
    @use '../../../scss/colors.scss' as *;

    .form-container h2, .summary-container h2 {
        margin-bottom: 1rem;
        color: $text-color;
    }

    .form-container label {
        display: block;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .form-container .star {
        font-size: 0.9rem;
        color:red;
    }

    .form-container input {
        box-sizing: border-box;
        width: 100%;
        padding: 12px;
        border: 1px solid $gray-white;
        border-radius: 4px;
        margin-bottom: 1rem;
        background-color: $neutral-white;
    }

    .form-contact-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .form-segment {
        display: flex;
        gap: 2rem;
        width: 100%;
        flex-direction: row-reverse;
    }

    .form-segment .form-section {
        flex: 1;
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>

<div class="form-container">
    <h2>Fakturačné údaje</h2>
    <label for="email"><span class="star">*</span>E-mail</label>
    <input
        type="email"
        id="email"
        bind:value={userDetails.email}
        placeholder="Váš e-mail"
        required
    />
    <div style="display: flex; gap: 1rem;">
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="firstName"><span class="star">*</span>Meno</label>
            <input
                type="text"
                id="firstName"
                bind:value={userDetails.firstName}
                placeholder="Karol"
                required
            />
        </div>
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="lastName"><span class="star">*</span>Priezvisko</label>
            <input
                type="text"
                id="lastName"
                bind:value={userDetails.lastName}
                placeholder="Dubovský"
                required
            />
        </div>
    </div>
    <div style="display: flex; gap: 1rem;">
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="address"><span class="star">*</span>Adresa</label>
            <input
                type="text"
                id="address"
                bind:value={userDetails.address}
                placeholder="Karpatská 14"
                required
            />
        </div>
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="apartment">Byt, Apartmán, atď. (Voliteľné)</label>
            <input
                type="text"
                id="apartment"
                bind:value={userDetails.apartment}
                placeholder="Byt alebo Apartmán"
            />
        </div>
    </div>
    <div style="display: flex; gap: 1rem;">
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="postalCode"><span class="star">*</span>PSČ</label>
            <input
                type="text"
                id="postalCode"
                bind:value={userDetails.postalCode}
                placeholder="12345"
                required
            />
        </div>
        <div class="form-contact-wrapper" style="flex: 1;">
            <label for="city"><span class="star">*</span>Mesto</label>
            <input
                type="text"
                id="city"
                bind:value={userDetails.city}
                placeholder="Prešov"
                required
            />
        </div>
    </div>
    <label for="phone"><span class="star">*</span>Telefón</label>
    <input
        type="text"
        id="phone"
        bind:value={userDetails.phone}
        placeholder="Vaše telefónne číslo"
    />
</div>
