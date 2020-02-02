<template>
    <div class="container-content">
        <div class="w3-content w3-container">
            <h1>Optionen</h1>

            <ul class="w3-ul">
                <li>
                    <h2>Lizenzen</h2>
                </li>
                <li v-for="l in licenses" :key="l.name">
                    <p style="margin: 0">
                        {{l.name}} - <a :href="l.url" target="_blank">{{l.license}} License</a>
                    </p>
                </li>
            </ul>
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
                hrefGitHub: "https://github.com/AlexanderHentzsch/bibellesen",
                licenses: [
                    {
                        name: "JW Bibelleseplan",
                        url: "https://github.com/AlexanderHentzsch/bibellesen/blob/master/LICENSE",
                        license: "MIT"
                    },
                    {name: "Vue.js", url: "https://github.com/vuejs/vue/blob/dev/LICENSE", license: "MIT"},
                    {name: "vue-router", url: "https://github.com/vuejs/vue-router/blob/dev/LICENSE", license: "MIT"},
                    {name: "jQuery", url: "https://github.com/jquery/jquery/blob/master/LICENSE.txt", license: "MIT"},
                    {name: "w3css", url: "https://www.w3schools.com/w3css/default.asp", license: "No"}
                    //{name: "", url: "", license: ""}
                ]
            }
        },
        mounted() {
        },
        methods: {}
    }
</script>

<style scoped>
    #container-github {
        padding: 16px;
        text-align: center;
    }

    #a-github {
        text-decoration: none;
    }

    #span-github {
        background-color: #000;
        color: #fff;
        border-radius: 60px;
        display: inline-block;
        padding: 0 8px;
        margin-left: 2px;
    }
</style>