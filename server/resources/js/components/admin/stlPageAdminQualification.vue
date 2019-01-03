<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-qualification">
                <v-toolbar class="header white--text">
                    <div class="subheading">Квалификации</div>
                </v-toolbar>

                <v-list two-line class="stl-qualification__list">
                    <template v-for="(item, index) in $store.state.qualifications">
                        <v-list-tile
                                :key="item.id"
                                @click="currentQualificationModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Обозначение: {{ item.literal }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры квалификации</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentQualification).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="qualificationNameModel"
                                                label="Название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="qualificationLiteralModel"
                                                label="Обозначение"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateQualification"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteQualification">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите квалификацию...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_type-class">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая квалификация</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Название"
                                        required
                                ></v-text-field>

                                <v-text-field
                                        v-model="literal"
                                        label="Обозначение"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createQualification"
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
        name: "stlPageAdminQualification",
        components: {},
        data() {
            return {
                name: '',
                literal: '',
            }
        },
        computed:{
            currentQualificationModel: {
                get() {
                    return this.$store.state.currentQualification;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentQualification', value});
                }
            },
            qualificationNameModel: {
                get() {
                    return this.$store.state.currentQualification.name;
                },

                set(value) {
                    value = {...this.$store.state.currentQualification, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentQualification', value});
                }
            },
            qualificationLiteralModel: {
                get() {
                    return this.$store.state.currentQualification.literal;
                },

                set(value) {
                    value = {...this.$store.state.currentQualification, ...{literal: value}};
                    this.$store.commit('setData', {path: 'currentQualification', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateQualification');
            },

            updateQualification(){
                this.$store.dispatch('editQualification');
            },

            createQualification(){
                let params = {
                    'name': this.name,
                    'literal': this.literal,
                };
                this.$store.dispatch('createQualification', params);
            },
            deleteQualification(){
                this.$store.dispatch('removeQualification');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />