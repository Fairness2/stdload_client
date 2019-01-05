<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-discipline stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Дисциплины</div>
                </v-toolbar>

                <v-list two-line class="stl-discipline__list">
                    <template v-for="(item, index) in $store.state.disciplines">
                        <v-list-tile
                                :key="item.id"
                                @click="currentDisciplineModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.full_name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Краткое название: {{ item.name }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры дисциплины</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentDiscipline).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="disciplineNameModel"
                                                label="Краткое название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="disciplineFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateDiscipline"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteDiscipline">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите дисциплину...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_discipline">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая дисциплина</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Краткое название"
                                        required
                                ></v-text-field>

                                <v-text-field
                                        v-model="full_name"
                                        label="Полное название"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createDiscipline"
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
        name: "stlPageAdminDiscipline",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
            }
        },
        computed:{
            currentDisciplineModel: {
                get() {
                    return this.$store.state.currentDiscipline;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentDiscipline', value});
                }
            },
            disciplineNameModel: {
                get() {
                    return this.$store.state.currentDiscipline.name;
                },

                set(value) {
                    value = {...this.$store.state.currentDiscipline, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentDiscipline', value});
                }
            },
            disciplineFullNameModel: {
                get() {
                    return this.$store.state.currentDiscipline.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentDiscipline, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentDiscipline', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateDiscipline');
            },

            updateDiscipline(){
                this.$store.dispatch('editDiscipline');
            },

            createDiscipline(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                };
                this.$store.dispatch('createDiscipline', params);
            },
            deleteDiscipline(){
                this.$store.dispatch('removeDiscipline');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />