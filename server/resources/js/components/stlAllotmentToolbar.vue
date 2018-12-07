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
                    v-model="selectedDimension"
                    outline
                    single-line
            ></v-select>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="$store.state.semesters"
                    label="Семестр"
                    v-model="selectedSemester"
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
        name: "stlAllotmentToolbar",
        props:[],
        data: () => ({

        }),
        computed:{

        },

        watch:{
            selectedDimension: function (val) {

            },
            selectedSemester: function (val) {
                this.$store.dispatch('changeSemester', val);
            },
        },

        methods:{

        },

        beforeMount (){

        }
    }
</script>

<style src="../assets/sass/components/appAllotmentToolbar.scss" lang="scss"/>