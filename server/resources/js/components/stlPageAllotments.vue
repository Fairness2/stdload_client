<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-allotments">
                <v-toolbar class="header white--text">
                    <div class="subheading">Распределения</div>
                </v-toolbar>

                <v-list two-line class="stl-allotments__list">
                    <template v-for="(item, index) in $store.state.allotments">
                        <v-list-tile
                                :key="item.id"
                                @click="currentAllotmentModel = item"
                                ripple
                                v-bind:class="[{'stl-allotments__current': $store.state.currentAllotment == item}, isDistributed(item.dis_hours, item.all_hours)]"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}<v-icon title="Основное распределение" v-show="item.is_main">done_outline</v-icon></v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Учебный год: {{ item.year_begin }}-{{ item.year_end }}</v-list-tile-sub-title>
                                <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры распределения</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.сurrentAllotment).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-btn class="success" @click="openAllotment">Открыть</v-btn>
                                    <v-btn class="error" @click="deleteAllotment">Удалить</v-btn>
                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="allotmentNameModel"
                                                :rules="nameRules"
                                                :counter="50"
                                                label="Название"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                type="number"
                                                v-model="allotmentYearBeginModel"
                                                :rules="yearRules"
                                                :counter="4"
                                                label="Год начала"
                                        ></v-text-field>
                                        <v-text-field
                                                type="number"
                                                v-model="calcYearModal"
                                                :rules="yearRules"
                                                :counter="4"
                                                label="Год окончания"
                                                readonly
                                        ></v-text-field>
                                        <v-checkbox
                                                v-model="allotmentIsMainModel"
                                                label="Является основным"
                                        ></v-checkbox>
                                        <v-btn
                                                :loading="upd_allotment_loading"
                                                :disabled="upd_allotment_loading"
                                                class="primary"
                                                v-on:click="updateAllotment"
                                        >
                                            Изменить
                                        </v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>

                                <v-flex xs12 class="body-1">
                                    Распределно часов: {{$store.state.сurrentAllotment ? $store.state.сurrentAllotment.dis_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1">
                                    Всего часов часов: {{$store.state.сurrentAllotment ? $store.state.сurrentAllotment.all_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1" v-bind:class="$store.state.сurrentAllotment ? isDistributed($store.state.сurrentAllotment.dis_hours, $store.state.сurrentAllotment.all_hours) : ''">
                                    Осталось распределить: {{$store.state.сurrentAllotment ? $store.state.сurrentAllotment.all_hours - $store.state.сurrentAllotment.dis_hours : 0}}
                                </v-flex>
                                <v-flex v-show="$store.state.сurrentAllotment ? $store.state.сurrentAllotment.is_main : false" xs12 class="body-1">
                                    Основное распределение
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите распределение...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_allotment">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новое распределение</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        :counter="50"
                                        label="Название"
                                        required
                                ></v-text-field>

                                <v-text-field
                                    type="number"
                                    v-model="yearBegin"
                                    :rules="yearRules"
                                    :counter="4"
                                    label="Год начала"
                                    required
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        v-model="yearCalc"
                                        :rules="yearRules"
                                        :counter="4"
                                        label="Год окончания"
                                        required
                                        readonly
                                ></v-text-field>
                                <v-btn
                                        :loading="new_allotment_loading"
                                        :disabled="new_allotment_loading"
                                        class="success"
                                        v-on:click="createAllotment"
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
        name: "stlPageAllotments",
        components: {},
        data() {
            return {

                nameRules: [
                    v => !!v || 'Введите название',
                    v => v.length <= 50 || 'Название не может быть больше 50 знаков'
                ],

                yearRules: [
                    v => !!v || 'Введите учебный год',
                    v => /^(19|20)[0-9]{2}$/.test(v) || 'Год должен быть записан в виде гггг-гггг'
                ],

                new_allotment_loading: false,

                upd_allotment_loading: false,

                name: '',
                yearBegin: 2018,
                yearEnd: null,
            }
        },
        computed:{
            currentAllotmentModel: {
                get() {
                    return this.$store.state.сurrentAllotment;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'сurrentAllotment', value});
                }
            },
            allotmentNameModel: {
                get() {
                    return this.$store.state.сurrentAllotment.name;
                },

                set(value) {
                    value = {...this.$store.state.сurrentAllotment, ...{name: value}};
                    this.$store.commit('setData', {path: 'сurrentAllotment', value});
                }
            },
            allotmentYearBeginModel: {
                get() {
                    return this.$store.state.сurrentAllotment.year_begin;
                },

                set(value) {
                    value = {...this.$store.state.сurrentAllotment, ...{year_begin: value}};
                    this.$store.commit('setData', {path: 'сurrentAllotment', value});
                }
            },
            allotmentYearEndModel: {
                get() {
                    return this.$store.state.сurrentAllotment.year_end;
                },

                set(value) {
                    value = {...this.$store.state.сurrentAllotment, ...{year_end: value}};
                    this.$store.commit('setData', {path: 'сurrentAllotment', value});
                }
            },
            allotmentIsMainModel: {
                get() {
                    return this.$store.state.сurrentAllotment.is_main;
                },

                set(value) {
                    value = {...this.$store.state.сurrentAllotment, ...{is_main: value}};
                    this.$store.commit('setData', {path: 'сurrentAllotment', value});
                }
            },

            yearCalc (){
                this.yearEnd = Number(this.yearBegin) + 1;
                return this.yearEnd;
            },

            calcYearModal(){
                this.allotmentYearEndModel = Number(this.allotmentYearBeginModel) + 1;
                return this.allotmentYearEndModel;
            }

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateAllotments');
            },

            isDistributed(dis_hours, all_hours){
                if (dis_hours < all_hours) {
                    return 'stl-allotments__dis-complite-not';
                }
                else if (dis_hours == all_hours){
                    return 'stl-allotments__dis-complite';
                }
                else if (dis_hours > all_hours){
                    return 'stl-allotments__dis-complite-error';
                }
                return '';
            },

            updateAllotment(){
                this.$store.dispatch('editAllotment');
            },

            createAllotment(){
                let params = {
                    'name': this.name,
                    'year_begin': this.yearBegin,
                    'year_end': this.yearEnd,
                };
                this.$store.dispatch('createAllotment', params);
            },
            deleteAllotment(){
                this.$store.dispatch('removeAllotment');
            },

            openAllotment(){

            },
        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />