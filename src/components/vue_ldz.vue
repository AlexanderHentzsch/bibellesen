<template>
    <div class="w3-container">
        <h1>LDZ Leseplan</h1>
        <div class="w3-container">
            <button class="w3-button w3-green" @click="saveLdzOnServer(ldz)">Auf Server speichern</button>
            <button class="w3-button w3-green" @click="loadLdzFromServer()">Vom Server laden</button>
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
            <label>Woche vom:</label>
            <input class="w3-input w3-border" type="date" v-model="week" @change="dateInputeChanged()">
        </div>

        <div class="w3-panel">
            <label>Zu lesen:</label>
            <input class="w3-input w3-border" v-model="current" @keyup.enter="addToLdz(week, current)">
            <div class="w3-right-align" style="padding-top: 8px">
                <button class="w3-button w3-green" @click="addToLdz(week, current)">Hinzufügen</button>
            </div>
        </div>

        <div>
            <p v-for="d in ldz" :key="d[1]"
               @click="editClickedElement(d)"
               class="w3-hover-teal" style="cursor: pointer">{{getListItem(d)}}</p>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";

    export default {
        name: "vue_ldz",
        data() {
            return {
                current: "",
                week: this.getMonday(new Date()),
                ldz: [],
                saveSuccess: false,
                lsKeyName: "ldz",
                baseUrl: "http://localhost:8081/"
            }
        },
        mounted() {
            if (localStorage.getItem(this.lsKeyName) !== null)
                this.ldz = JSON.parse(localStorage.getItem(this.lsKeyName));

            const baseUrl = localStorage.getItem("baseUrl");
            if (baseUrl !== null)
                this.baseUrl = baseUrl;
        },
        methods: {
            saveLdzOnServer(ldz) {
                const url = `${this.baseUrl}?/save/ldz/`;
                const content = {ldz: JSON.stringify(ldz)};
                $.post(url, content, (sDATA) => {
                    this.saveSuccess = sDATA;
                });
            },
            loadLdzFromServer() {
                const url = `${this.baseUrl}?/load/ldz/`;
                $.get(url, (sDATA) => {
                    localStorage.setItem(this.lsKeyName, JSON.stringify(sDATA));
                    this.ldz = sDATA;
                });
            },
            addToLdz(week, content) {
                // new Index is "add" or "overwrite"
                let index = this.ldz.length;
                for (let i = 0; i < this.ldz.length; i++) {
                    if (this.ldz[i][0] === week) {
                        index = i;
                        break;
                    }
                }

                this.ldz[index] = [week, content];
                this.ldz.sort((a, b) => {
                    let test = [a, b].sort();
                    return (test[0] === a) ? -1 : 1;
                });

                localStorage.setItem(this.lsKeyName, JSON.stringify(this.ldz));
                this.setForNextEntry(week);
            },
            getMonday(d) {
                const _getMonday = function (d) {
                    d = new Date(d);
                    let day = d.getDay(),
                        diff = d.getDate() - day + (day === 0 ? -6 : 1);
                    return new Date(d.setDate(diff));
                };

                const dateToString = function (d) {
                    d = new Date(d);
                    let m = (d.getMonth() + 1).toString().padStart(2, "0");
                    let day = d.getDate().toString().padStart(2, "0");
                    return `${d.getFullYear()}-${m}-${day}`;
                };

                return dateToString(_getMonday(new Date(d)));
            },
            setForNextEntry(d) {
                const setDay = (currentDay) => {
                    const curUnix = new Date(currentDay).getTime();
                    const sevenDays = 1000 * 60 * 60 * 24 * 7;
                    return this.getMonday(new Date(curUnix + sevenDays));
                };

                const setContent = (currentLdz) => {
                    const cut = currentLdz.indexOf(" ", 3);
                    return currentLdz.substring(0, cut) + " ";
                };

                this.week = setDay(d);
                this.current = setContent(this.current);
            },
            getListItem(d) {
                const getWrittenDate = function (d) {
                    d = d.split("-");
                    return `${d[2]}.${d[1]}`;
                };

                return getWrittenDate(d[0]) + " " + d[1];
            },
            editClickedElement(el) {
                this.week = el[0];
                this.current = el[1];
            },
            dateInputeChanged() {
                const correctToMonday = () => {
                    const d = new Date(this.week);
                    if (d.getDay() !== 1) {
                        this.week = this.getMonday(d);
                    }
                };

                const setContentToExistEntry = (week) => {
                    this.current = this.ldz.filter(el => {
                        return el[0] === week;
                    })[0][1];
                };

                correctToMonday();
                setContentToExistEntry(this.week);
            }
        }
    }
</script>

<style scoped>

</style>