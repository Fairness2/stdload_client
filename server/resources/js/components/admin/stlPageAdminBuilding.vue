<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-building stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Учебные корпуса</div>
                </v-toolbar>

                <v-list two-line class="stl-building__list">
                    <template v-for="(item, index) in $store.state.buildings">
                        <v-list-tile
                                :key="item.id"
                                @click="currentBuildingModel = item"
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
                            <div class="subheading">Параметры корпуса</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentBuilding).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="buildingNameModel"
                                                label="Краткое название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="buildingFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-textarea
                                                label="Адрес"
                                                v-model="buildingAddressModel"
                                        ></v-textarea>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateBuilding"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteBuilding">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите корпус...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_building">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый учебный корпус</div>
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
                                <v-textarea
                                        label="Адрес"
                                        v-model="address"
                                ></v-textarea>
                                <v-btn
                                        class="success"
                                        v-on:click="createBuilding"
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
        name: "stlPageAdminBuilding",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
                address: '',
            }
        },
        computed:{
            currentBuildingModel: {
                get() {
                    return this.$store.state.currentBuilding;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentBuilding', value});
                }
            },
            buildingNameModel: {
                get() {
                    return this.$store.state.currentBuilding.name;
                },

                set(value) {
                    value = {...this.$store.state.currentBuilding, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentBuilding', value});
                }
            },
            buildingFullNameModel: {
                get() {
                    return this.$store.state.currentBuilding.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentBuilding, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentBuilding', value});
                }
            },
            buildingAddressModel: {
                get() {
                    return this.$store.state.currentBuilding.address;
                },

                set(value) {
                    value = {...this.$store.state.currentBuilding, ...{address: value}};
                    this.$store.commit('setData', {path: 'currentBuilding', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateBuilding');
            },

            updateBuilding(){
                this.$store.dispatch('editBuilding');
            },

            createBuilding(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                    'address': this.address,
                };
                this.$store.dispatch('createBuilding', params);
            },
            deleteBuilding(){
                this.$store.dispatch('removeBuilding');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />