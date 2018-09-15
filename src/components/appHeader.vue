<template>
    <v-toolbar class="header white--text">
        <v-layout row wrap>
            <v-flex sm6 class="text-xs-left hidden-sm-and-down title">
                Система распределения учебной нагрузки
            </v-flex>
            <v-flex sm6 xs12 class="text-sm-right">
                <v-menu offset-y>
                    <div slot="activator">
                        {{currentUser.name}}
                    </div>
                    <v-list>
                        <v-list-tile @click="">
                            <v-list-tile-title>
                                Выйти
                            </v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-flex>
        </v-layout>
    </v-toolbar>
</template>

<script>
    //TODO По центру страницы
    import {mapState} from 'vuex';

    export default {
        name: "appHeader",
        components: {},

        computed:{
            ...mapState([
                'currentUser'
            ])
        }
    }
</script>

<style src="../assets/sass/components/appHeader.scss" lang="scss"/>