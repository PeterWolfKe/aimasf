<script>
    let isMenuOpen = false;

    function toggleMenu() {
        isMenuOpen = !isMenuOpen;
    }
</script>

<style>
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #333;
        color: white;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .links {
        display: flex;
        gap: 1.5rem;
    }

    .links a {
        text-decoration: none;
        color: white;
        font-weight: 500;
    }

    .links a:hover {
        color: #f39c12;
    }

    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }

        .links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 1rem;
        }

        .links.open {
            display: flex;
        }

        .links a {
            margin: 0.5rem 0;
        }
    }
</style>

<nav>
    <div class="logo">MySite</div>
    <div class="menu-toggle" on:click={toggleMenu}>
        ☰
    </div>
    <div class="links {isMenuOpen ? 'open' : ''}">
        <a href="#recensions" on:click={() => (isMenuOpen = false)}>Recensions</a>
        <a href="#contact" on:click={() => (isMenuOpen = false)}>Contact</a>
        <a href="#eshop" on:click={() => (isMenuOpen = false)}>Eshop</a>
    </div>
</nav>
