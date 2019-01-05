<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-worker stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">ППС</div>
                </v-toolbar>

                <v-list class="stl-worker__list">
                    <template v-for="(item, index) in $store.state.workers">
                        <v-list-tile
                                :key="item.id"
                                @click="currentWorkerModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.fio}}</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        <v-divider />
                    </template>
                </v-list>

            </v-card>
        </v-flex>

        <v-flex xs12 sm5 class="stl-page__column">
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры преподавателя</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentWorker).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="workerNameModel"
                                                label="Имя"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="workerSurnameModel"
                                                label="Фамилия"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="workerPatronymicModel"
                                                label="Отчество"
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="workerFioModel"
                                                label="ФИО"
                                                required
                                        ></v-text-field>
                                        <v-checkbox
                                                label="Архивный"
                                                v-model="workerNotActiveModel"
                                        ></v-checkbox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateWorker"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteWorker">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите преподавателя...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_worker">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый преподаватель</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Имя"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        v-model="surname"
                                        label="Фамилия"
                                        required
                                ></v-text-field>
                                <v-text-field
                                        v-model="patronymic"
                                        label="Отчество"
                                ></v-text-field>
                                <v-text-field
                                        v-model="fio"
                                        label="ФИО"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createWorker"
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
        name: "stlPageAdminWorker",
        components: {},
        data() {
            return {
                name: '',
                fio: '',
                surname: '',
                patronymic: '',
            }
        },
        computed:{
            currentWorkerModel: {
                get() {
                    return this.$store.state.currentWorker;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerNameModel: {
                get() {
                    return this.$store.state.currentWorker.name;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerSurnameModel: {
                get() {
                    return this.$store.state.currentWorker.surname;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{surname: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerPatronymicModel: {
                get() {
                    return this.$store.state.currentWorker.patronymic;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{patronymic: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerFioModel: {
                get() {
                    return this.$store.state.currentWorker.fio;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{fio: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerNotActiveModel: {
                get() {
                    return this.$store.state.currentWorker.not_active;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{not_active: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateWorker');
            },

            updateWorker(){
                this.$store.dispatch('editWorker');
            },

            createWorker(){
                let params = {
                    'name': this.name,
                    'surname': this.surname,
                    'patronymic': this.patronymic,
                    'fio': this.fio,
                };
                this.$store.dispatch('createWorker', params);
            },
            deleteWorker(){
                this.$store.dispatch('removeWorker');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />