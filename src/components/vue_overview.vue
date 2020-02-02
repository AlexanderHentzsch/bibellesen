<template>
    <div class="w3-container">
        <h1>Leseplan</h1>

        <div class="w3-container">
            <button class="w3-button w3-green" @click="saveReadingOnServer(finished)">Auf Server speichern</button>
            <button class="w3-button w3-green" @click="loadReadingFromServer()">Vom Server laden</button>
        </div>

        <div v-if="saveSuccess" class="w3-card-4 w3-content" style="max-width: 300px">
            <div class="w3-padding">
                <p>Erfolgreich gespeichert.</p>
                <div class="w3-right-align" style="padding-top: 8px">
                    <button class="w3-button w3-green" @click="saveSuccess = false">Schließen</button>
                </div>
            </div>
        </div>

        <div class="w3-container w3-border-bottom w3-border-top" style="margin-top: 24px; padding: 0">
            <div v-for="el in getReadingList(ldz, personally)" :key="el[0]"
                 @click="toggleFinished(el[0])"
                 :class="bgForFinished(el[0])"
                 class="w3-col item">
                <div class="w3-col w3-left" style="width:100px">
                    <p>{{listElementGetDate(el[0])}}</p>
                </div>
                <div class="w3-col w3-center w3-right" style="width:45px">
                    <p>
                        <input type="checkbox" :checked="isFinished(el[0])">
                    </p>
                </div>
                <div class="w3-rest">
                    <p>
                        <a :href="listElementGetLink(el[1])" @click.stop target="_blank">{{el[1]}}</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import $ from "jquery";

    export default {
        name: "vue_overview",
        data() {
            return {
                ldz: [],
                personally: [],
                finished: [],
                saveSuccess: false,
                lsKeyName: "reading",
                baseUrl: "http://localhost:8081/"
            }
        },
        mounted() {
            const lsLdz = localStorage.getItem("ldz");
            const lsPersonally = localStorage.getItem("personally");
            const lsReading = localStorage.getItem(this.lsKeyName);
            const baseUrl = localStorage.getItem("baseUrl");

            if (lsLdz !== null)
                this.ldz = JSON.parse(lsLdz);

            if (lsPersonally !== null)
                this.personally = JSON.parse(lsPersonally);

            if (lsReading !== null)
                this.finished = JSON.parse(lsReading);

            if (baseUrl !== null)
                this.baseUrl = baseUrl;
        },
        methods: {
            getReadingList(ldz, personally) {
                let r = ldz.concat(personally);
                return r.sort((a, b) => {
                    let test = [a, b].sort();
                    return (test[0] === a) ? -1 : 1;
                });
            },
            listElementGetDate(el) {
                const d = new Date(el);
                const dayName = ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"][d.getDay()];
                const day = d.getDate().toString().padStart(2, "0");
                const m = (d.getMonth() + 1).toString().padStart(2, "0");
                return `${dayName}. ${day}.${m}`;
            },
            listElementGetLink(el) {
                el = el.replace(/ /, "+");
                return `https://wol.jw.org/de/wol/l/r10/lp-x?q=${el}`;
            },
            toggleFinished(el) {
                const f = this.finished;
                if (f.indexOf(el) === -1) {
                    f.push(el);
                } else {
                    f.splice(f.indexOf(el), 1);
                }
                localStorage.setItem(this.lsKeyName, JSON.stringify(f));
            },
            isFinished(el) {
                return this.finished.indexOf(el) !== -1;
            },
            bgForFinished(el) {
                if (this.isFinished(el))
                    return `finished`;
            },
            saveReadingOnServer(reading) {
                const url = `${this.baseUrl}?/save/reading/`;
                const content = {reading: JSON.stringify(reading)};
                $.post(url, content, (sDATA) => {
                    this.saveSuccess = sDATA;
                });
            },
            loadReadingFromServer() {
                const url = `${this.baseUrl}?/load/reading/`;
                $.get(url, (sDATA) => {
                    localStorage.setItem(this.lsKeyName, JSON.stringify(sDATA));
                    this.finished = sDATA;
                });
            }
        }
    }
</script>

<style scoped>
    p {
        margin: 3px 0;
    }

    .item:nth-child(2n) {
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        background-color: #FDD7AC;
    }

    .item {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        padding: 0 4px;
    }

    a {
        text-decoration: none;
    }

    .finished {
        background-color: #eee !important;
        color: #ccc;
    }
</style>