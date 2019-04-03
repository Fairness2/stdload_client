<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-specialty stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">Направления подготовки</div>
                </v-toolbar>

                <v-list two-line class="stl-specialty__list">
                    <template v-for="(item, index) in $store.state.specialties">
                        <v-list-tile
                                :key="item.id"
                                @click="currentSpecialtyModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.full_name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Корпус: {{ getFacultyName(item.faculty_id) }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры направления подготовки</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentSpecialty).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="specialtyNameModel"
                                                label="Краткое название"
                                                required
                                        ></v-text-field>
                                        <v-text-field
                                                v-model="specialtyFullNameModel"
                                                label="Полное название"
                                                required
                                        ></v-text-field>
                                        <v-combobox
                                                v-model="specialtyFacultyModel"
                                                :items="$store.state.faculties"
                                                item-value="id"
                                                item-text="full_name"
                                                label="Факультет"
                                                chips
                                        ></v-combobox>
                                        <v-combobox
                                                v-model="specialtyQualificationModel"
                                                :items="$store.state.qualifications"
                                                item-value="id"
                                                item-text="name"
                                                label="Квалификация"
                                                chips
                                        ></v-combobox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateSpecialty"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteSpecialty">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите направление подготовки...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_specialty">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новое направление подготовки</div>
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

                                <v-combobox
                                        v-model="faculty"
                                        :items="$store.state.faculties"
                                        item-value="id"
                                        item-text="full_name"
                                        label="Факультет"
                                        chips
                                ></v-combobox>
                                <v-combobox
                                        v-model="qualification"
                                        :items="$store.state.qualifications"
                                        item-value="id"
                                        item-text="name"
                                        label="Квалификация"
                                        chips
                                ></v-combobox>
                                <v-btn
                                        class="success"
                                        v-on:click="createSpecialty"
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
        name: "stlPageAdminSpecialty",
        components: {},
        data() {
            return {
                name: '',
                full_name: '',
                faculty: null,
                qualification: null,
            }
        },
        computed:{
            currentSpecialtyModel: {
                get() {
                    return this.$store.state.currentSpecialty;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentSpecialty', value});
                }
            },
            specialtyNameModel: {
                get() {
                    return this.$store.state.currentSpecialty.name;
                },

                set(value) {
                    value = {...this.$store.state.currentSpecialty, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentSpecialty', value});
                }
            },
            specialtyFullNameModel: {
                get() {
                    return this.$store.state.currentSpecialty.full_name;
                },

                set(value) {
                    value = {...this.$store.state.currentSpecialty, ...{full_name: value}};
                    this.$store.commit('setData', {path: 'currentSpecialty', value});
                }
            },
            specialtyFacultyModel: {
                get() {
                    let faculty = this.$store.state.faculties.find(c => c.id == this.$store.state.currentSpecialty.faculty_id) || null;
                    return faculty;
                },

                set(value) {
                    value = {...this.$store.state.currentSpecialty, ...{faculty_id: value.id}};
                    this.$store.commit('setData', {path: 'currentSpecialty', value});
                }
            },
            specialtyQualificationModel: {
                get() {
                    let qualification = this.$store.state.qualifications.find(c => c.id == this.$store.state.currentSpecialty.qualification_id) || null;
                    return qualification;
                },

                set(value) {
                    value = {...this.$store.state.currentSpecialty, ...{qualification_id: value.id}};
                    this.$store.commit('setData', {path: 'currentSpecialty', value});
                }
            },

        },
        methods:{

            getFacultyName(id){
                let faculty = this.$store.state.faculties.find(c => c.id == id) || {};
                return Object.keys(faculty).length !== 0 ? faculty.full_name : '';
            },

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateSpecialty');
            },

            updateSpecialty(){
                this.$store.dispatch('editSpecialty');
            },

            createSpecialty(){
                let params = {
                    'name': this.name,
                    'full_name': this.full_name,
                    'faculty_id': this.faculty.id,
                    'qualification_id': this.qualification.id,
                };
                this.$store.dispatch('createSpecialty', params);
            },
            deleteSpecialty(){
                this.$store.dispatch('removeSpecialty');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />