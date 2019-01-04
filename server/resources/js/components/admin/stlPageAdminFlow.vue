<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12 sm6>
            <v-card class="stl-flow">
                <v-toolbar class="header white--text">
                    <div class="subheading">Потоки</div>
                </v-toolbar>

                <v-list two-line class="stl-flow__list">
                    <template v-for="(item, index) in $store.state.flows">
                        <v-list-tile
                                :key="item.id"
                                @click="currentFlowModel = item"
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                <v-list-tile-sub-title class="text--primary">Распределение: {{ getAllotmentName(item.allotment_id) }}</v-list-tile-sub-title>
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
                            <div class="subheading">Параметры потока</div>
                        </v-toolbar>

                        <v-card-text v-if="Object.keys($store.state.currentFlow).length !== 0">
                            <v-layout row wrap>
                                <v-flex xs12>

                                </v-flex>

                                <v-flex xs12>
                                    <v-form>
                                        <v-text-field
                                                v-model="flowNameModel"
                                                label="Название"
                                                required
                                        ></v-text-field>
                                        <v-combobox
                                                v-model="flowAllotmentModel"
                                                :items="$store.state.allotments"
                                                item-value="id"
                                                item-text="name"
                                                label="Распределение"
                                                chips
                                        ></v-combobox>
                                        <v-btn
                                                class="primary"
                                                v-on:click="updateFlow"
                                        >
                                            Изменить
                                        </v-btn>
                                        <v-btn class="error" @click="deleteFlow">Удалить</v-btn>
                                    </v-form>
                                    <v-divider></v-divider>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-card-text v-else>
                            Выберите поток...
                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12>
                    <v-card class="new_flow">
                        <v-toolbar class="header white--text">
                            <div class="subheading">Новый поток</div>
                        </v-toolbar>

                        <v-card-text>
                            <v-form>
                                <v-text-field
                                        v-model="name"
                                        label="Название"
                                        required
                                ></v-text-field>

                                <v-combobox
                                        v-model="allotment"
                                        :items="$store.state.allotments"
                                        item-value="id"
                                        item-text="name"
                                        label="Распределение"
                                        chips
                                ></v-combobox>
                                <v-btn
                                        class="success"
                                        v-on:click="createFlow"
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
        name: "stlPageAdminFlow",
        components: {},
        data() {
            return {
                name: '',
                allotment: '',
            }
        },
        computed:{
            currentFlowModel: {
                get() {
                    return this.$store.state.currentFlow;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentFlow', value});
                }
            },
            flowNameModel: {
                get() {
                    return this.$store.state.currentFlow.name;
                },

                set(value) {
                    value = {...this.$store.state.currentFlow, ...{name: value}};
                    this.$store.commit('setData', {path: 'currentFlow', value});
                }
            },
            flowAllotmentModel: {
                get() {
                    let allotment = this.$store.state.allotments.find(c => c.id == this.$store.state.currentFlow.allotment_id) || null;
                    return allotment;
                },

                set(value) {
                    value = {...this.$store.state.currentFlow, ...{allotment_id: value.id}};
                    this.$store.commit('setData', {path: 'currentFlow', value});
                }
            },

        },
        methods:{

            getAllotmentName(id){
                let allotment = this.$store.state.allotments.find(c => c.id == id) || {};
                return Object.keys(allotment).length !== 0 ? allotment.name : '';
            },

            init(){
                this.updateTable();
            },

            updateTable(){
                this.$store.dispatch('updateFlow');
            },

            updateFlow(){
                this.$store.dispatch('editFlow');
            },

            createFlow(){
                let params = {
                    'name': this.name,
                    'allotment_id': this.allotment.id,
                };
                this.$store.dispatch('createFlow', params);
            },
            deleteFlow(){
                this.$store.dispatch('removeFlow');
            },

        },

        beforeMount() {
            this.init();
        }
    }
</script>

<style />