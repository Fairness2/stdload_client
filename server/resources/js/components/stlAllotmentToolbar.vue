<template>
    <v-layout row fill-height  class="allotment_toolbox">
        <div class="allotment_toolbox__element">
            <v-btn outline color="primary" @click="goPageAllotments()" title="К распределениям">
                <v-icon>arrow_back</v-icon>
            </v-btn>
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
            <v-btn outline color="primary" title="Загрузить из файла">
                <v-icon>cloud_upload</v-icon>
            </v-btn>
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
        props:[],
        data: () => ({

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