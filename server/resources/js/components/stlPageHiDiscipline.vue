<template>
    <div class="page_greed">
        <stl-allotment-toolbar></stl-allotment-toolbar>
        <div>
            <v-breadcrumbs>
                <v-icon slot="divider">chevron_right</v-icon>
                <v-breadcrumbs-item
                        v-for="item in pages"
                        :key="item.text"
                        :disabled="item.disabled"
                >
                    <span @click="clickNavMenu(item.page)">{{ item.text }}</span>
                </v-breadcrumbs-item>
            </v-breadcrumbs>
        </div>

        <v-layout row fill-height >

            <v-flex xs12 sm4>
                <v-card class="disciplines" v-if="isNotSetings">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Дисциплина</div>
                    </v-toolbar>

                    <v-list two-line class="disciplines_list highest">
                        <template v-for="item in $store.state.disciplines">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectDiscipline(item)"
                                    ripple
                                    v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                            >
                                <v-list-tile-content>
                                    <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-divider/>
                        </template>
                    </v-list>
                </v-card>

                <v-card class="groups" v-if="isDisciplineSetings">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Группы</div>
                    </v-toolbar>

                    <v-list two-line class="groups_list highest">
                        <template v-for="item in $store.state.groups">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectGroup(item)"
                                    ripple
                                    v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                            >
                                <v-list-tile-content>
                                    <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-divider/>
                        </template>
                    </v-list>
                </v-card>

                <v-card class="jobs" v-if="(isGroupSetings || isLoadElementSetings)">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Занятия</div>
                    </v-toolbar>

                    <v-list two-line class="jobs_list highest">
                        <template v-for="item in $store.state.loadElements">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectLoadElement(item)"
                                    ripple
                                    v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                            >
                                <v-list-tile-content>
                                    <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
                                    <v-list-tile-sub-title v-if="item.worker ? true : false">Преподаватель: {{item.worker_fio}}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-divider/>
                        </template>
                    </v-list>
                </v-card>

            </v-flex>

            <v-spacer/>

            <v-flex xs12 sm8>
                <v-card class="settings">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Настройки</div>
                    </v-toolbar>

                    <div class="settings__highest">
                        <div v-if="isNotSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Тут ничего нет</h3>
                                    <div>Чтобы начать работу начните продвигаться по иерархии</div>
                                </div>
                            </v-card-title>
                        </div>

                        <div v-show="isDisciplineSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{$store.state.currentDicipline.name}}</h3>
                                    <div><b>Часов всего:</b> {{$store.state.currentDicipline.all_hours}}</div>
                                    <div v-bind:class="isDistributed($store.state.currentDicipline.dis_hours, $store.state.currentDicipline.all_hours)">
                                        <b>Часов распределено:</b> {{$store.state.currentDicipline.dis_hours}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedWorkerModel"
                                                :items="$store.state.workers"
                                                item-value="id"
                                                item-text="fio"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>

                                </div>
                            </v-card-title>
                            <v-divider/>
                        </div>

                        <div v-if="isGroupSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{$store.state.currentGroup.name}}</h3>
                                    <div><b>Часов всего:</b> {{$store.state.currentGroup.all_hours}}</div>
                                    <div v-bind:class="isDistributed($store.state.currentGroup.dis_hours, $store.state.currentGroup.all_hours)">
                                        <b>Часов распределено:</b> {{$store.state.currentGroup.dis_hours}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedWorkerModel"
                                                :items="$store.state.workers"
                                                item-value="id"
                                                item-text="fio"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>
                                </div>
                            </v-card-title>
                            <v-divider/>
                        </div>

                        <div v-if="isLoadElementSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{$store.state.currentLoadElement.name}}</h3>
                                    <div><b>Часов всего:</b> {{$store.state.currentLoadElement.all_hours}}</div>
                                    <div v-bind:class="isDistributed($store.state.currentLoadElement.dis_hours, $store.state.currentLoadElement.all_hours)">
                                        <b>Часов распределено:</b> {{$store.state.currentLoadElement.dis_hours}}
                                    </div>
                                    <div v-if="$store.state.currentLoadElement.subgroup">
                                        <b>Подгруппа:</b> {{$store.state.currentLoadElement.subgroup}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedWorkerModel"
                                                :items="$store.state.workers"
                                                item-value="id"
                                                item-text="fio"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>
                                </div>
                            </v-card-title>

                            <v-divider/>

                            <div class="settings__form">

                                <v-combobox
                                        v-model="selectedThreadModel"
                                        :items="$store.state.threads"
                                        label="Поток"
                                >
                                </v-combobox>
                                <v-combobox
                                        v-model="selectedAuditoryModel"
                                        :items="$store.state.auditorys"
                                        label="Аудитория"
                                >
                                </v-combobox>
                                <v-checkbox
                                        label="Нужна интерактивная доска"
                                        v-model="selectedNeedIntBoardModel"
                                ></v-checkbox>
                                <v-checkbox
                                        label="Нужна мультимедийная аудитория"
                                        v-model="selectedNeedMultAuditoryModel"
                                ></v-checkbox>
                                <v-checkbox
                                        label="Нужна маркерная доска"
                                        v-model="selectedNeedMarkBoardModel"
                                ></v-checkbox>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 1-я неделя до смены расписания"
                                        v-model="selectedHours1WeekBeforeModel"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 2-я неделя до смены расписания"
                                        v-model="selectedHours2WeekBeforeModel"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 1-я неделя после смены расписания"
                                        v-model="selectedHours1WeekAfterModel"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 2-я неделя после смены расписания"
                                        v-model="selectedHours2WeekAfterModel"
                                ></v-text-field>
                                <v-textarea
                                        label="Комметарий"
                                        v-model="selectedCommentModel"
                                ></v-textarea>

                                <v-btn color="success">Сохранить изменения</v-btn>

                            </div>

                            <v-divider/>
                        </div>

                        <v-data-table
                                :headers="$store.state.headers"
                                :items="$store.state.peopleData"
                                class="elevation-1"
                                v-show="isGroupSetings || isDisciplineSetings"
                        >
                            <template slot="items" slot-scope="props">
                                <td>{{ props.item.fio }}</td>
                                <td class="text-xs-right">{{ props.item.group }}</td>
                                <td class="text-xs-right">{{ props.item.type_class }}</td>
                            </template>
                            <template slot="no-data">
                                    Нет назначенных преподавателей
                            </template>
                        </v-data-table>
                    </div>
                </v-card>
            </v-flex>
        </v-layout>
    </div>


</template>

<script>
    import StlAllotmentToolbar from "./stlAllotmentToolbar";

    export default {
        name: "stlHiDiscipline",
        components: {StlAllotmentToolbar},
        data: () => ({
            pages:[
                {
                    text:'Дисциплины',
                    disabled: true,
                    page: 0
                },
            ],

            isNotSetings: true,
            isDisciplineSetings: false,
            isGroupSetings: false,
            isLoadElementSetings: false,

        }),
        computed:{
            selectedCommentModel: {
                get() {
                    return this.$store.state.currentLoadElement.comment;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{comment: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedHours2WeekAfterModel: {
                get() {
                    return this.$store.state.currentLoadElement.hours_second_after;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{hours_second_after: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedHours1WeekAfterModel: {
                get() {
                    return this.$store.state.currentLoadElement.fours_first_after;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{fours_first_after: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedHours2WeekBeforeModel: {
                get() {
                    return this.$store.state.currentLoadElement.hours_second_befor;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{hours_second_befor: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedHours1WeekBeforeModel: {
                get() {
                    return this.$store.state.currentLoadElement.hours_first_before;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{hours_first_before: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedNeedMarkBoardModel: {
                get() {
                    return this.$store.state.currentLoadElement.need_marker_board;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{need_marker_board: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedNeedMultAuditoryModel: {
                get() {
                    return this.$store.state.currentLoadElement.need_multimedia_classroom;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{need_multimedia_classroom: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },
            selectedNeedIntBoardModel: {
                get() {
                    return this.$store.state.currentLoadElement.need_interactive_board;
                },

                set(value) {
                    value = {...this.$store.state.currentLoadElement, ...{need_interactive_board: value}};
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },

            currentDiciplineModel: {
                get() {
                    return this.$store.state.currentDicipline;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentDicipline', value});
                }
            },

            selectedWorkerModel: {
                get() {
                    return this.$store.state.currentWorker;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentWorker', value});
                }
            },

            currentGroupModel: {
                get() {
                    return this.$store.state.currentGroup;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentGroup', value});
                }
            },

            currentLoadElementModel: {
                get() {
                    return this.$store.state.currentLoadElement;
                },

                set(value) {
                    this.$store.commit('setData', {path: 'currentLoadElement', value});
                }
            },

        },
        methods:{
            isDistributed(dis_hours, all_hours){
                if (dis_hours < all_hours) {
                    return 'dis_complite_not';
                }
                else if (dis_hours == all_hours){
                    return 'dis_complite';
                }
                else if (dis_hours > all_hours){
                    return 'dis_complite_error';
                }
                return '';
            },
            selectDiscipline(item){
                this.currentDiciplineModel = item;

                this.isNotSetings = false;
                this.isDisciplineSetings = true;
                this.isGroupSetings = false;
                this.isLoadElementSetings = false;

                this.pages[this.pages.length - 1].disabled = false;
                this.pages.push({
                    text:item.name,
                    disabled: true,
                    page: 1
                });

                this.selectedWorkerModel = {};

                this.$store.dispatch('updateHiDisciplineGroup');

            },
            selectGroup(item){
                this.currentGroupModel = item;

                this.isNotSetings = false;
                this.isDisciplineSetings = false;
                this.isGroupSetings = true;
                this.isLoadElementSetings = false;

                this.pages[this.pages.length - 1].disabled = false;
                this.pages.push({
                    text:item.name,
                    disabled: true,
                    page: 2
                });

                this.selectedWorkerModel = {};

                this.$store.dispatch('updateHiDisciplineLoadElements');
            },
            selectJob(item){
                this.currentLoadElementModel = item;

                this.isNotSetings = false;
                this.isDisciplineSetings = false;
                this.isGroupSetings = false;
                this.isLoadElementSetings = true;

                if (this.pages.length != 4) {
                    this.pages[this.pages.length - 1].disabled = false;
                    this.pages.push({
                        text: item.name,
                        disabled: true,
                        page: 3
                    });
                }
                else {
                    this.pages[this.pages.length - 1].text = item.name;
                }

                this.selectedWorkerModel = {};

                this.$store.dispatch('updateHiDisciplineLoadElement');
            },

            clickNavMenu(page){
                for (let i = this.pages.length - 1; i > page; i--){
                    this.pages.pop();
                }
                switch (page) {
                    case 0:
                        this.isNotSetings = true;
                        this.isDisciplineSetings = false;
                        this.isGroupSetings = false;
                        this.isLoadElementSetings = false;
                        break;
                    case 1:
                        this.isNotSetings = false;
                        this.isDisciplineSetings = true;
                        this.isGroupSetings = false;
                        this.isLoadElementSetings = false;
                        break;
                    case 2:
                        this.isNotSetings = false;
                        this.isDisciplineSetings = false;
                        this.isGroupSetings = true;
                        this.isLoadElementSetings = false;
                        break;
                }

                this.selectedWorkerModel = {};
            },
            init(){
                this.updateHiDiscipline();
            },
            updateHiDiscipline(){
                this.$store.dispatch('updateHiDiscipline');
            },
        },

        beforeMount() {
            this.init();
        }

    }
</script>

<style> </style>