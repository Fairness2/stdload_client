<template>
    <div class="page_greed">
        <app-allotment-toolbar />
        <v-layout row fill-height >
            <v-flex xs12 sm4>
                <v-card class="disciplines">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Распределения</div>
                    </v-toolbar>



                </v-card>
            </v-flex>
            <v-spacer/>
            <v-flex xs12 sm7>
                <v-toolbar class="header white--text">
                    <div class="subheading">Настройки</div>
                </v-toolbar>
            </v-flex>
        </v-layout>
    </div>


</template>

<script>
    import appAllotmentToolbar from "./appAllotmentToolbar";
    export default {
        name: "appHiDiscipline",
        components: {appAllotmentToolbar}
    }
</script>

<style src="../assets/sass/components/appPageHiDiscipline.scss" lang="scss"/>