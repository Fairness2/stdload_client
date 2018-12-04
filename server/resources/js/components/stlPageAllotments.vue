<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-allotments">
                <v-toolbar class="header white--text">
                    <div class="subheading">Распределения</div>
                </v-toolbar>

                <v-list two-line class="allotment_list">
                    <template v-for="(item, index) in $store.state.allotments">
                        <v-list-tile
                                :key="item.id"
                                @click="currentAllotmentModel = item"
                                ripple
                                v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                                v-bind:class="{'stl-allotments': $store.state.currentAllotment == item}"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}<v-icon title="Основное распределение" v-show="item.primary">done_outline</v-icon></v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Учебный год: {{ item.year }}</v-list-tile-sub-title>
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
                                    <v-btn class="primary" @click="clickUpdateAllotment">Изменить</v-btn>
                                    <v-btn class="error" @click="clickDeleteAllotment">Удалить</v-btn>
                                </v-flex>

                                <v-flex xs12>
                                    <v-form v-model="isUpdAllotment">
                                        <v-text-field
                                                v-model="allotmentNameModel"
                                                :rules="nameRules"
                                                :counter="50"
                                                label="Название"
                                                required
                                        ></v-text-field>
                                        <v-menu
                                                    ref="menu1"
                                                    :close-on-content-click="false"
                                                    v-model="menu1"
                                                    :nudge-right="40"
                                                    :return-value.sync="allotmentYearBeginModel"
                                                    lazy
                                                    transition="scale-transition"
                                                    offset-y
                                                    full-width
                                                    max-width="290px"
                                                    min-width="290px"
                                            >
                                            <v-text-field
                                                    slot="activator"
                                                    v-model="allotmentYearBeginModel"
                                                    label="Год начала"
                                                    readonly
                                            ></v-text-field>
                                            <v-date-picker
                                                    v-model="allotmentYearEndModel"
                                                    no-title
                                                    scrollable
                                                    :type="year"
                                                    :reactive="reactive"
                                                    :landscape="landscape"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn flat color="primary" @click="menu = false">Отмена</v-btn>
                                                <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                        <v-menu
                                                ref="menu2"
                                                :close-on-content-click="false"
                                                v-model="menu2"
                                                :nudge-right="40"
                                                :return-value.sync="allotmentYearEndModel"
                                                lazy
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                max-width="290px"
                                                min-width="290px"
                                        >
                                            <v-text-field
                                                    slot="activator"
                                                    v-model="allotmentYearEndModel"
                                                    label="Год окончания"
                                                    readonly
                                            ></v-text-field>
                                            <v-date-picker
                                                    v-model="allotmentYearEndModel"
                                                    no-title
                                                    scrollable
                                                    :type="year"
                                                    :reactive="reactive"
                                                    :landscape="landscape"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn flat color="primary" @click="menu = false">Отмена</v-btn>
                                                <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                        <v-checkbox
                                                v-model="allotmentIsMainModel"
                                                label="Является основным"
                                        ></v-checkbox>
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
                                    Распределно часов: {{allotments[selectedAllotment] ? allotments[selectedAllotment].dis_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1">
                                    Всего часов часов: {{allotments[selectedAllotment] ? allotments[selectedAllotment].all_hours : ''}}
                                </v-flex>
                                <v-flex xs12 class="body-1" v-bind:class="allotments[selectedAllotment] ? isDistributed(allotments[selectedAllotment].dis_hours, allotments[selectedAllotment].all_hours) : ''">
                                    Осталось распределить: {{allotments[selectedAllotment] ? allotments[selectedAllotment].all_hours - allotments[selectedAllotment].dis_hours : 0}}
                                </v-flex>
                                <v-flex v-show="allotments[selectedAllotment] ? allotments[selectedAllotment].primary : false" xs12 class="body-1">
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
                menu1: false,
                menu2: false,

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
            },

            'currentPage': function() {
                this.setPageLoader()
            },

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
                    return 'dis_complite_not';
                }
                else if (dis_hours == all_hours){
                    return 'dis_complite';
                }
                else if (dis_hours > all_hours){
                    return 'dis_complite_error';
                }
                return '';
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
            },

            openAllotment(){
                this.setData({
                    path: 'сurrentAllotment',
                    data: this.allotments[this.selectedAllotment]
                });
                this.setData({
                    path: 'currentPage',
                    data: 'HiDiscipline'
                });
            },
        }
    }
</script>

<style src="../assets/sass/components/appPageAllotments.scss" lang="scss"/>