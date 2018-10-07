<template>
    <div class="page_greed">
        <app-allotment-toolbar />
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
                <v-card class="disciplines" v-show="isNotSetings">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Дисциплина</div>
                    </v-toolbar>

                    <v-list two-line class="disciplines_list highest">
                        <template v-for="item in disciplines">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectDiscipline(item.id)"
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

                <v-card class="groups" v-show="isDisciplineSetings">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Группы</div>
                    </v-toolbar>

                    <v-list two-line class="groups_list highest">
                        <template v-for="item in groups">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectGroup(item.id)"
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

                <v-card class="jobs" v-show="(isGroupSetings || isJobSetings)">
                    <v-toolbar class="header white--text">
                        <div class="subheading">Занятия</div>
                    </v-toolbar>

                    <v-list two-line class="jobs_list highest">
                        <template v-for="item in jobs">
                            <v-list-tile
                                    :key="item.id"
                                    @click="selectJob(item.id)"
                                    ripple
                                    v-bind:class="isDistributed(item.dis_hours, item.all_hours)"
                            >
                                <v-list-tile-content>
                                    <v-list-tile-title>{{item.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>Часов распределено: {{ item.dis_hours }}/{{ item.all_hours }}</v-list-tile-sub-title>
                                    <v-list-tile-sub-title v-show="item.employee ? true : false">Преподаватель: {{item.employee ? item.employee.text : ''}}</v-list-tile-sub-title>
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
                        <div v-show="isNotSetings">
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
                                    <h3 class="headline mb-0">{{disciplines[selectedDiscipline] ? disciplines[selectedDiscipline].name : ''}}</h3>
                                    <div><b>Часов всего:</b> {{disciplines[selectedDiscipline] ? disciplines[selectedDiscipline].all_hours : ''}}</div>
                                    <div v-bind:class="disciplines[selectedDiscipline] ? isDistributed(disciplines[selectedDiscipline].dis_hours, disciplines[selectedDiscipline].all_hours) : ''">
                                        <b>Часов распределено:</b> {{disciplines[selectedDiscipline] ? disciplines[selectedDiscipline].dis_hours : ''}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedEmployeeDiscipline"
                                                :items="employees"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>

                                </div>
                            </v-card-title>
                            <v-divider/>
                        </div>

                        <div v-show="isGroupSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{groups[selectedGroup] ? groups[selectedGroup].name : ''}}</h3>
                                    <div><b>Часов всего:</b> {{groups[selectedGroup] ? groups[selectedGroup].all_hours : ''}}</div>
                                    <div v-bind:class="groups[selectedGroup] ? isDistributed(groups[selectedGroup].dis_hours, groups[selectedGroup].all_hours) : ''">
                                        <b>Часов распределено:</b> {{groups[selectedGroup] ? groups[selectedGroup].dis_hours : ''}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedEmployeeGroup"
                                                :items="employees"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>
                                </div>
                            </v-card-title>
                            <v-divider/>
                        </div>

                        <div v-show="isJobSetings">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{jobs[selectedJob] ? jobs[selectedJob].name : ''}}</h3>
                                    <div><b>Часов всего:</b> {{jobs[selectedJob] ? jobs[selectedJob].all_hours : ''}}</div>
                                    <div v-bind:class="jobs[selectedJob] ? isDistributed(jobs[selectedJob].dis_hours, jobs[selectedJob].all_hours) : ''">
                                        <b>Часов распределено:</b> {{jobs[selectedJob] ? jobs[selectedJob].dis_hours : ''}}
                                    </div>
                                    <div v-show="jobs[selectedJob] && jobs[selectedJob].subgroup">
                                        <b>Подгруппа:</b> {{jobs[selectedJob] ? jobs[selectedJob].subgroup : ''}}
                                    </div>

                                    <v-divider/>

                                    <div>
                                        <v-select
                                                v-model="selectedEmployeeJob"
                                                :items="employees"
                                                label="Преподаватель"
                                        ></v-select>
                                        <v-btn color="primary">Назначить</v-btn>
                                    </div>
                                </div>
                            </v-card-title>

                            <v-divider/>

                            <div class="settings__form">

                                <v-combobox
                                        v-model="selectedThread"
                                        :items="threads"
                                        label="Поток"
                                >
                                </v-combobox>
                                <v-combobox
                                        v-model="selectedAuditory"
                                        :items="auditorys"
                                        label="Аудитория"
                                >
                                </v-combobox>
                                <v-checkbox
                                        label="Нужна интерактивная доска"
                                        v-model="selectedNeedIntBoard"
                                ></v-checkbox>
                                <v-checkbox
                                        label="Нужна мультимедийная аудитория"
                                        v-model="selectedNeedMultAuditory"
                                ></v-checkbox>
                                <v-checkbox
                                        label="Нужна маркерная доска"
                                        v-model="selectedNeedMarkBoard"
                                ></v-checkbox>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 1-я неделя до смены расписания"
                                        v-model="selectedHours1WeekBefore"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 2-я неделя до смены расписания"
                                        v-model="selectedHours2WeekBefore"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 1-я неделя после смены расписания"
                                        v-model="selectedHours1WeekAfter"
                                ></v-text-field>
                                <v-text-field
                                        type="number"
                                        label="Кол-во часов 2-я неделя после смены расписания"
                                        v-model="selectedHours2WeekAfter"
                                ></v-text-field>
                                <v-textarea
                                        label="Комметарий"
                                        v-model="selectedComment"
                                ></v-textarea>

                                <v-btn color="success">Сохранить изменения</v-btn>

                            </div>

                            <v-divider/>
                        </div>

                        <v-data-table
                                :headers="headers"
                                :items="peopleData"
                                class="elevation-1"
                                v-show="isGroupSetings || isDisciplineSetings"
                        >
                            <template slot="items" slot-scope="props">
                                <td>{{ props.item.name }}</td>
                                <td>{{ props.item.position }}</td>
                                <td class="text-xs-right">{{ props.item.hours }}</td>
                                <td class="text-xs-right">{{ props.item.part }}</td>
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
    import appAllotmentToolbar from "./appAllotmentToolbar";
    import {mapState, mapMutations} from 'vuex';
    export default {
        name: "appHiDiscipline",
        components: {appAllotmentToolbar},
        data: () => ({
            pages:[
                {
                    text:'Дисциплины',
                    disabled: true,
                    page: 0
                },
            ],

            disciplines:{
                121: {id: '121', name: 'Информатика 1', all_hours: 64, dis_hours: 32},
                122: {id: '122', name: 'Информатика 2', all_hours: 64, dis_hours: 64},
                123: {id: '123', name: 'Информатика 3', all_hours: 64, dis_hours: 72},
                124: {id: '124', name: 'Информатика 4', all_hours: 64, dis_hours: 32},
                125: {id: '125', name: 'Информатика 5', all_hours: 64, dis_hours: 32},
                126: {id: '126', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                127: {id: '127', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                128: {id: '128', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                129: {id: '129', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                130: {id: '130', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                131: {id: '131', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                132: {id: '132', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                133: {id: '133', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                134: {id: '134', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                135: {id: '135', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                136: {id: '136', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                137: {id: '137', name: 'Информатика 6', all_hours: 64, dis_hours: 32},
                138: {id: '138', name: 'Информатика 6', all_hours: 64, dis_hours: 32},

            },

            groups:{
                121: {id: '121', name: 'АСУ 1', all_hours: 64, dis_hours: 32},
                122: {id: '122', name: 'АСУ 2', all_hours: 64, dis_hours: 64},
                123: {id: '123', name: 'АСУ 3', all_hours: 64, dis_hours: 72},
                124: {id: '124', name: 'АСУ 4', all_hours: 64, dis_hours: 32},
                125: {id: '125', name: 'АСУ 5', all_hours: 64, dis_hours: 32},
                126: {id: '126', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                127: {id: '127', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                128: {id: '128', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                129: {id: '129', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                130: {id: '130', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                131: {id: '131', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                132: {id: '132', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                133: {id: '133', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                134: {id: '134', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                135: {id: '135', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                136: {id: '136', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                137: {id: '137', name: 'АСУ 6', all_hours: 64, dis_hours: 32},
                138: {id: '138', name: 'АСУ 6', all_hours: 64, dis_hours: 32},

            },

            jobs:{
                121: {
                    id: '121',
                    name: 'Лекция 1',
                    all_hours: 64,
                    dis_hours: 32,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,

                    employee:{
                        text:'Иван Иванов 1',
                        value: 1
                    }

                },
                122: {
                    id: '122',
                    name: 'Лекция 2',
                    all_hours: 64,
                    dis_hours: 64,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee:{
                        text:'Иван Иванов 1',
                        value: 1
                    }
                },
                123: {
                    id: '123',
                    name: 'Лекция 3',
                    all_hours: 64,
                    dis_hours: 72,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee:{
                        text:'Иван Иванов 1',
                        value: 1
                    }
                },
                124: {
                    id: '124',
                    name: 'Лекция 4',
                    all_hours: 64,
                    dis_hours: 32,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee:{
                        text:'Иван Иванов 1',
                        value: 1
                    }
                },
                125: {
                    id: '125',
                    name: 'Лекция 5',
                    all_hours: 64,
                    dis_hours: 32,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee: null
                },
                126: {
                    id: '126',
                    name: 'Лекция 6',
                    all_hours: 64,
                    dis_hours: 32,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee: null
                },
                127: {
                    id: '127',
                    name: 'Лекция 6',
                    all_hours: 64,
                    dis_hours: 32,
                    auditory: '404',
                    thread: null,
                    subgroup: null,
                    needIntBoard: false,
                    needMultAuditory: false,
                    needMarkBoard: false,
                    comment: null,
                    hours1WeekBefore: null,
                    hours1WeekAfter: null,
                    hours2WeekBefore: null,
                    hours2WeekAfter: null,
                    employee: null
                },
            },

            headers: [
                {
                    text: 'Преподаватель',
                    align: 'left',
                    sortable: false,
                    value: 'name'
                },
                { text: 'Должность', value: 'position' },
                { text: 'Часов', value: 'hours' },
                { text: 'Доля', value: 'part' }
            ],

            employees:[
                {
                    text:'Иван Иванов 1',
                    value: 1
                },
                {
                    text:'Иван Иванов 2',
                    value: 2
                },
                {
                    text:'Иван Иванов 3',
                    value: 3
                },
            ],

            peopleData:[
                {
                    value: false,
                    name: 'Иван Иванов 1',
                    position: 'Профессор',
                    hours: 4,
                    part: '1%'
                },
                {
                    value: false,
                    name: 'Иван Иванов 2',
                    position: 'Профессор',
                    hours: 4,
                    part: '1%'
                },
                {
                    value: false,
                    name: 'Иван Иванов 3',
                    position: 'Профессор',
                    hours: 4,
                    part: '1%'
                },
                {
                    value: false,
                    name: 'Иван Иванов 4',
                    position: 'Профессор',
                    hours: 4,
                    part: '1%'
                },
            ],

            selectedDiscipline: null,
            selectedGroup: null,
            selectedJob: null,

            isNotSetings: true,
            isDisciplineSetings: false,
            isGroupSetings: false,
            isJobSetings: false,

            selectedEmployeeDiscipline: null,
            selectedEmployeeGroup: null,
            selectedEmployeeJob: null,

            threads:[
               'Поток 1', 'Поток 2', 'Поток 3'
            ],

            selectedThread: null,

            auditorys:[
                'Аудитория 1', 'Аудитория 2', 'Аудитория 3'
            ],

            selectedAuditory: null,

            selectedNeedIntBoard: null,
            selectedNeedMultAuditory: null,
            selectedNeedMarkBoard: null,
            selectedHours1WeekBefore: null,
            selectedHours2WeekBefore: null,
            selectedHours1WeekAfter: null,
            selectedHours2WeekAfter: null,
            selectedComment: null,

        }),
        computed:{
            ...mapState([
                'isPageLoaderShow',
                'currentPage'
            ])
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
            selectDiscipline(id){
                this.selectedDiscipline = id;

                this.isNotSetings = false;
                this.isDisciplineSetings = true;
                this.isGroupSetings = false;
                this.isJobSetings = false;

                this.pages[this.pages.length - 1].disabled = false;
                this.pages.push({
                    text:this.disciplines[id].name,
                    disabled: true,
                    page: 1
                });

                this.selectedEmployeeDiscipline = null;
                this.selectedEmployeeGroup = null;
                this.selectedEmployeeJob = null;

            },
            selectGroup(id){
                this.selectedGroup = id;

                this.isNotSetings = false;
                this.isDisciplineSetings = false;
                this.isGroupSetings = true;
                this.isJobSetings = false;

                this.pages[this.pages.length - 1].disabled = false;
                this.pages.push({
                    text:this.groups[id].name,
                    disabled: true,
                    page: 2
                });

                this.selectedEmployeeDiscipline = null;
                this.selectedEmployeeGroup = null;
                this.selectedEmployeeJob = null;
            },
            selectJob(id){
                this.selectedJob = id;

                this.isNotSetings = false;
                this.isDisciplineSetings = false;
                this.isGroupSetings = false;
                this.isJobSetings = true;

                if (this.pages.length != 4) {
                    this.pages[this.pages.length - 1].disabled = false;
                    this.pages.push({
                        text: this.jobs[id].name,
                        disabled: true,
                        page: 3
                    });
                }
                else {
                    this.pages[this.pages.length - 1].text = this.jobs[id].name;
                }

                this.selectedEmployeeDiscipline = null;
                this.selectedEmployeeGroup = null;
                this.selectedEmployeeJob = null;
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
                        this.isJobSetings = false;
                        break;
                    case 1:
                        this.isNotSetings = false;
                        this.isDisciplineSetings = true;
                        this.isGroupSetings = false;
                        this.isJobSetings = false;
                        break;
                    case 2:
                        this.isNotSetings = false;
                        this.isDisciplineSetings = false;
                        this.isGroupSetings = true;
                        this.isJobSetings = false;
                        break;
                }

                this.selectedEmployeeDiscipline = null;
                this.selectedEmployeeGroup = null;
                this.selectedEmployeeJob = null;
            },

            ...mapMutations([
                'setPageLoader',
                'removePageLoader',
                'setData'
            ]),
        }
    }
</script>

<style src="../assets/sass/components/appPageHiDiscipline.scss" lang="scss"/>