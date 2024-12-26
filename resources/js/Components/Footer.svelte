<script>
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

    .newsletter {
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
                <a href="#" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                        <path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/>
                    </svg>
                </a>

                <a href="#" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="column">
            <h3>Dodatočné info</h3>
            <div class="links">
                <a href="#">Kontaktujte nás</a>
                <a href="#">Obchodné podmienky</a>
                <a href="#">Ochrana osobných údajov</a>
            </div>
        </div>

        <div class="column">
            <h3>Kontakt</h3>
            <p>tel.: +421 915 184 224</p>
            <p>Email: info@aimasf.sk</p>
        </div>
    </div>

    <div class="newsletter-container">
        <div class="newsletter">
            <h3>Prihlás sa na odber noviniek</h3>
            <form>
                <input type="email" placeholder="Email" autocomplete="email" required />
                <button type="submit">→</button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2024, Aima</p>
    </div>
</footer>
