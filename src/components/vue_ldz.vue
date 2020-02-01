<template>
    <div class="w3-container">
        <h1>LDZ Leseplan</h1>
        <div class="w3-panel">
            <label>Woche vom:</label>
            <input class="w3-input w3-border" type="date" v-model="week">
        </div>
        <div class="w3-panel">
            <label>Zu lesen:</label>
            <input class="w3-input w3-border" v-model="current" @keyup.enter="addToLdz()">
            <div class="w3-right-align" style="padding-top: 8px">
                <button class="w3-button w3-green" @click="addToLdz">Hinzufügen</button>
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
    export default {
        name: "vue_ldz",
        data() {
            return {
                current: "",
                week: this.getMonday(new Date()),
                ldz: []
            }
        },
        mounted() {
            if (localStorage.getItem("ldz") !== null)
                this.ldz = JSON.parse(localStorage.getItem("ldz"));
        },
        methods: {
            addToLdz() {
                // new Index is "add" or "overwrite"
                let index = this.ldz.length;
                for (let i = 0; i < this.ldz.length; i++) {
                    if (this.ldz[i][0] === this.week) {
                        index = i;
                        break;
                    }
                }

                this.ldz[index] = [this.week, this.current];
                this.ldz.sort((a, b) => {
                    let test = [a, b].sort();
                    return (test[0] === a) ? -1 : 1;
                });

                localStorage.setItem("ldz", JSON.stringify(this.ldz));
                this.setForNextEntry(this.week);
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
            }
        }
    }
</script>

<style scoped>

</style>