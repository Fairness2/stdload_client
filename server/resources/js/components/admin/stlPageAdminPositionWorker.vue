<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-page__column-card">
                <v-toolbar class="header white--text">
                    <div class="subheading">ППС</div>
                </v-toolbar>

                <v-list class="">
                    <template v-for="(item, index) in $store.state.workers">
                        <v-list-tile
                                :key="item.id"
                                @click="currentWorkerModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.fio}}</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        <v-divider />
                    </template>
                </v-list>

            </v-card>
        </v-flex>

        <v-flex xs12 sm5 class="stl-page__column-card">
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры должности</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentWorker).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <p>
                                        <strong>ФИО: </strong>{{$store.state.currentWorker.fio}}
                                    </p>
                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-combobox
                                                v-model="workerPositionModel"
                                                :items="$store.state.positions"
                                                item-value="id"
                                                item-text="full_name"
                                                label="Специальность"
                                                chips
                                        ></v-combobox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateWorker"
                                        >
                                            Изменить
                                        </v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите преподавателя...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">История изменений</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentWorker).length !== 0">
                            <div v-for="(item, index) in $store.state.currentWorker.history">
                                <p>
                                    <strong>Дата: </strong>{{item.date_begin}}
                                </p>
                                <p>
                                    <strong>Должность: </strong>{{getPositionName(item.position_id)}}
                                </p>
                                <v-divider />
                            </div>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите преподавателя...
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>

    </v-layout>
</template>

<script>
    export default {
        name: "stlPageAdminPositionWorker",
        components: {},
        data() {
            return {
                name: '',
                building: '',
            }
        },
        computed:{
            currentWorkerModel: {
                get() {
                    return this.$store.state.currentWorker;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },
            workerPositionModel: {
                get() {
                    let position = this.$store.state.positions.find(c => c.id == this.$store.state.currentWorker.position_id) || null;
                    return position;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{position_id: value.id}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },

        },
        methods:{

            getPositionName(id){
                let position = this.$store.state.positions.find(c => c.id == id) || {};
                return Object.keys(position).length !== 0 ? position.full_name : '';
            },

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updatePositionWorker');
            },

            updateWorker(){
                this.$store.dispatch('editPositionWorker');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />