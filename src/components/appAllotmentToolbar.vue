<template>
    <v-layout row fill-height  class="allotment_toolbox">
        <div class="allotment_toolbox__element">
            <v-btn outline color="primary" title="К распределениям">
                <v-icon>arrow_back</v-icon>
            </v-btn>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="dimensions"
                    label="Представление"
                    v-model="dimension"
                    outline
                    single-line
            ></v-select>
        </div>
        <v-spacer/>
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
            <v-card-text><b class="text--primary">Распределение: {{сurrentAllotment.name}}</b></v-card-text>
        </div>
    </v-layout>
</template>

<script>
    import {mapState, mapMutations} from 'vuex';
    export default {
        name: "appAllotmentToolbar",
        data: () => ({
            dimensions: ['По дсициплине', 'По преподавателю', 'По наприведению'],
            dimension: 'По дсициплине'
        }),
        computed:{
            ...mapState([
                'сurrentAllotment',
                'currentPage'
            ])
        }
    }
</script>

<style src="../assets/sass/components/appAllotmentToolbar.scss" lang="scss"/>