<script>
    import logo from '/resources/assets/logo.webp';

    let isMenuOpen = false;
    export let isSticky = true;
    let navbarHeight = 85;
    let navbarPadding = "0.5rem 8rem";

    function toggleMenu() {
        isMenuOpen = !isMenuOpen;
    }

    window.addEventListener('scroll', () => {
        navbarHeight = window.scrollY > 80 ? 70 : 85;
        navbarPadding = window.scrollY > 80 ? '0.4rem 7.5rem' : '0.5rem 8rem';
    });

    $: {
        if (!isSticky) {
            document.documentElement.style.removeProperty('--navbar-height');
            document.querySelector('.app-container')?.style.removeProperty('margin-top');
        }
    }
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    :root {
        --navbar-height: 85px;
    }

    :global(.sticky-main){
        margin-top: var(--navbar-height);
        transition: margin-top 0.5s ease;
    }

    .navbar-container {
        width: 100%;
        height: var(--navbar-height);
        background-color: #333;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-sizing: border-box;
        z-index: 1000;
        transition: height 0.5s ease, padding 0.5s ease;

        &.sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        &:not(.sticky) {
            transition: none;
        }
    }

    nav {
        position: relative;
        top: 0;
        left: 0;
        width: 100%;
        height: var(--navbar-height);
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--navbar-padding);
        box-sizing: border-box;
        background-color: $primary-blue;
        color: $neutral-white;
        transition: height 0.5s ease, padding 0.5s ease;
        &:not(.sticky) {
            transition: none;
        }
    }

    .brand {
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .brand img {
        height: 60px;
        transition: height 0.3s ease;
    }

    .logo {
        font-size: 2rem;
        font-weight: bold;
        color: $neutral-white;
        margin-left: 10px;
        transition: font-size 0.3s ease;
    }

    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: $neutral-white;
    }

    .links {
        display: flex;
        gap: 3rem;
        margin-right: 3vw;
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        box-sizing: border-box;
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
        color: $neutral-white;
        font-family: 'Roboto', sans-serif;
        font-size: large;
        font-weight: 500;
        padding: 10px 15px;
        box-sizing: border-box;
        border-radius: 8px;
        overflow: hidden;
        transition: background 0.3s ease, transform 0.3s ease, border-radius 0.3s ease;
    }

    .links a:hover {
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

    @media (max-width: 768px) {
        nav {
            padding: 0.5rem 5vw;
            box-sizing: border-box;
        }

        .menu-toggle {
            display: block;
            box-sizing: border-box;
        }

        .links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            box-sizing: border-box;
            background-color: $primary-blue;
            padding: 0.5rem 2rem;
            gap: 0;
            transform: translateY(-10px);
            opacity: 0;
        }

        .links.open {
            display: flex;
            transform: translateY(0);
            box-sizing: border-box;
            opacity: 1;
        }

        .links a {
            padding: 0.5rem 1rem;
            text-align: left;
            width: 100%;
            border-radius: 0;
            box-sizing: border-box;

            &:not(:first-child) {
                border-top: 1px solid $neutral-white;
            }
        }

        .links a:last-child {
            border-bottom: none;
        }
    }
</style>

<div class="navbar-container" class:sticky={isSticky} style="--navbar-height: {navbarHeight}px">
    <nav class:sticky={isSticky} style="--navbar-height: {navbarHeight}px; --navbar-padding: {navbarPadding};">
        <a href="/" style="text-decoration: none">
            <div class="brand">
                <img src={logo} alt="Logo"/>
                <div class="logo">Aima</div>
            </div>
        </a>
        <div
            class="menu-toggle"
            on:click={toggleMenu}
            role="button"
            tabindex="0"
            aria-label="Toggle menu"
        >
            ☰
        </div>
        <div class={`links ${isMenuOpen ? 'open' : ''}`}>
            <a href="/#product" on:click={() => (isMenuOpen = false)}>Produkt</a>
            <a href="/#about-us" on:click={() => (isMenuOpen = false)}>O nás</a>
            <a href="/#footer" on:click={() => (isMenuOpen = false)}>Kontakt</a>
        </div>
    </nav>
</div>
