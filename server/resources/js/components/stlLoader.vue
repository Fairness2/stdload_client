<template>
    <div class="stl-loader">
        <div class="stl-loader__content">
            <v-progress-circular
                    :size="70"
                    :width="7"
                    color="primary"
                    indeterminate
            ></v-progress-circular>
            <div class="stl-loader__text">Загрузка</div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "stlLoader"
    }
</script>

<style lang="scss">
    .stl-loader {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;

        background-color: rgba(255,255,255,.8);
        z-index: 9999;

        &__content {
            position: fixed;
            left: 50%;
            top: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px 30px;

            transform: translate(-50%, -50%);

            border-radius: 60px;
            background-color: #fff;

            box-shadow: 0 3px 26px rgba(0, 0, 0, 0.16);
        }

        &__text {
            margin-left: 10px;
            font-size: 15px;
            font-weight: bold;
            white-space: nowrap;

            color: #d3d8db;
            text-transform: uppercase;
        }
    }

</style>