<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="">
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

        <v-flex xs12 sm5>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card class="">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Параметры ставки</div>
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
                                        <v-text-field
                                                type="number"
                                                v-model="workerHoursModel"
                                                label="Ставка (часов)"
                                                required
                                        ></v-text-field>
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
                                    <strong>Ставка (часов): </strong>{{item.hours }}
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
        name: "stlPageAdminRateWorker",
        components: {},
        data() {
            return {

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
            workerHoursModel: {
                get() {
                    return this.$store.state.currentWorker.hours;
                },

                set(value) {
                    value = {...this.$store.state.currentWorker, ...{hours: value}};
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },

        },
        methods:{

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateRateWorker');
            },

            updateWorker(){
                this.$store.dispatch('editRateWorker');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />