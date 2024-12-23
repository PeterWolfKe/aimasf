<script lang="ts">
    export let name: String = 'World';
</script>

<h1>Hello, {name}!</h1>

<style lang="scss">
    @use "../../scss/colors" as *;
    h1 {
        background-color: $primary-color;
    }
    p {
        color: $text-color;
    }
</style>
