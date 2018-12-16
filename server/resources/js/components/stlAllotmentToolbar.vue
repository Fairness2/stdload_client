<template>
    <v-layout row fill-height  class="allotment_toolbox">
        <div class="allotment_toolbox__element">
            <router-link :to="{name: 'homePage'}">
                <v-btn outline color="primary" title="К распределениям">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
            </router-link>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="$store.state.dimensions"
                    label="Представление"
                    v-model="currentDimensionModel"
                    outline
                    single-line
            ></v-select>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="$store.state.semesters"
                    label="Семестр"
                    v-model="currentSemesterModel"
                    outline
                    single-line
            ></v-select>
        </div>
        <v-spacer/>
        <div class="allotment_toolbox__element">
            <v-btn outline color="primary" title="Поставить на автоматическое распределение">
                <v-icon>play_circle_outline</v-icon>
            </v-btn>
        </div>
        <div class="allotment_toolbox__element">
            <v-btn outline color="primary" title="Выгрузить в файл">
                <v-icon>cloud_download</v-icon>
            </v-btn>
        </div>
        <div class="allotment_toolbox__element">

            <v-dialog v-model="showLoadInFile" width="500">
                <v-btn slot="activator" outline color="primary" title="Загрузить из файла">
                    <v-icon>cloud_upload</v-icon>
                </v-btn>

                <v-card>
                    <form method="post" action="/allotments/load_allotment" enctype="multipart/form-data">
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            Выберите файл
                        </v-card-title>

                        <v-card-text>

                            <input type="hidden" name="_token" :value="$store.getters.csrf">
                            <input type="hidden" name="allotment_id" :value="$store.state.сurrentAllotment.id" required>
                            <input type="file" name="file" required>
                            <input type="hidden" name="semester" :value="selectSemester" required>
                            <v-select
                                    color="primary"
                                    :items="$store.state.semesters"
                                    label="Семестр"
                                    v-model="selectSemester"
                            ></v-select>
                            <input type="hidden" name="update_workers" :value="updateWorkers">
                            <v-checkbox
                                    v-model="updateWorkers"
                                    label="Обновить преподавателей"
                            ></v-checkbox>

                        </v-card-text>

                        <v-card-actions>
                            <v-btn
                                    color="success"
                                    flat
                                    type="submit"
                            >
                                Загрузить
                            </v-btn>

                            <v-btn
                                    color=""
                                    flat
                                    @click="showLoadInFile = false"
                            >
                                Отмена
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card>

            </v-dialog>
        </div>
        <div class="allotment_toolbox__element">
            <v-btn outline color="primary" title="Сделать основным">
                <v-icon>cloud_done</v-icon>
            </v-btn>
        </div>
        <div class="outline">
            <v-card-text><b class="text--primary">Распределение: {{$store.state.сurrentAllotment.name}}</b></v-card-text>
        </div>
    </v-layout>
</template>

<script>


    export default {
        name: "StlAllotmentToolbar",
        components: {},
        props:[],
        data: () => ({
            showLoadInFile: false,
            selectSemester: 3,
            updateWorkers: false,
        }),
        computed:{
            currentSemesterModel: {
                get() {
                    return this.$store.state.currentSemester;
                },

                set(value) {
                    if (this.$store.state.currentSemester != value) {
                        this.$store.commit('setData', {path: 'currentSemester', value});
                        this.$store.dispatch('changeSemester');
                    }
                }
            },
            currentDimensionModel: {
                get() {
                    return this.$store.state.currentDimension;
                },

                set(value) {
                    if (this.$store.state.currentDimension != value) {
                        this.$store.commit('setData', {path: 'currentDimension', value});
                        if (value == 1){
                            this.$route.push({name: 'hiDiscipline', params: {id: this.$store.state.сurrentAllotment.id}});
                        }
                        else if (value == 2){
                            this.$route.push({name: 'StlPageHiEmployee', params: {id: this.$store.state.сurrentAllotment.id}});
                        }
                        else if (value == 3){
                            this.$route.push({name: 'StlPageHiGroup', params: {id: this.$store.state.сurrentAllotment.id}});
                        }
                        //this.$store.dispatch('changeDimension');
                    }
                }
            },
        },

        watch:{

        },

        methods:{

        },

        beforeMount (){

        }
    }
</script>

<style></style>