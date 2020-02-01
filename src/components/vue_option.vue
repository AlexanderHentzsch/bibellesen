<template>
    <div class="container-content">
        <div class="w3-content w3-container">
            <h1>Optionen</h1>

            <div>
                <h2 style="margin-top: 64px">Lizenz</h2>
                <p>
                    <a href="https://github.com/AlexanderHentzsch/Bibelleseplan/blob/master/LICENSE" target="_blank">
                        JW Notes - The MIT License (MIT)
                    </a>
                </p>

                <h3 style="margin-top: 48px">Third-party libraries</h3>
                <p>
                    <a href="https://github.com/vuejs/vue/blob/dev/LICENSE" target="_blank">
                        Vue.js - The MIT License (MIT)
                    </a>
                </p>
            </div>
        </div>

        <div id="container-github">
            <a :href="hrefGitHub" id="a-github" target="_blank">
                Projekt auf <span id="span-github">GitHub</span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "vue_option",
        data() {
            return {
                fontSize: 4,
                localStorageKey: "options",
                hrefGitHub: "https://github.com/AlexanderHentzsch/bibellesen"
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>

<style scoped>
    #container-github{
        padding: 16px;
        text-align: center;
    }

    #a-github{
        text-decoration: none;
    }

    #span-github{
        background-color: #000;
        color: #fff;
        border-radius: 60px;
        display: inline-block;
        padding: 0 8px;
        margin-left: 2px;
    }
</style>