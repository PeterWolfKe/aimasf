<script>
    import logo from '/resources/assets/logo.png';
    let isMenuOpen = false;
    let navbarHeight = 85;
    let scrollY = 0;

    function toggleMenu() {
        isMenuOpen = !isMenuOpen;
    }

    window.addEventListener('scroll', () => {
        scrollY = window.scrollY;
        navbarHeight = scrollY > 80 ? 70 : 85;
    });
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: var(--navbar-height);
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 8rem;
        box-sizing: border-box;
        background-color: $primary-blue;
        transition: height 0.5s ease, padding 0.5s ease;
        color: $neutral-white;
        box-shadow: 0 4px 2px -2px gray;
    }

    @media (max-width: 1024px) {
        nav {
            padding: 0.5rem 8vw;
        }
    }

    @media (max-width: 768px) {
        nav {
            padding: 0.5rem 5vw;
        }

        .links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: $primary-blue;
            padding: 1rem;
        }

        .links.open {
            display: flex;
        }

        .links a {
            margin: 0.5rem 0;
        }
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .brand img {
        height: 60px;
        width: auto;
    }

    .logo {
        font-size: 2rem;
        font-weight: bold;
        color: $text-color;
        margin-left: 20px;
    }

    #logo-img {
        max-width: 50px;
        height: auto;
    }

    .links {
        gap: 3rem;
        margin-right: 3vw;
        display: flex;
    }

    @media (max-width: 1024px) {
        .links {
            gap: 2vw;
            margin-right: 2vw;
        }
    }

    @media (max-width: 768px) {
        .links {
            gap: 1.5vw;
            display: none;
        }
    }

    .links a {
        position: relative;
        text-decoration: none;
        color: $text-color;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 8px;
        overflow: hidden;
        transition: background 0.3s ease, transform 0.3s ease, border-radius 0.3s ease;
    }

    .links a:hover {
        background: $secondary-purple;
        transform: scale(1.05);
        border-radius: 12px;
    }

    .links a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #fff;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 8px;
        transition: width 0.3s ease;
    }

    .links a:hover::after {
        width: calc(100% - 16px);
    }

    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: $neutral-white;
    }

    @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }

        .links.open {
            display: flex;
        }
    }
</style>

<nav style="--navbar-height: {navbarHeight}px;">
    <div class="brand">
        <img id="logo-img" src={logo} alt="Aima Logo" />
        <div class="logo">Aima</div>
    </div>
    <div
        class="menu-toggle"
        on:click={toggleMenu}
        role="button"
        tabindex="0"
        aria-label="Toggle menu"
        on:keydown={(event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                toggleMenu();
            }
        }}
    >
        ☰
    </div>
    <div class={`links ${isMenuOpen ? 'open' : ''}`}>
        <a href="#recensions" on:click={() => (isMenuOpen = false)}>Recensions</a>
        <a href="#contact" on:click={() => (isMenuOpen = false)}>Contact</a>
        <a href="#eshop" on:click={() => (isMenuOpen = false)}>E-shop</a>
    </div>
</nav>
