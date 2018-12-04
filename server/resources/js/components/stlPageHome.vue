<template>
    <div class="stl-page">
        <div class="stl-page__content">

            <div class="stl-page__main">
                <router-view name="pageSections"/>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "stlPageHome"
    }
</script>

<style scoped>

</style>