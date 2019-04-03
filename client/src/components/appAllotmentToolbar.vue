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
                    :items="dimensions"
                    label="Представление"
                    v-model="selectedDimension"
                    outline
                    single-line
            ></v-select>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="semesters"
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
            <v-card-text><b class="text--primary">Распределение: {{currentAllotment.name}}</b></v-card-text>
        </div>
    </v-layout>
</template>

<script>
    import {mapState, mapMutations} from 'vuex';
    export default {
        name: "appAllotmentToolbar",
        props:[
            'dimension'
        ],
        data: () => ({
            dimensions: [
                {
                    text: 'По дсициплине',
                },
                {
                    text: 'По преподавателю',
                },
                {
                    text: 'По направлению',
                },
            ],
            semesters: [
                {
                    text: 'Осенний',
                    value: 1
                },
                {
                    text: 'Весенний',
                    value: 2
                },
                {
                    text: 'Все',
                    value: 3
                },
            ],
            selectedSemester: null,
            selectedDimension: null,
        }),
        computed:{
            ...mapState([
                'currentAllotment',
                'currentPage',
                'currentSemester'
            ])
        },

        watch:{
            selectedDimension: function (val) {
                let page = 'PageAllotments';
                switch (val) {
                    case 'По дсициплине':
                        page = 'HiDiscipline';
                        break;
                    case 'По преподавателю':
                        page = 'HiEmployee';
                        break;
                    case 'По направлению':
                        page = 'HiGroup';
                        break;
                }
                this.setData({
                    path: 'currentPage',
                    data: page
                });
            },
            selectedSemester: function (val) {
                let page = 'PageAllotments';
                switch (this.selectedDimension) {
                    case 'По дсициплине':
                        page = 'HiDiscipline';
                        break;
                    case 'По преподавателю':
                        page = 'HiEmployee';
                        break;
                    case 'По направлению':
                        page = 'HiGroup';
                        break;
                }
                this.setData({
                    path: 'currentSemester',
                    data: val
                });
                this.setData({
                    path: 'currentPage',
                    data: page
                });
            },
        },

        methods:{
            ...mapMutations([
                'setPageLoader',
                'removePageLoader',
                'setData'
            ]),

            goPageAllotments(){
                this.setData({
                    path: 'currentPage',
                    data: 'PageAllotments'
                });
            },
        },

        beforeMount (){
            this.selectedSemester = this.currentSemester;
            this.selectedDimension = this.dimension;
        }
    }
</script>

<style src="../assets/sass/components/appAllotmentToolbar.scss" lang="scss"/>