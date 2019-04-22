<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-roles stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Предпочтения</div>
                </v-toolbar>

                <v-list two-line class="stl-roles__list">
                    <template v-for="(item, index) in coefs">
                        <v-list-tile
                                :key="item.id"
                                @click="openCoef(item)"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>Дисциплина: {{getDiscipline(item.discipline_id).name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Прподаватель:{{getWorker(item.worker_id).fio}}. Тип занятия:{{getTypeClass(item.type_class).name}}</v-list-tile-sub-title>
                                <v-list-tile-sub-title class="text--primary">Специальность:{{getSpeciality(item.speciality_id).name}}. Степнь:{{getCoefValue(item.coefficient).name}}</v-list-tile-sub-title>
                                <v-list-tile-sub-title class="text--primary">Тип:{{getCoefType(item.type).name}}</v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        <v-divider />
                    </template>
                </v-list>

            </v-card>
        </v-flex>

        <v-flex xs12 sm5 class="">
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры коэффициента</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-layout row wrap>

                                <v-flex xs12>
                                    <v-form>
                                        <v-select
                                                v-model="currentWorker"
                                                :items="workers"
                                                item-value="id"
                                                item-text="fio"
                                                label="Преподаватель"
                                        ></v-select>

                                        <v-select
                                                v-model="currentDiscipline"
                                                :items="disciplines"
                                                item-value="id"
                                                item-text="name"
                                                label="Дисциплина"
                                        ></v-select>
                                        <v-select
                                                v-model="currentTypeClass"
                                                :items="typesClass"
                                                item-value="id"
                                                item-text="name"
                                                label="Вид занятия"
                                        ></v-select>
                                        <v-select
                                                v-model="currentSpeciality"
                                                :items="specialities"
                                                item-value="id"
                                                item-text="name"
                                                label="Направление подготовки"
                                        ></v-select>
                                        <v-select
                                                v-model="currentType"
                                                :items="coefTypes"
                                                item-value="value"
                                                item-text="name"
                                                label="Тип коэффициента"
                                        ></v-select>
                                        <v-select
                                                v-model="currentCoef"
                                                :items="coefValues"
                                                item-value="value"
                                                item-text="name"
                                                label="Значение коэффициента"
                                        ></v-select>

                                        <v-alert
                                                :value="isSetCoef === true"
                                                type="success"
                                                transition="scale-transition"
                                                outline
                                        >
                                            Коэффициент очищены.
                                        </v-alert>
                                        <v-alert
                                                :value="isSetCoef === false"
                                                type="warning"
                                                outline
                                        >
                                            Назначить коэффициент не удалось.
                                        </v-alert>

                                        <v-btn
                                                class="primary"
                                                v-on:click="updateCoef"
                                        >
                                            Доавить или изменить
                                        </v-btn>
                                        <v-btn class="error" @click="clearOld">Сбросить коэффициенты наследственности</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>

    </v-layout>
</template>

<script>

    export default {
        name: "stlPageAdminCoef",
        components: {},
        data() {
            return {
                coefs: [],
                workers: [],
                disciplines: [],
                typesClass:[],
                specialities:[],
                coefTypes: [
                    {value: 2, name: 'Предпочтение преподавателя'},
                    {value: 3, name: 'Предпочтение кафедры'},
                    ],
                coefValues: [
                    {value: 1, name: 'Сильное предпочтение'},
                    {value: 0.7, name: 'Предпочтение выше среднего'},
                    {value: 0.5, name: 'Среднее предпочтение'},
                    {value: 0.3, name: 'Предпочтение ниже среднего'},
                    {value: 0, name: 'Слабое предпочтение'},
                ],
                currentWorker: null,
                currentDiscipline: null,
                currentTypeClass: null,
                currentSpeciality: null,
                currentType: null,
                currentCoef: null,
                isSetCoef: null,
            }
        },
        computed:{

        },
        methods:{

            init(){
                this.updateData();
                this.updateTable();
            },

            async updateTable(){
                this.$store.commit('setLoader', true);
                this.coefs = await this.$store.dispatch('getCoef');
                this.$store.commit('setLoader', false);
            },

            async updateData(){
                this.$store.commit('setLoader', true);
                this.workers = await this.$store.dispatch('getWorkers');
                this.disciplines = await this.$store.dispatch('getDisciplines');
                this.typesClass = await this.$store.dispatch('getTypesClass');
                this.specialities = await this.$store.dispatch('getSpecialities');
                this.$store.commit('setLoader', false);
            },

            async updateCoef(){
                this.$store.commit('setLoader', true);
                let params = {
                    'worker_id': this.currentWorker,
                    'discipline_id': this.currentDiscipline,
                    'type_class_id': this.currentTypeClass,
                    'speciality_id': this.currentSpeciality,
                    'type': this.currentType,
                    'coefficient': this.currentCoef,
                };
                let res = await this.$store.dispatch('updateCoef', params);
                this.$store.commit('setLoader', false);
                if (res) {
                    this.updateTable();
                    this.isSetCoef = null
                }
                else
                    this.isSetCoef = false
            },

            async clearOld(){
                this.$store.commit('setLoader', true);
                let res = await this.$store.dispatch('clearOldCoef');
                this.$store.commit('setLoader', false);
                if (res)
                    this.isSetCoef = true;
                else
                    this.isSetCoef = false;
            },

            getDiscipline(id){
                let items = this.disciplines.filter(item => item.id == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            getWorker(id){
                let items = this.workers.filter(item => item.id == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            getTypeClass(id){
                let items = this.typesClass.filter(item => item.id == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            getSpeciality(id){
                let items = this.specialities.filter(item => item.id == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            getCoefValue(id){
                let items = this.coefValues.filter(item => item.value == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            getCoefType(id){
                let items = this.coefTypes.filter(item => item.value == id);
                if (items.length)
                    return items[0];
                else
                    return {};
            },

            openCoef(coef){
                this.currentWorker = coef.worker_id;
                this.currentDiscipline = coef.discipline_id;
                this.currentTypeClass = coef.type_class_id;
                this.currentSpeciality = coef.speciality_id;
                this.currentType = coef.type;
                this.currentCoef = coef.coefficient;
            },
        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />