<template>
    <v-layout row justify-space-around fill-height>

        <v-flex xs12>
            <v-card class="stl-admin page-admin__column">
                <v-toolbar class="header white--text">
                    <div class="subheading">Разделы</div>
                </v-toolbar>

                <v-list class="stl-admin__list">
                    <template v-for="(item, index) in paths">
                        <router-link :to="item.path">
                        <v-list-tile
                                ripple
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{item.name}}</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                        </router-link>
                        <v-divider />
                    </template>
                </v-list>

            </v-card>
        </v-flex>

    </v-layout>
</template>

<script>

    export default {
        name: "stlPageAdmin",
        components: {},
        data() {
            return {

                paths: [
                    {'name': 'Пользователи', 'path': '/admin/user'},//
                    {'name': 'Корпуса', 'path': '/admin/building'},//
                    {'name': 'Аудитории', 'path': '/admin/classroom'},//
                    {'name': 'Преподаватели', 'path': '/admin/worker'},//
                    {'name': 'Дисциплины', 'path': '/admin/discipline'},//
                    {'name': 'Факультеты', 'path': '/admin/faculty'},//
                    {'name': 'Потоки', 'path': '/admin/flow'},//
                    {'name': 'Группы', 'path': '/admin/group'},//
                    {'name': 'Должности', 'path': '/admin/position'},//
                    {'name': 'Квалификации', 'path': '/admin/qualification'},//
                    {'name': 'Требования ФГОС', 'path': '/admin/requirement_fgos'},//
                    {'name': 'Роли', 'path': '/admin/roles'},//
                    {'name': 'Направления подготовки', 'path': '/admin/specialty'},//
                    {'name': 'Типы занятий', 'path': '/admin/type_class'},//
                    {'name': 'Остепенеённость преподавателей', 'path': '/admin/degrees_worker'},
                    {'name': 'Должности преподавателей', 'path': '/admin/position_worker'},
                    {'name': 'Ставка преподавателей', 'path': '/admin/rate_worker'},
                    {'name': 'Штатность преподавателей', 'path': '/admin/staff_worker'},
                    {'name': 'Базовое образование преподавателей', 'path': '/admin/trained_worker'},
                ],
            }
        },
        computed:{

        },
        methods:{


        },

        beforeMount() {

        }
    }
</script>

<style lang="scss">
    .page-admin{
        &__column{
            height: calc(100vh - 110px);
            overflow: auto;
        }
    }
</style>