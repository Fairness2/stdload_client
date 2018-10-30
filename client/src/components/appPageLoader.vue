<template>
    <div class="page_loader">
        <div class="page_loader_outer">
            <v-progress-circular class="page_loader_inner"
                    :size="100"
                    :width="7"
                    color="primary"
                    indeterminate
            />
        </div>
    </div>
</template>

<script>
    export default {
        name: "appPageLoader"
    }
</script>

<style src="../assets/sass/components/appPageLoader.scss" lang="scss"/>