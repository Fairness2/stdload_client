<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-group stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Группы</div>
                </v-toolbar>

                <v-list class="stl-group__list">
                    <template v-for="(item, index) in $store.state.groups">
                        <v-list-tile
                                :key="item.id"
                                @click="currentGroupModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
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
                            <div class="subheading">Параметры группы</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentGroup).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="groupNameModel"
                                                label="Название"
                                                required
                                        ></v-text-field>
                                        <v-combobox
                                                v-model="groupSpecialtyModel"
                                                :items="$store.state.specialties"
                                                item-value="id"
                                                item-text="full_name"
                                                label="Специальность"
                                                chips
                                        ></v-combobox>
                                        <v-text-field
                                                type="number"
                                                v-model="groupYearBeginModel"
                                                :rules="yearRules"
                                                :counter="4"
                                                label="Год поступления"
                                                required
                                        ></v-text-field>
                                        <v-checkbox
                                                label="Очная"
                                                v-model="groupIsFullTimeModel"
                                        ></v-checkbox>
                                        <v-checkbox
                                                label="Ускоренная"
                                                v-model="groupIsAcceleratedModel"
                                        ></v-checkbox>
                                        <v-text-field
                                                type="number"
                                                v-model="groupNumberStudentsModel"
                                                :counter="2"
                                                label="Количество студентов"
                                                required
                                        ></v-text-field>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateGroup"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteGroup">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите группу...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_пroup">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая группа</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Название"
                                        required
                                ></v-text-field>
                                <v-combobox
                                        v-model="specialty"
                                        :items="$store.state.specialties"
                                        item-value="id"
                                        item-text="full_name"
                                        label="Специальность"
                                        chips
                                ></v-combobox>
                                <v-text-field
                                        type="number"
                                        v-model="year_begin"
                                        :rules="yearRules"
                                        :counter="4"
                                        label="Год поступления"
                                        required
                                ></v-text-field>
                                <v-checkbox
                                        label="Очная"
                                        v-model="is_full_time"
                                ></v-checkbox>
                                <v-checkbox
                                        label="Ускоренная"
                                        v-model="is_accelerated"
                                ></v-checkbox>
                                <v-text-field
                                        type="number"
                                        v-model="number_students"
                                        :counter="2"
                                        label="Количество студентов"
                                        required
                                ></v-text-field>
                                <v-btn
                                        class="success"
                                        v-on:click="createGroup"
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
        name: "stlPageAdminGroup",
        components: {},
        data() {
            return {
                name: '',
                specialty: '',
                year_begin: '',
                is_full_time: true,
                is_accelerated: false,
                number_students: null,

                yearRules: [
                    v => !!v || 'Введите учебный год',
                    v => /^(19|20)[0-9]{2}$/.test(v) || 'Год должен быть записан в виде гггг'
                ],
            }
        },
        computed:{
            currentGroupModel: {
                get() {
                    return this.$store.state.currentGroup;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupNameModel: {
                get() {
                    return this.$store.state.currentGroup.name;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupYearBeginModel: {
                get() {
                    return this.$store.state.currentGroup.year_begin;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{year_begin: value}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupIsFullTimeModel: {
                get() {
                    return this.$store.state.currentGroup.is_full_time;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{is_full_time: value}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupIsAcceleratedModel: {
                get() {
                    return this.$store.state.currentGroup.is_accelerated;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{is_accelerated: value}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupNumberStudentsModel: {
                get() {
                    return this.$store.state.currentGroup.number_students;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{number_students: value}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },
            groupSpecialtyModel: {
                get() {
                    let specialty = this.$store.state.specialties.find(c => c.id == this.$store.state.currentGroup.specialty_id) || null;
                    return specialty;
                },

                set(value) {
                    value = {...this.$store.state.currentGroup, ...{specialty_id: value.id}};
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateGroup');
            },

            updateGroup(){
                this.$store.dispatch('editGroup');
            },

            createGroup(){
                let params = {
                    'name': this.name,
                    'specialty_id': this.specialty.id,
                    'year_begin': this.year_begin,
                    'is_full_time': this.is_full_time,
                    'is_accelerated': this.is_accelerated,
                    'number_students': this.number_students,
                };
                this.$store.dispatch('createGroup', params);
            },
            deleteGroup(){
                this.$store.dispatch('removeGroup');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />