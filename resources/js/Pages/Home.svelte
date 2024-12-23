<script lang="ts">
    import Navbar from '../Components/Navbar.svelte';
    export let name: String = 'World';
</script>

<Navbar></Navbar>
<p>Hello, {name}!</p>

<style lang="scss">
    @use "../../scss/colors" as *;
    p {
        color: $text-color;
    }
</style>
