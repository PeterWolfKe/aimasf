<script lang="ts">
    import Navbar from "../Components/Navbar.svelte";
    import Footer from "../Components/Footer.svelte";
    import logo from '/resources/assets/logo.png';
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    * {
        box-sizing: border-box;
    }

    .app-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 6rem 0;
        font-family: Arial, sans-serif;
        background-color: $neutral-white;
    }

    .logo {
        margin-bottom: 1.5rem;
    }

    .success-message {
        font-size: 3.5rem;
        font-weight: bold;
        color: $primary-blue;
        margin-bottom: 2rem;
    }

    .sub-message {
        font-size: 1rem;
        color: $primary-blue;
        margin-bottom: 2rem;
    }

    .details {
        display: flex;
        gap: 20px;
        font-size: 1rem;
        color: $primary-blue;
        margin-bottom: 2rem;
    }

    .details span {
        font-weight: bold;
    }

    .button {
        background-color: $primary-blue;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 1.5rem;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, transform 0.5s ease;
    }

    .button:hover {
        transform: scale(1.05);
        background-color: darken($primary-blue, 10%);
    }

    @media (max-width: 768px) {
        .success-message {
            font-size: 2.5rem;
        }

        .sub-message {
            font-size: 0.9rem;
        }

        .details div {
            font-size: 0.9rem;
            text-align: center;
        }

        .button {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    }
</style>

<Navbar></Navbar>

<main class="app-container" id="main-container">
    <div class="logo">
        <img src={logo} alt="Logo" width="128" height="128" />
    </div>
    <div class="success-message">Váš e-mail bol úspešne potvrdený</div>
    <a class="button" href="/">Návrat na domovskú obrazovku</a>
</main>

<Footer></Footer>
