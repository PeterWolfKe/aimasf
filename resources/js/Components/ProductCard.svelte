<script>
    import product_image from '/resources/assets/product.jpg';
    export let id = "00000001";
    export let selectedSize = "10ml";
    let quantity = 1;

    function increaseQuantity() {
        quantity++;
    }

    function decreaseQuantity() {
        if (quantity > 1) quantity--;
    }

    async function buyNow() {
        const payload = {
            "id": id,
            "selected_size": selectedSize,
            "quantity": quantity
        };

        const response = await fetch('/buy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(payload),
        });

        if (response.ok) {
            window.location.href = '/payment';
        } else {
            alert('Error processing your order.');
        }
    }
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .product-card {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        background-color: $primary-mint;
        color: $text-color;
        box-sizing: border-box;

        .left {
            flex: 1 1 40%;
            display: flex;
            flex-direction: column;
            align-items: center;

            .main-image {
                width: 100%;
                max-width: 300px;
                margin-bottom: 1rem;
                border-radius: 8px;
                border: 1px solid red;
            }

            .thumbnails {
                display: flex;
                gap: 1rem;
                justify-content: center;

                img {
                    width: 60px;
                    height: 60px;
                    object-fit: cover;
                    border: 2px solid $gray-white;
                    border-radius: 4px;
                    cursor: pointer;

                    &:hover {
                        border-color: $secondary-deep-blue;
                    }
                }
            }
        }

        .right {
            flex: 1 1 50%;
            display: flex;
            flex-direction: column;

            h1 {
                font-size: 2rem;
                color: $secondary-dark-blue;
                margin-bottom: 1rem;
            }

            .description {
                font-size: 1rem;
                color: $dark-gray;
                margin-bottom: 2rem;
            }

            .price {
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 1rem;

                small {
                    display: block;
                    font-size: 0.875rem;
                    color: $dark-gray;
                }
            }

            .options {
                margin-bottom: 2rem;

                h3 {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;
                }

                .size-buttons {
                    display: flex;
                    gap: 1rem;

                    button {
                        background-color: $button-background;
                        color: $neutral-white;
                        padding: 0.5rem 1rem;
                        font-size: 1rem;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;

                        &.selected {
                            background-color: $button-hover;
                        }
                    }
                }
            }

            .quantity {
                margin-bottom: 2rem;

                h3 {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;
                }

                .quantity-control {
                    display: flex;
                    align-items: center;
                    gap: 1rem;

                    button {
                        background-color: $primary-blue;
                        color: $neutral-white;
                        font-size: 1.5rem;
                        padding: 0.5rem 1rem;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;

                        &:hover {
                            background-color: $button-hover;
                        }
                    }

                    span {
                        font-size: 1.2rem;
                    }
                }
            }

            .actions {
                display: flex;
                gap: 1rem;

                button {
                    flex: 1;
                    padding: 1rem;
                    font-size: 1rem;
                    background-color: $secondary-purple;
                    color: $neutral-white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    text-align: center;

                    &:hover {
                        background-color: $secondary-dark-blue;
                    }
                }
            }
        }
    }

    // Add mobile-specific styles
    @media (max-width: 768px) {
        .product-card {
            padding: 1rem;
            gap: 1rem;

            .left {
                flex: 1 1 100%;

                .main-image {
                    max-width: 200px;
                }

                .thumbnails {
                    gap: 0.5rem;

                    img {
                        width: 50px;
                        height: 50px;
                    }
                }
            }

            .right {
                flex: 1 1 100%;

                h1 {
                    font-size: 1.5rem;
                    margin-bottom: 0.5rem;
                }

                .description {
                    font-size: 0.875rem;
                    margin-bottom: 1rem;
                }

                .price {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;

                    small {
                        font-size: 0.75rem;
                    }
                }

                .options {
                    margin-bottom: 1rem;

                    h3 {
                        font-size: 1rem;
                    }

                    .size-buttons {
                        gap: 0.5rem;

                        button {
                            padding: 0.25rem 0.5rem;
                            font-size: 0.875rem;
                        }
                    }
                }

                .quantity {
                    margin-bottom: 1rem;

                    h3 {
                        font-size: 1rem;
                    }

                    .quantity-control {
                        gap: 0.5rem;

                        button {
                            font-size: 1rem;
                            padding: 0.25rem 0.5rem;
                        }

                        span {
                            font-size: 1rem;
                        }
                    }
                }

                .actions {
                    gap: 0.5rem;

                    button {
                        padding: 0.5rem;
                        font-size: 0.875rem;
                    }
                }
            }
        }
    }
</style>


<div class="product-card">
    <div class="left">
        <img class="main-image" src={product_image} alt="Main Product" />
    </div>
    <div class="right">
        <h1>Rýchly a účinný odstraňovač krvi</h1>
        <div class="description">
            ng instrument. Size like body some one had. Are conduct viewing boy minutes warrant expense.
        </div>
        <div class="price">
            Cena Od 3,50€
            <small>Vrátane dane.</small>
        </div>
        <div class="options">
            <h3>Vyberte si veľkosť</h3>
            <div class="size-buttons">
                <button
                    class:selected={selectedSize === "10ml"}
                    on:click={() => (selectedSize = "10ml")}
                >
                    10ml
                </button>
                <button
                    class:selected={selectedSize === "3ml"}
                    on:click={() => (selectedSize = "3ml")}
                >
                    3ml
                </button>
            </div>
        </div>
        <div class="quantity">
            <h3>Množstvo</h3>
            <div class="quantity-control">
                <button on:click={decreaseQuantity}>-</button>
                <span>{quantity}</span>
                <button on:click={increaseQuantity}>+</button>
            </div>
        </div>
        <div class="actions">
            <button on:click={buyNow}>Kúpiť</button>
        </div>
    </div>
</div>
