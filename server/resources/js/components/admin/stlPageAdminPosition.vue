<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-position stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Должности</div>
                </v-toolbar>

                <v-list two-line class="stl-position__list">
                    <template v-for="(item, index) in $store.state.positions">
                        <v-list-tile
                                :key="item.id"
                                @click="currentPositionModel = item"
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
                            <div class="subheading">Параметры должности</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentPosition).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="positionNameModel"
                                                label="краткое название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="positionFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updatePosition"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deletePosition">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите должность...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_position">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая должность</div>
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
                                        v-on:click="createPosition"
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
        name: "stlPageAdminPosition",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
            }
        },
        computed:{
            currentPositionModel: {
                get() {
                    return this.$store.state.currentPosition;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentPosition', value});
                }
            },
            positionNameModel: {
                get() {
                    return this.$store.state.currentPosition.name;
                },

                set(value) {
                    value = {...this.$store.state.currentPosition, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentPosition', value});
                }
            },
            positionFullNameModel: {
                get() {
                    return this.$store.state.currentPosition.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentPosition, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentPosition', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updatePosition');
            },

            updatePosition(){
                this.$store.dispatch('editPosition');
            },

            createPosition(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                };
                this.$store.dispatch('createPosition', params);
            },
            deletePosition(){
                this.$store.dispatch('removePosition');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />