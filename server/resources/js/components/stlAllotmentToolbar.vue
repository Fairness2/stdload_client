<template>
    <v-layout row fill-height  class="allotment_toolbox">
        <div class="allotment_toolbox__element">
            <router-link :to="{name: 'homePage'}">
                <v-btn outline color="primary" title="К распределениям">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
            </router-link>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="$store.state.dimensions"
                    label="Представление"
                    v-model="currentDimensionModel"
                    outline
                    single-line
            ></v-select>
        </div>
        <div class="dimensions allotment_toolbox__element">
            <v-select
                    color="primary"
                    :items="$store.state.semesters"
                    label="Семестр"
                    v-model="currentSemesterModel"
                    outline
                    single-line
            ></v-select>
        </div>
        <v-spacer/>
        <div class="allotment_toolbox__element">
            <v-dialog v-model="showAutomaticDistribution" width="500">
                <v-btn outline slot="activator" color="primary" title="Поставить на автоматическое распределение">
                    <v-icon>play_circle_outline</v-icon>
                </v-btn>

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Настройки автоматического распределения
                    </v-card-title>

                    <v-card-text>

                        <v-text-field max="1" min="0" type="number" v-model="coefWeight.old" label="Вес коэффициента наследственности" />
                        <v-text-field max="1" min="0" type="number" v-model="coefWeight.worker" label="Вес коэффициента предпочтения преподавателей" />
                        <v-text-field max="1" min="0" type="number" v-model="coefWeight.kaf" label="Вес коэффициента предпочтения кафедры" />
                        <v-select
                                color="primary"
                                :items="methods"
                                label="Метод"
                                v-model="selectMethod"
                        ></v-select>

                        <v-alert
                                :value="isNotSuccessDistribution === true"
                                type="warning"
                                transition="scale-transition"
                                outline
                        >
                            Распределить автоматически не удалось
                        </v-alert>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn @click="automaticDistribution()"
                                color="success"
                                flat
                        >
                            Распределить
                        </v-btn>

                        <v-btn
                                color=""
                                flat
                                @click="showAutomaticDistribution = false"
                        >
                            Отмена
                        </v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </div>
        <div class="allotment_toolbox__element">
            <v-dialog v-model="showCheckAllotment" width="500">
                <v-btn outline slot="activator" color="primary" title="Учесть в коэффициентах наследственности">
                    <v-icon>check_circle_outline</v-icon>
                </v-btn>

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Учесть в коэффициентах наследственности
                    </v-card-title>

                    <v-card-text>
                        <v-alert
                                :value="isSuccessCheckAllotment === true"
                                type="success"
                                transition="scale-transition"
                                outline
                        >
                            Распределение учтено.
                        </v-alert>
                        <v-alert
                                :value="isSuccessCheckAllotment === false"
                                type="warning"
                                transition="scale-transition"
                                outline
                        >
                            Распределение учесть не удалось.
                        </v-alert>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn @click="checkAllotment()"
                               color="success"
                               flat
                        >
                            Учесть
                        </v-btn>

                        <v-btn
                                color=""
                                flat
                                @click="showCheckAllotment = false"
                        >
                            Отмена
                        </v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </div>
        <div class="allotment_toolbox__element">
            <v-dialog v-model="showDownloadInFile" width="500">
                <v-btn outline slot="activator" color="primary" title="Выгрузить в файл">
                    <v-icon>cloud_download</v-icon>
                </v-btn>

                <v-card>
                    <form method="post" action="/allotments/download_allotment" enctype="multipart/form-data">
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            Выберите файл
                        </v-card-title>

                        <v-card-text>

                            <input type="hidden" name="_token" :value="$store.getters.csrf">
                            <input type="hidden" name="allotment_id" :value="$store.state.currentAllotment.id" required>
                            <input type="file" name="file" required>
                            <input type="hidden" name="semester" :value="selectSemester" required>
                            <v-select
                                    color="primary"
                                    :items="$store.state.semesters"
                                    label="Семестр"
                                    v-model="selectSemester"
                            ></v-select>
                            <input type="hidden" name="update_workers" :value="updateWorkers">
                            <v-checkbox
                                    v-model="updateWorkers"
                                    label="Добавить недостающих преподавателей (максимум 10)"
                            ></v-checkbox>

                        </v-card-text>

                        <v-card-actions>
                            <v-btn
                                    color="success"
                                    flat
                                    type="submit"
                            >
                                Загрузить
                            </v-btn>

                            <v-btn
                                    color=""
                                    flat
                                    @click="showDownloadInFile = false"
                            >
                                Отмена
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card>
            </v-dialog>
        </div>
        <div class="allotment_toolbox__element">

            <v-dialog v-model="showLoadInFile" width="500">
                <v-btn slot="activator" outline color="primary" title="Загрузить из файла">
                    <v-icon>cloud_upload</v-icon>
                </v-btn>

                <v-card>
                    <form method="post" action="/allotments/load_allotment" enctype="multipart/form-data">
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            Выберите файл
                        </v-card-title>

                        <v-card-text>

                            <input type="hidden" name="_token" :value="$store.getters.csrf">
                            <input type="hidden" name="allotment_id" :value="$store.state.currentAllotment.id" required>
                            <input type="file" name="file" required>
                            <input type="hidden" name="semester" :value="selectSemester" required>
                            <v-select
                                    color="primary"
                                    :items="$store.state.semesters"
                                    label="Семестр"
                                    v-model="selectSemester"
                            ></v-select>
                            <input type="hidden" name="update_workers" :value="updateWorkers">
                            <v-checkbox
                                    v-model="updateWorkers"
                                    label="Обновить преподавателей"
                            ></v-checkbox>

                        </v-card-text>

                        <v-card-actions>
                            <v-btn
                                    color="success"
                                    flat
                                    type="submit"
                            >
                                Загрузить
                            </v-btn>

                            <v-btn
                                    color=""
                                    flat
                                    @click="showLoadInFile = false"
                            >
                                Отмена
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card>

            </v-dialog>
        </div>
        <div class="allotment_toolbox__element">

            <v-dialog v-model="showReports" width="500">
                <v-btn slot="activator"  outline color="primary" title="Отчёты">
                    <v-icon>assignment</v-icon>
                </v-btn>

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Выберите отчёт
                    </v-card-title>

                    <v-card-text>
                        <div>
                            <v-select
                                    v-model="selectedWorker"
                                    :items="$store.state.workers"
                                    item-value="id"
                                    item-text="fio"
                                    label="Преподаватель"
                            ></v-select>
                            <v-checkbox
                                    label="Заочные"
                                    v-model="selectedExtramural"
                            ></v-checkbox>
                            <v-btn
                                    :disabled="selectedWorker == null"
                                    color=""
                                    flat
                                    @click="getIndividualReport"
                            >
                                Индивидуальная нагрузка
                            </v-btn>
                        </div>


                    </v-card-text>

                    <v-card-actions>
                        <v-btn
                                color=""
                                flat
                                @click="showReports = false"
                        >
                            Отмена
                        </v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </div>
        <div class="outline">
            <v-card-text><b class="text--primary">Распределение: {{$store.state.currentAllotment.name}}</b></v-card-text>
        </div>
    </v-layout>
</template>

<script>


    export default {
        name: "StlAllotmentToolbar",
        components: {},
        props:[],
        data: () => ({
            showLoadInFile: false,
            showDownloadInFile: false,
            showAutomaticDistribution: false,
            showReports: false,
            selectSemester: 3,
            updateWorkers: false,

            coefWeight: {
                'old': 1,
                'worker': 1,
                'kaf': 1
            },
            methods: [
                { text: 'Метод ветвей и границ', value: 1 },
                { text: 'Двойственный симплекс метод', value: 2 },
                { text: 'Метод внутреней точки', value: 3 },
            ],
            selectMethod: 1,
            isNotSuccessDistribution: false,
            isSuccessCheck: false,
            showCheckAllotment: false,
            isSuccessCheckAllotment: null,

            selectedWorker: null,
            selectedExtramural: false,
        }),
        computed:{
            currentSemesterModel: {
                get() {
                    return this.$store.state.currentSemester;
                },

                set(value) {
                    if (this.$store.state.currentSemester != value) {
                        this.$store.commit('setData', {path: 'currentSemester', value});
                        this.$store.dispatch('changeSemester');
                    }
                }
            },
            currentDimensionModel: {
                get() {
                    return this.$store.state.currentDimension;
                },

                set(value) {
                    if (this.$store.state.currentDimension != value) {
                        this.$store.commit('setData', {path: 'currentDimension', value});
                        if (value == 1){
                            this.$route.push({name: 'hiDiscipline', params: {id: this.$store.state.currentAllotment.id}});
                        }
                        else if (value == 2){
                            this.$route.push({name: 'StlPageHiEmployee', params: {id: this.$store.state.currentAllotment.id}});
                        }
                        else if (value == 3){
                            this.$route.push({name: 'StlPageHiGroup', params: {id: this.$store.state.currentAllotment.id}});
                        }
                        //this.$store.dispatch('changeDimension');
                    }
                }
            },
        },

        watch:{

        },

        methods:{
            async automaticDistribution(){
                let params = {
                    'method': this.selectMethod,
                    'weight_old': this.coefWeight.old,
                    'weight_worker': this.coefWeight.worker,
                    'weight_kaf': this.coefWeight.kaf,
                    'allotment': this.$store.state.currentAllotment.id
                };
                let status = await this.$store.dispatch('automaticDistribution', params);
                if (status){
                    if (this.$store.state.currentDimension == 1){
                        this.$route.push({name: 'hiDiscipline', params: {id: this.$store.state.currentAllotment.id}});
                    }
                    else if (this.$store.state.currentDimension == 2){
                        this.$route.push({name: 'StlPageHiEmployee', params: {id: this.$store.state.currentAllotment.id}});
                    }
                    else if (this.$store.state.currentDimension == 3){
                        this.$route.push({name: 'StlPageHiGroup', params: {id: this.$store.state.currentAllotment.id}});
                    }
                }
                else{
                    this.isNotSuccessDistribution = true;
                }
            },
            async checkAllotment(){
                let params = {
                    'allotment': this.$store.state.currentAllotment.id
                };
                let status = await this.$store.dispatch('checkAllotment', params);
                if (status){
                    this.isSuccessCheckAllotment = true;
                }
                else{
                    this.isSuccessCheckAllotment = false;
                }
            },
            getIndividualReport(){
                window.open(`/reports/individual?allotment=${this.$store.state.currentAllotment.id}&worker=${this.selectedWorker}&group_type=${this.selectedExtramural ? encodeURIComponent('extramural') : encodeURIComponent('full-time')}`)
            }
        },

        beforeMount (){

        }
    }
</script>

<style lang="scss">
.allotment_toolbox{
    height: 50px;
}
</style>