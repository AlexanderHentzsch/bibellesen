<template>
    <div class="w3-container">
        <h1>LDZ Leseplan</h1>
        <div class="w3-panel">
            <label>Woche vom:</label>
            <input class="w3-input w3-border" type="date" v-model="week">
        </div>
        <div class="w3-panel">
            <label>Zu lesen:</label>
            <input class="w3-input w3-border" v-model="current" @keyup.enter="addToLdz">
            <div class="w3-right-align" style="padding-top: 8px">
                <button class="w3-button w3-green" @click="addToLdz">Hinzufügen</button>
            </div>
        </div>
        <div>
            <p v-for="d in ldz" :key="d[1]">{{getWrittenDate(d[0])}} {{d[1]}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "vue_ldz",
        data() {
            return {
                current: "",
                week: 0,
                ldz: []
            }
        },
        mounted() {
            this.setStartWeek();
            this.ldz = JSON.parse(localStorage.getItem("ldz"));
        },
        methods: {
            addToLdz() {
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
                this.setForNextEntry();
            },
            setStartWeek() {
                const d = new Date();
                this.week = this.getMonday(d);
            },
            getMonday(d) {
                let m = (d.getMonth() + 1).toString().padStart(2, "0");
                let day = d.getDate();
                let dayName = d.getDay();

                if (dayName === 0)
                    day++;
                if (dayName > 1)
                    day = day - dayName + 1;

                day = day.toString().padStart(2, "0");
                return `${d.getFullYear()}-${m}-${day}`;
            },
            setForNextEntry() {
                const curUnix = new Date(this.week).getTime();
                const sevenDays = 1000 * 60 * 60 * 24 * 7;
                this.week = this.getMonday(new Date(curUnix + sevenDays));

                const cut = this.current.indexOf(" ", 3);
                this.current = this.current.substring(0, cut) + " ";
            },
            getWrittenDate(d) {
                d = d.split("-");
                return `${d[2]}.${d[1]}`;
            }
        }
    }
</script>

<style scoped>

</style>