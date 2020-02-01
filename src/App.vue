<template>
    <div id="App">
        <router-view/>
        <div id="container-btn" class="w3-bottom">
            <router-link to="/" class="w3-button">Übersicht</router-link>
            <router-link to="/ldz" class="w3-button">LDZ</router-link>
            <router-link to="/personally" class="w3-button">Persönlich</router-link>
            <router-link to="/option" class="w3-button">Optionen</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'App',
    }
</script>

<style>
    @import "assets/w3.css";

    #App {
        margin-bottom: 40px;
    }

    #container-btn{
        border-top: 1px #333 solid;
        background-color: #fff
    }
</style>
