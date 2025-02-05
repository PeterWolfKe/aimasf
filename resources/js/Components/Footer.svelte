<script lang="ts">
    let email = '';
    let message = '';
    let messageType = '';

    async function submitForm() {
        if (!email) {
            showMessage('Please enter a valid email', 'error');
            return;
        }
        const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content;
        try {
            const response = await fetch('/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ email }),
            });

            const result = await response.json();

            if (response.ok) {
                showMessage(result.message, 'success');
                email = '';
            } else {
                showMessage(result.errors.email[0], 'error');
            }
        } catch (error) {
            showMessage('Nastala chyba, skúste znova neskôr', 'error');
        }
    }

    function showMessage(msg: string, type: 'success' | 'error') {
        message = msg;
        messageType = type;
    }
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    footer {
        background-color: $secondary-deep-blue;
        color: $gray-white;
        padding: 2rem 1rem;
        text-align: center;
        font-family: 'Roboto', sans-serif;
        box-sizing: border-box;
    }

    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        max-width: 1200px;
        margin: 0 auto;

        @media (max-width: 768px) {
            flex-direction: column;
            align-items: center;
        }
    }

    .column {
        flex: 1;
        min-width: 200px;
        margin: 1rem;

        @media (max-width: 768px) {
            text-align: center;
            margin: 0.5rem 0;
        }

        p {
            margin-bottom: 0.5rem;
        }
    }

    h3 {
        margin-bottom: 1rem;
        font-size: 1.25rem;
        color: $neutral-white;
    }

    .links a {
        display: block;
        margin-bottom: 0.5rem;
        color: $gray-white;
        text-decoration: none;

        &:hover {
            text-decoration: underline;
        }
    }

    .newsletter-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1rem;
    }

    .message {
        margin-top: 1rem;
        font-size: 1rem;
        padding: 0.5rem;
        border-radius: 5px;
        max-width: 70%;
    }

    .message.success {
        background-color: $primary-mint;
        color: $primary-blue;
    }

    .message.error {
        background-color: $dark-red;
        color: $neutral-white;
    }

    .newsletter {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;

        h3 {
            color: #fff;
            margin-bottom: 1rem;
        }

        form {
            position: relative;
            display: flex;
            width: fit-content;
            justify-content: center;
            align-items: center;
        }

        input {
            width: 300px;
            padding: 0.8rem 3rem 0.8rem 1rem;
            border: 1px solid $neutral-white;
            border-radius: 50px;
            background-color: transparent;
            color: $neutral-white;
            transition: box-shadow 0.3s ease;

            &::placeholder {
                color: $neutral-white;
            }

            &:focus,
            &:hover {
                outline: none;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
            }

            &:-webkit-autofill,
            &:-webkit-autofill:hover,
            &:-webkit-autofill:focus,
            &:-webkit-autofill:active{
                -webkit-background-clip: text;
                -webkit-text-fill-color: $neutral-white;
                transition: background-color 5000s ease-in-out 0s;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
                caret-color: $neutral-white;
            }
            @media (max-width: 768px) {
                width: 250px;
            }

        }

        button {
            position: absolute;
            right: 0.3rem;
            top: 50%;
            transform: translateY(-50%);
            padding: 0.6rem 0.6rem;
            background: none;
            border: none;
            color: $neutral-white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: text-shadow 0.2s ease;

            &:hover {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
            }
        }
    }

    .footer-bottom {
        margin-top: 2rem;
        border-top: 1px solid $text-color;
        padding-top: 1rem;
        font-size: 0.9rem;
        color: $gray-white;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;

        @media (max-width: 768px) {
            justify-content: center;
        }
    }

    .social-icons a {
        text-decoration: none;
        font-size: 2rem;
        display: inline-flex;
        align-items: center;
        transition: transform 0.3s ease;

        &:hover {
            transform: scale(1.05);
        }

        svg {
            fill: $neutral-white;
            transition: transform 0.3s ease;

            &:hover {
                transform: scale(1.05);
            }
        }
    }
</style>

<footer id="footer">
    <div class="footer-container">
        <div class="column">
            <h3>Aima</h3>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=61571210141817" aria-label="Facebook">
                    <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                        <path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/>
                    </svg>
                </a>

                <a href="https://www.instagram.com/aima_sf/" aria-label="Instagram">
                    <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                    </svg>
                </a>

                <a href="https://x.com/aima_sf" aria-label="X">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                    </svg>
                </a>

                <a href="https://www.tiktok.com/@aima_sf" aria-label="Tiktok">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                    </svg>
                </a>

                <a href="https://www.youtube.com/@aima_sf" aria-label="Youtube">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="column">
            <h3>Dodatočné info</h3>
            <div class="links">
                <a href="/terms-and-conditions">Obchodné podmienky</a>
                <a href="/protection-of-personal-information">Ochrana osobných údajov</a>
            </div>
        </div>

        <div class="column">
            <h3>Kontakt</h3>
            <p>Zákaznícka podpora: +421 903 799 755</p>
            <p>Technická podpora: +421 915 184 224</p>
            <p>Email: aima@aimasf.sk</p>
        </div>
    </div>

    <div class="newsletter-container">
        <div class="newsletter">
            <h3>Prihlás sa na odber noviniek</h3>
            <form on:submit|preventDefault={submitForm}>
                <input
                    type="email"
                    bind:value={email}
                    placeholder="Email"
                    autocomplete="email"
                    required
                />
                <button type="submit">→</button>
            </form>
            {#if message}
                <div class="message {messageType}">
                    {message}
                </div>
            {/if}
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025, Aima | Pre Aimu vyrobil <span style="font-size: 15px">Julo Klein</span></p>
    </div>
</footer>
