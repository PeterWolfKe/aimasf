<script>
    import { onMount } from "svelte";

    let countdown = "";

    function updateCountdown() {
        const now = new Date();
        const targetDate = new Date(now.getFullYear(), 1, 14);

        if (now > targetDate) {
            targetDate.setFullYear(now.getFullYear() + 1);
        }

        const diff = targetDate - now;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        countdown = `00d 00h 00m 00s`;
    }

    onMount(() => {
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);

        return () => clearInterval(interval);
    });
</script>

<style>
    .countdown {
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 80px 20px;
        border: 2px solid pink;
        background-color: #ffe6e6;
    }
    p {
        font-size: 5rem;
    }
</style>

<div class="countdown">
    <h1>Počet dní do Valentína 💖</h1>
    <p>{countdown}</p>
</div>
