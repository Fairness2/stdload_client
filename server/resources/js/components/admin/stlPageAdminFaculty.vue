<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-faculty">
                <v-toolbar class="header white--text">
                    <div class="subheading">Факультеты</div>
                </v-toolbar>

                <v-list two-line class="stl-faculty__list">
                    <template v-for="(item, index) in $store.state.faculties">
                        <v-list-tile
                                :key="item.id"
                                @click="currentFacultyModel = item"
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

        <v-flex xs12 sm5>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры факультета</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentFaculty).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="facultyNameModel"
                                                label="Краткое название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="facultyFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateFaculty"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteFaculty">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите факультет...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_faculty">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый факультет</div>
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
                                        v-on:click="createFaculty"
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
        name: "stlPageAdminFaculty",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
            }
        },
        computed:{
            currentFacultyModel: {
                get() {
                    return this.$store.state.currentFaculty;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentFaculty', value});
                }
            },
            facultyNameModel: {
                get() {
                    return this.$store.state.currentFaculty.name;
                },

                set(value) {
                    value = {...this.$store.state.currentFaculty, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentFaculty', value});
                }
            },
            facultyFullNameModel: {
                get() {
                    return this.$store.state.currentFaculty.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentFaculty, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentFaculty', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateFaculty');
            },

            updateFaculty(){
                this.$store.dispatch('editFaculty');
            },

            createFaculty(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                };
                this.$store.dispatch('createFaculty', params);
            },
            deleteFaculty(){
                this.$store.dispatch('removeFaculty');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />