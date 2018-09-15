<template>
    <v-layout row wrap>

        <v-flex xs12 sm6>
            <v-card>
                <v-toolbar class="header white--text">
                    <v-btn color="pink" dark small absolute middle right fab>
                        <v-icon>add</v-icon>
                    </v-btn>
                    <div class="subheading">Распределения</div>
                </v-toolbar>

                <v-list>
                    <v-list-tile
                            v-for="item in allotments"
                            :key="item.id"
                            @click=""
                    >
                        <v-list-tile-content v-bind:class="isDistributed(item.dis_hours, item.all_hours)">
                            <v-list-tile-title>{{item.name}}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>

            </v-card>
        </v-flex>

    </v-layout>
</template>

<script>
    export default {
        name: "appPageAllotments",
        components: {},
        data() {
            return {
                allotments: [
                    {id: '123', name: 'Распределение 1', year:'2017-2018', all_hours: 17, dis_hours: 32}
                ]
            }
        },
        methods:{
            isDistributed(dis_hours, all_hours){
                if (dis_hours < all_hours) {
                    return 'not_complite';
                }
                else if (dis_hours == all_hours){
                    return 'dis_complite';
                }
                else if (dis_hours > all_hours){
                    return 'dis_complite_error';
                }
                return;
            }
        }
    }
</script>

<style src="../assets/sass/components/appPageAllotments.scss" lang="scss"/>