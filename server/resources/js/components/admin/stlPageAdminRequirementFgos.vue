<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-requirement-fgos">
                <v-toolbar class="header white--text">
                    <div class="subheading">Требования ФГОС</div>
                </v-toolbar>

                <v-list two-line class="stl-requirement-fgos__list">
                    <template v-for="(item, index) in $store.state.requirementFgos">
                        <v-list-tile
                                :key="item.id"
                                @click="currentRequirementFgosModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.year_begin}}-{{item.year_end}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Специальность: {{ getSpecialtyName(item.specialty_id) }}</v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        <v-divider />
                    </template>
                </v-list>

            </v-card>
        </v-flex>

        <v-flex xs12 sm5>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры ФГОС</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentRequirementFgos).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-combobox
                                                v-model="requirementFgosSpecialtyModel"
                                                :items="$store.state.specialties"
                                                item-value="id"
                                                item-text="full_name"
                                                label="Специальность"
                                                chips
                                        ></v-combobox>
                                        <v-text-field
                                                v-model="requirementFgosOutWorkersModel"
                                                type="number"
                                                label="% работников сторонней профильной организации"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="requirementFgosDegreesModel"
                                                type="number"
                                                label="% остепенённости"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="requirementFgosInnerWorkersModel"
                                                type="number"
                                                label="% штатных ППС"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="requirementFgosTrainedWorkerModel"
                                                type="number"
                                                label="% работников с наличием базового образования"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                type="number"
                                                v-model="requirementFgosYearBeginModel"
                                                :rules="yearRules"
                                                :counter="4"
                                                label="Год начала"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                type="number"
                                                v-model="requirementFgosYearEndModel"
                                                :rules="yearRules"
                                                :counter="4"
                                                label="Год окончания"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateRequirementFgos"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteRequirementFgos">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите ФГОС...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_requirement-fgos">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый ФГОС</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-combobox
                                        v-model="specialty"
                                        :items="$store.state.specialties"
                                        item-value="id"
                                        item-text="full_name"
                                        label="Специальность"
                                        chips
                                ></v-combobox>
                                <v-text-field
                                        v-model="out_workers"
                                        type="number"
                                        label="% работников сторонней профильной организации"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        v-model="degrees"
                                        type="number"
                                        label="% остепенённости"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        v-model="inner_workers"
                                        type="number"
                                        label="% штатных ППС"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        v-model="trained_worker"
                                        type="number"
                                        label="% работников с наличием базового образования"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        v-model="year_begin"
                                        :rules="yearRules"
                                        :counter="4"
                                        label="Год начала"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        v-model="year_end"
                                        :rules="yearRules"
                                        :counter="4"
                                        label="Год окончания"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createRequirementFgos"
                                >
                                    <v-icon left>add</v-icon>
                                    Создать
                                </v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>

    </v-layout>
</template>

<script>

    export default {
        name: "stlPageAdminRequirementFgos",
        components: {},
        data() {
            return {
                specialty: '',
                out_workers: '',
                degrees: '',
                inner_workers: '',
                trained_worker: '',
                year_begin: '',
                year_end: '',
                yearRules: [
                    v => !!v || 'Введите учебный год',
                    v => /^(19|20)[0-9]{2}$/.test(v) || 'Год должен быть записан в виде гггг-гггг'
                ],
            }
        },
        computed:{
            currentRequirementFgosModel: {
                get() {
                    return this.$store.state.currentRequirementFgos;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosOutWorkersModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.out_workers;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{out_workers: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosDegreesModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.degrees;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{degrees: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosInnerWorkersModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.inner_workers;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{inner_workers: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosTrainedWorkerModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.trained_worker;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{trained_worker: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosYearBeginModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.year_begin;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{year_begin: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosYearEndModel: {
                get() {
                    return this.$store.state.currentRequirementFgos.year_end;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{year_end: value}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },
            requirementFgosSpecialtyModel: {
                get() {
                    let specialty = this.$store.state.specialties.find(c => c.id == this.$store.state.currentRequirementFgos.specialty_id) || null;
                    return specialty;
                },

                set(value) {
                    value = {...this.$store.state.currentRequirementFgos, ...{specialty_id: value.id}};
                    this.$store.commit('setData', {path: 'currentRequirementFgos', value});
                }
            },

        },
        methods:{

            getSpecialtyName(id){
                let specialty = this.$store.state.specialties.find(c => c.id == id) || {};
                return Object.keys(specialty).length !== 0 ? specialty.full_name : '';
            },

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateRequirementFgos');
            },

            updateRequirementFgos(){
                this.$store.dispatch('editRequirementFgos');
            },

            createRequirementFgos(){
                let params = {
                    'specialty_id': this.specialty.id,
                    'out_workers': this.out_workers,
                    'degrees': this.degrees,
                    'inner_workers': this.inner_workers,
                    'trained_worker': this.trained_worker,
                    'year_begin': this.year_begin,
                    'year_end': this.year_end,
                };
                this.$store.dispatch('createRequirementFgos', params);
            },
            deleteRequirementFgos(){
                this.$store.dispatch('removeRequirementFgos');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />