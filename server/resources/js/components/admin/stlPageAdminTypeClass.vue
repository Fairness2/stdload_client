<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-type-class stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Виды занятий</div>
                </v-toolbar>

                <v-list two-line class="stl-type-class__list">
                    <template v-for="(item, index) in $store.state.typeClass">
                        <v-list-tile
                                :key="item.id"
                                @click="currentTypeClassModel = item"
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

        <v-flex xs12 sm5 class="">
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры типа занятия</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentTypeClass).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="typeClassNameModel"
                                                label="краткое название"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="typeClassFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateTypeClass"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteTypeClass">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите тип занятия...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_type-class">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый тип занятия</div>
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
                                        v-on:click="createTypeClass"
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
        name: "stlPageAdminTypeClass",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
            }
        },
        computed:{
            currentTypeClassModel: {
                get() {
                    return this.$store.state.currentTypeClass;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentTypeClass', value});
                }
            },
            typeClassNameModel: {
                get() {
                    return this.$store.state.currentTypeClass.name;
                },

                set(value) {
                    value = {...this.$store.state.currentTypeClass, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentTypeClass', value});
                }
            },
            typeClassFullNameModel: {
                get() {
                    return this.$store.state.currentTypeClass.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentTypeClass, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentTypeClass', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateTypeClass');
            },

            updateTypeClass(){
                this.$store.dispatch('editTypeClass');
            },

            createTypeClass(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                };
                this.$store.dispatch('createTypeClass', params);
            },
            deleteTypeClass(){
                this.$store.dispatch('removeTypeClass');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />