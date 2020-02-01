<template>
    <div class="w3-container">
        <h1>Persönlicher Leseplan</h1>

        <div class="w3-container">
            <button class="w3-button w3-green" @click="savePersonallyOnServer(personally)">Auf Server speichern</button>
            <button class="w3-button w3-green" @click="loadPersonallyFromServer()">Vom Server laden</button>
        </div>

        <div v-if="saveSuccess" class="w3-card-4 w3-content" style="max-width: 300px">
            <div class="w3-padding">
                <p>Erfolgreich gespeichert.</p>
                <div class="w3-right-align" style="padding-top: 8px">
                    <button class="w3-button w3-green" @click="saveSuccess = false">Schließen</button>
                </div>
            </div>
        </div>

        <div class="w3-panel">
            <label>Tag:</label>
            <input class="w3-input w3-border" type="date" v-model="day">
        </div>

        <div class="w3-panel">
            <label>Zu lesen:</label>
            <input class="w3-input w3-border" v-model="current" @keyup.enter="addToPersonally(day, current)">
            <div class="w3-right-align" style="padding-top: 8px">
                <button class="w3-button w3-green" @click="addToPersonally(day, current)">Hinzufügen</button>
            </div>
        </div>

        <div>
            <p v-for="d in personally" :key="d[1]"
               @click="editClickedElement(d)"
               class="w3-hover-teal" style="cursor: pointer">{{getListItem(d)}}</p>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";

    export default {
        name: "vue_personally",
        data() {
            return {
                current: "",
                day: this.getTodayString(),
                personally: [],
                saveSuccess: false,
                lsKeyName: "personally"
            }
        },
        mounted() {
            if (localStorage.getItem(this.lsKeyName) !== null)
                this.personally = JSON.parse(localStorage.getItem(this.lsKeyName));
        },
        methods: {
            getTodayString() {
                const d = new Date();
                const y = d.getFullYear();
                const m = (d.getMonth() + 1).toString().padStart(2, "0");
                const day = d.getDate().toString().padStart(2, "0");
                return [y, m, day].join("-");
            },
            savePersonallyOnServer(personally) {
                const url = "http://localhost:8081/?/save/personally/";
                const content = {personally: JSON.stringify(personally)};
                $.post(url, content, (sDATA) => {
                    this.saveSuccess = sDATA;
                });
            },
            loadPersonallyFromServer() {
                const url = "http://localhost:8081/?/load/personally/";
                $.get(url, (sDATA) => {
                    localStorage.setItem(this.lsKeyName, JSON.stringify(sDATA));
                    this.personally = sDATA;
                });
            },
            addToPersonally(day, content) {
                // new Index is "add" or "overwrite"
                let index = this.personally.length;
                for (let i = 0; i < this.personally.length; i++) {
                    if (this.personally[i][0] === day) {
                        index = i;
                        break;
                    }
                }

                this.personally[index] = [day, content.trim()];
                this.personally.sort((a, b) => {
                    let test = [a, b].sort();
                    return (test[0] === a) ? -1 : 1;
                });

                localStorage.setItem(this.lsKeyName, JSON.stringify(this.personally));
                this.setForNextEntry(day);
            },
            setForNextEntry(d) {
                const getNextDay = function (d) {
                    d = new Date(d);
                    d = new Date(d.getTime() + (1000 * 60 * 60 * 24));
                    // Wenn Montag +1
                    if (d.getDay() === 1)
                        d = new Date(d.getTime() + (1000 * 60 * 60 * 24));

                    const y = d.getFullYear();
                    const m = (d.getMonth() + 1).toString().padStart(2, "0");
                    const day = d.getDate().toString().padStart(2, "0");
                    return [y, m, day].join("-");
                };

                const getNewContent = (currentLdz) => {
                    const cut = currentLdz.indexOf(" ", 3);
                    return (currentLdz.substring(0, cut) + " ");
                };

                this.day = getNextDay(d);
                this.current = getNewContent(this.current);
            },
            getListItem(d) {
                const getWrittenDate = function (d) {
                    d = d.split("-");
                    return `${d[2]}.${d[1]}`;
                };

                return getWrittenDate(d[0]) + " " + d[1];
            },
            editClickedElement(el) {
                this.day = el[0];
                this.current = el[1];
            }
        }
    }
</script>

<style scoped>

</style>