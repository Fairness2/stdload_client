<template>
    <v-app>
        <div class="page">
            <div class="page_header">
                <app-header></app-header>
            </div>
            <div class="page_body">

                <app-page-loader v-show="isPageLoaderShow" />

                <component :is="getCurrentComponent"/>

            </div>
        </div>
    </v-app>
</template>

<script>
    import appHeader from './appHeader';
    import {mapState, mapActions} from 'vuex';
    import AppPageLoader from "./appPageLoader";
    import appPageAllotments from './appPageAllotments';

    export default {
        name: "appMain",
        components:{
            AppPageLoader,
            appHeader,
            appPageAllotments
        },
        computed:{
            getCurrentComponent(){
                let page = this.currentPage,
                    component = '',
                    componentsList = this.$options.components;

                if(page) component = `appPage${page[0].toUpperCase() + page.slice(1)}`;

                return componentsList[component] ? component : 'appPageAllotments';
            },

            ...mapState([
                'isPageLoaderShow',
                'currentPage'
            ])
        },
        methods:{
            logOut(){
                debugger
            }
        }
    }
</script>

<style src="../assets/sass/components/appMain.scss" lang="scss"/>