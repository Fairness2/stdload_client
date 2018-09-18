<template>
    <v-layout row justify-space-around>

        <v-flex xs12 sm6>
            <v-card class="allotment">
                <v-toolbar class="header white--text">
                    <div class="subheading">Распределения</div>
                </v-toolbar>

                <v-list two-line class="allotment_list">
                    <template v-for="(item, index) in allotments">
                        <v-list-tile
                                :key="item.id"
                                @click="selectAllotment(item.id)"
                                ripple
                                v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Учебный год: {{ item.year }}</v-list-tile-sub-title>
                                <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        <v-divider
                                v-if="index + 1 < allotments.length"
                                :key="index"
                        ></v-divider>
                    </template>
                </v-list>

            </v-card>
        </v-flex>

        <v-flex xs12 sm5>
            <v-layout row wrap>
                <v-flex xs 12>
                    <v-card class="allotment">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры распределения</div>
                        </v-toolbar>

                        <v-card-text v-show="isNotChoice">
                            Выберите распределение...
                        </v-card-text>

                        <v-card-text v-show="!isNotChoice">
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-btn class="success">Открыть</v-btn>
                                    <v-btn class="success">Загрузить из файла</v-btn>
                                    <v-btn class="primary" @click="clickUpdateAllotment()">Изменить</v-btn>
                                    <v-btn class="error">Удалить</v-btn>
                                </v-flex>

                                <v-flex xs12 v-show="isUpdFlag">
                                    <v-form v-model="isUpdAllotment">
                                        <v-text-field
                                                v-model="upadteName"
                                                :rules="nameRules"
                                                :counter="50"
                                                label="Название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="updateYear"
                                                :rules="yearRules"
                                                :counter="9"
                                                label="Учебный год"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                :loading="upd_allotment_loading"
                                                :disabled="upd_allotment_loading"
                                                class="primary"
                                                @click.native="updateAllotment = 'upd_allotment_loading'"
                                        >
                                            Изменить
                                        </v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>

                                <v-flex xs12 class="body-1">
                                    Название: {{allotments[selectedAllotment] ? allotments[selectedAllotment].name : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1">
                                    Учебный год: {{allotments[selectedAllotment] ? allotments[selectedAllotment].year : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1">
                                    Распределно часов: {{allotments[selectedAllotment] ? allotments[selectedAllotment].dis_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1">
                                    Всего часов часов: {{allotments[selectedAllotment] ? allotments[selectedAllotment].all_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1" v-bind:class="allotments[selectedAllotment] ? isDistributed(allotments[selectedAllotment].dis_hours, allotments[selectedAllotment].all_hours) : ''">
                                    Осталось распределить: {{allotments[selectedAllotment] ? allotments[selectedAllotment].all_hours - allotments[selectedAllotment].dis_hours : 0}}
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex>
                    <v-card class="new_allotment">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новое распределение</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form v-model="isNewAllotment">
                                <v-text-field
                                        v-model="name"
                                        :rules="nameRules"
                                        :counter="50"
                                        label="Название"
                                        required
                                ></v-text-field>

                                <v-text-field
                                    v-model="year"
                                    :rules="yearRules"
                                    :counter="9"
                                    label="Учебный год"
                                    required
                                ></v-text-field>
                                <v-btn
                                        :loading="new_allotment_loading"
                                        :disabled="new_allotment_loading"
                                        class="success"
                                        @click.native="createAllotment = 'new_allotment_loading'"
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
        name: "appPageAllotments",
        components: {},
        data() {
            return {
                allotments: {
                    121 :{id: '121', name: 'Распределение 1', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    122 : {id: '122', name: 'Распределение 2', year:'2017-2018', all_hours: 64, dis_hours: 64},
                    123: {id: '123', name: 'Распределение 3', year:'2017-2018', all_hours: 64, dis_hours: 72},
                    124: {id: '124', name: 'Распределение 4', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    125: {id: '125', name: 'Распределение 5', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    126: {id: '126', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    127: {id: '127', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    128: {id: '128', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    129: {id: '129', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    130: {id: '130', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    131: {id: '131', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    132: {id: '132', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    133: {id: '133', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    134: {id: '134', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    135: {id: '135', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    136: {id: '136', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    137: {id: '137', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},
                    138: {id: '138', name: 'Распределение 6', year:'2017-2018', all_hours: 64, dis_hours: 32},

                },

                isNotChoice: true,
                selectedAllotment: '',
                isUpdFlag: false,


                isNewAllotment: false,
                isUpdAllotment: false,
                nameRules: [
                    v => !!v || 'Введите название',
                    v => v.length <= 50 || 'Название не может быть больше 50 знаков'
                ],
                name: '',
                upadteName: '',

                yearRules: [
                    v => !!v || 'Введите учебный год',
                    v => /^(19|20)[0-9]{2}-(19|20)[0-9]{2}$/.test(v) || 'Год должен быть записан в виде гггг-гггг'
                ],
                year: '',
                updateYear: '',

                createAllotment: null,
                new_allotment_loading: false,

                updateAllotment: null,
                upd_allotment_loading: false
            }
        },
        watch:{
            createAllotment (){
                var l = this.createAllotment;
                this[l] = !this[l];

                setTimeout(() => (this[l] = false), 3000);

                this.createAllotment = null;
            },

            updateAllotment (){
                var l = this.updateAllotment;
                this[l] = !this[l];

                setTimeout(() => (this[l] = false), 3000);

                this.updateAllotment = null;
            }
        },
        methods:{
            isDistributed(dis_hours, all_hours){
                if (dis_hours < all_hours) {
                    return 'dis_complite_not';
                }
                else if (dis_hours == all_hours){
                    return 'dis_complite';
                }
                else if (dis_hours > all_hours){
                    return 'dis_complite_error';
                }
                return;
            },

            selectAllotment(id){
                this.isUpdFlag = false;
                this.upadteName = '';
                this.updateYear = '';
                this.selectedAllotment = id;
                this.isNotChoice = false;
            },

            clickUpdateAllotment(){
                this.isUpdFlag = true;
                this.upadteName = this.allotments[this.selectedAllotment].name;
                this.updateYear = this.allotments[this.selectedAllotment].year;
            }
        }
    }
</script>

<style src="../assets/sass/components/appPageAllotments.scss" lang="scss"/>