<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-classroom">
                <v-toolbar class="header white--text">
                    <div class="subheading">Аудитории</div>
                </v-toolbar>

                <v-list two-line class="stl-classroom__list">
                    <template v-for="(item, index) in $store.state.classrooms">
                        <v-list-tile
                                :key="item.id"
                                @click="currentClassroomModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Корпус: {{ getBuildingName(item.building_id) }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры аудитории</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentClassroom).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="classroomNameModel"
                                                label="Название"
                                                required
                                        ></v-text-field>
                                        <v-combobox
                                                v-model="classroomBuildingModel"
                                                :items="$store.state.buildings"
                                                item-value="id"
                                                item-text="full_name"
                                                label="Корпус"
                                                chips
                                        ></v-combobox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateClassroom"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteClassroom">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите аудиторию...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_classroom">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новая аудитория</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Название"
                                        required
                                ></v-text-field>

                                <v-combobox
                                        v-model="building"
                                        :items="$store.state.buildings"
                                        item-value="id"
                                        item-text="full_name"
                                        label="Корпус"
                                        chips
                                ></v-combobox>
                                <v-btn
                                        class="success"
                                        v-on:click="createClassroom"
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
        name: "stlPageAdminClassroom",
        components: {},
        data() {
            return {
                name: '',
                building: '',
            }
        },
        computed:{
            currentClassroomModel: {
                get() {
                    return this.$store.state.currentClassroom;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentClassroom', value});
                }
            },
            classroomNameModel: {
                get() {
                    return this.$store.state.currentClassroom.name;
                },

                set(value) {
                    value = {...this.$store.state.currentClassroom, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentClassroom', value});
                }
            },
            classroomBuildingModel: {
                get() {
                    let building = this.$store.state.buildings.find(c => c.id == this.$store.state.currentClassroom.building_id) || {};
                    return building;
                },

                set(value) {
                    value = {...this.$store.state.currentClassroom, ...{building_id: value.id}};
                    this.$store.commit('setData', {path: 'currentClassroom', value});
                }
            },

        },
        methods:{

            getBuildingName(id){
                let building = this.$store.state.buildings.find(c => c.id == id) || {};
                return Object.keys(building).length !== 0 ? building.full_name : '';
            },

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateClassroom');
            },

            updateClassroom(){
                this.$store.dispatch('editClassroom');
            },

            createClassroom(){
                let params = {
                    'name': this.name,
                    'building_id': this.building.id,
                };
                this.$store.dispatch('createClassroom', params);
            },
            deleteClassroom(){
                this.$store.dispatch('removeClassroom');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />