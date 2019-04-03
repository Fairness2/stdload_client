<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-roles stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Роли</div>
                </v-toolbar>

                <v-list two-line class="stl-roles__list">
                    <template v-for="(item, index) in $store.state.roles">
                        <v-list-tile
                                :key="item.id"
                                @click="currentRoleModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.public_name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Системное имя: {{ item.name }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры роли</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentRole).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="roleNameModel"
                                                label="Системное имя"
                                                required
                                        ></v-text-field>

                                        <v-text-field
                                                v-model="rolePublicNameModel"
                                                label="Публичное имя"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateRole"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteRole">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите роль...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_role">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая роль</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Системное имя"
                                        required
                                ></v-text-field>

                                <v-text-field
                                        v-model="public_name"
                                        label="Публичное имя"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createRole"
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
        name: "stlPageAdminRole",
        components: {},
        data() {
            return {
                name: '',
                public_name: '',
            }
        },
        computed:{
            currentRoleModel: {
                get() {
                    return this.$store.state.currentRole;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentRole', value});
                }
            },
            roleNameModel: {
                get() {
                    return this.$store.state.currentRole.name;
                },

                set(value) {
                    value = {...this.$store.state.currentRole, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentRole', value});
                }
            },
            rolePublicNameModel: {
                get() {
                    return this.$store.state.currentRole.public_name;
                },

                set(value) {
                    value = {...this.$store.state.currentRole, ...{public_name: value}};
                    this.$store.commit('setData', {path: 'currentRole', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateRoles');
            },

            updateRole(){
                this.$store.dispatch('editRole');
            },

            createRole(){
                let params = {
                    'name': this.name,
                    'public_name': this.public_name,
                };
                this.$store.dispatch('createRole', params);
            },
            deleteRole(){
                this.$store.dispatch('removeRole');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />