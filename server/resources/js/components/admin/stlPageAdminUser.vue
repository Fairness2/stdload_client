<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-user">
                <v-toolbar class="header white--text">
                    <div class="subheading">Пользователи</div>
                </v-toolbar>

                <v-list two-line class="stl-user__list">
                    <template v-for="(item, index) in $store.state.users">
                        <v-list-tile
                                :key="item.id"
                                @click="currentUserModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.email}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">ФИО: {{ item.name }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры пользователя</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentUser).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <p>
                                        <strong>Email: </strong>{{$store.state.currentUser.email}}
                                    </p>
                                    <p>
                                        <strong>ФИО: </strong>{{$store.state.currentUser.name}}
                                    </p>
                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-combobox
                                                v-model="userWorkerIdModel"
                                                :items="$store.state.workers"
                                                item-value="id"
                                                item-text="fio"
                                                label="Преподаватель"
                                                chips
                                        ></v-combobox>
                                        <v-combobox
                                                v-model="userRolesModel"
                                                :items="$store.state.roles"
                                                item-value="id"
                                                item-text="public_name"
                                                label="Роли"
                                                multiple
                                                chips
                                        ></v-combobox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateUser"
                                        >
                                            Изменить
                                        </v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите пользователя...
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>

    </v-layout>
</template>

<script>
    export default {
        name: "stlPageAdminUser",
        components: {},
        data() {
            return {
                name: '',
                building: '',
            }
        },
        computed:{
            currentUserModel: {
                get() {
                    return this.$store.state.currentUser;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentUser', value});
                }
            },
            userWorkerIdModel: {
                get() {
                    let worker = this.$store.state.workers.find(c => c.id == this.$store.state.currentUser.worker_id) || null;
                    return worker;
                },

                set(value) {
                    value = {...this.$store.state.currentUser, ...{worker_id: value.id}};
                    this.$store.commit('setData', {path: 'currentUser', value});
                }
            },
            userRolesModel: {
                get() {
                    let roles = [];
                    for (let role_index in this.$store.state.currentUser.roles) {
                        let role = this.$store.state.roles.find(c => c.id == this.$store.state.currentUser.roles[role_index])
                        if (role)
                            roles.push(role);
                    }
                    return roles;
                },

                set(value) {
                    let roles = [];
                    for (let role_index in value){
                        roles.push(value[role_index].id);
                    }
                    value = {...this.$store.state.currentUser, ...{roles: roles}};
                    this.$store.commit('setData', {path: 'currentUser', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateUser');
            },

            updateUser(){
                this.$store.dispatch('editUser');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />