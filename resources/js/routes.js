import classList from './components/resources/class/classList.vue';
import readClass from './components/resources/class/readClass';
import classArchived from './components/resources/class/classArchived';

import readGroup from "./components/resources/group/readGroup";
import groupArchived from "./components/resources/group/groupArchived";
import sharedClassList from "./components/resources/sharedClass/sharedClassList";
import groupMemberList from "./components/resources/groupMembers/groupMemberList";
import groupQuery from "./components/resources/group/groupQuery";
import groupInfo from "./components/resources/group/groupInfo";

import studentList from './components/resources/student/studentList';

import standardProgress from "./components/resources/class/standardProgress";

import spreadsheetList from "./components/resources/spreadsheet/spreadsheetList";
import readSpreadsheet from "./components/resources/spreadsheet/readSpreadsheet";
import sheetView from "./components/resources/spreadsheet/sheetView";
import sheetEdit from "./components/resources/spreadsheet/sheetEdit";
import sheetStats from "./components/resources/spreadsheet/sheetStats";

import readTeacher from "./components/resources/teacher/readTeacher";
import teacherObsList from "./components/resources/evaluation/teacherObsList";
import teacherArchived from "./components/resources/teacher/teacherArchived";
import editObs from "./components/resources/evaluation/editObs";
import editPreObs from "./components/resources/evaluation/editPreObs";
import readObs from "./components/resources/evaluation/readObs";
import readPreObs from "./components/resources/evaluation/readPreObs";

import studentPerformance from "./components/resources/student/studentPerformance";

export default ({
    mode: 'history',
    routes: [
        {
            //Lists classes owned by user.
            path: '/classComp',
            component: classList,
        }, {
            //Main page for specific class.
            path: '/classComp/:id',
            components: {
                navTabView: readClass,
            },
            children: [{
                //List students in class.
                path: 'students',
                alias: '/',
                component: studentList
            }, {
                //Lists spreadsheets in given class.
                path: 'spreadsheets',
                component: spreadsheetList
            }, {
                //How has staff progressed on standards based on spreadsheet data?
                path: 'query',
                component: standardProgress
            }]
        }, {
            //Lists archived classes.
            path: '/classList/archived',
            components: {
                navTabView: classArchived
            }
        }, {
            //Page for group.
            path: '/groupComp/:id',
            components: {
                navTabView: readGroup
            },
            children: [{
                //Classes shared with group.
                path: 'sharedClasses',
                alias: '',
                component: sharedClassList
            }, {
                //List of group members.
                path: 'members',
                component: groupMemberList
            }, {
                //Gives progress on standards in classes shared with group.
                path: 'query',
                component: groupQuery
            }, {
                path: 'info',
                component: groupInfo
            }]
        }, {
            //Lists archived groups.
            path: '/groupList/archived',
            components: {
                navTabView: groupArchived
            }
        }, {
            //main page for a spreadsheet.
            path: '/sheetView/:id',
            components: {
                navTabView: readSpreadsheet
            },
            children: [{
                //Shows standards, SLGs, non-editable value table.
                path: 'view',
                alias: '/',
                component: sheetView
            }, {
                //Allows user to edit spreadsheet
                path: 'edit',
                component: sheetEdit
            }, {
                //Shows summary stats for tests on sheet.
                path: 'stats',
                component: sheetStats
            }]
        }, {
            path: '/teacherComp/:id',
            components: {
                navTabView: readTeacher
            },
            children: [{
                path: 'observations',
                alias: '',
                component: teacherObsList,
                props: {
                    preObs: false
                }
            }, {
                path: 'preObservations',
                component: teacherObsList,
                props: {
                    preObs: true
                }
            }]
        }, {
            path: '/teacherList/archived',
            components: {
                navTabView: teacherArchived
            }
        }, {
            path: '/evaluationComp/obs/:id',
            components: {
                navTabView: editObs
            }
        }, {
            path: '/evaluationComp/preObs/:id',
            components: {
                navTabView: editPreObs
            }
        }, {
            path: '/evaluationComp/:id/readObs',
            components: {
                navTabView: readObs
            }
        }, {
            path: '/evaluationComp/:id/readPreObs',
            components: {
                navTabView: readPreObs
            }
        }, {
            path: '/studentComp/:id/performance',
            components: {
                navTabView: studentPerformance
            }
        }
    ],
    props: 1
});
