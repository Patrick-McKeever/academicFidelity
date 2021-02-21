import createClass from "./components/resources/class/createClass";
import updateClass from "./components/resources/class/updateClass";

import createStudent from "./components/resources/student/createStudent";
import updateStudent from "./components/resources/student/updateStudent";
import deleteStudent from "./components/resources/student/deleteStudent";
import studentPerformance from "./components/resources/student/studentPerformance";

import createSpreadsheet from "./components/resources/spreadsheet/createSpreadsheet";
import updateSpreadsheet from "./components/resources/spreadsheet/updateSpreadsheet";
import deleteSpreadsheet from "./components/resources/spreadsheet/deleteSpreadsheet";

import createStandard from "./components/resources/standard/createStandard";
import createStandardGroup from "./components/resources/standard/createStandardGroup";
import deleteStandard from "./components/resources/standard/deleteStandard";
import pickStandard from "./components/resources/standard/pickStandard";
import writeStandard from "./components/resources/standard/writeStandard";
import groupBasedStandard from "./components/resources/standard/groupBasedStandard";

import createSlg from "./components/resources/slgs/createSlg";
import editSlg from "./components/resources/slgs/editSlg";
import myPastSlgs from "./components/resources/slgs/myPastSlgs";
import groupBasedSlgs from "./components/resources/slgs/groupBasedSlgs";

import createTest from "./components/resources/test/createTest";
import updateTest from "./components/resources/test/updateTest";
import deleteTest from "./components/resources/test/deleteTest";

import groupModal from "./components/resources/group/groupModal";
import createGroup from "./components/resources/group/createGroup";
import joinGroup from "./components/resources/group/joinGroup";
import leaveGroup from "./components/resources/groupMembers/leaveGroup";
import updateGroup from "./components/resources/group/updateGroup";

import shareClass from "./components/resources/sharedClass/shareClass";
import unshareClass from "./components/resources/sharedClass/unshareClass";

import createTeacher from "./components/resources/teacher/createTeacher";
import updateTeacher from "./components/resources/teacher/updateTeacher";

import createEvaluation from "./components/resources/evaluation/createEvaluation";

export default ({
    mode: 'history',
    routes: [
        {
            path: '/classComp/create',
            components: {
                modalView: createClass
            }
        }, {
            path: '/classComp/:classId/update',
            components: {
                modalView: updateClass
            }
        }, {
            //Link to add student to the given class.
            path: '/studentComp/create/:classId',
            components: {
                modalView: createStudent
            }
        }, {
            path: '/studentComp/:studentId/update',
            components: {
                modalView: updateStudent
            }
        }, {
            path: '/studentComp/:studentId/delete',
            components: {
                modalView: deleteStudent
            }
        }, {
            path: '/studentComp/:id/performance',
            components: {
                modalView: studentPerformance
            }
        }, {
            path: '/spreadsheetComp/create/:classId',
            components: {
                modalView: createSpreadsheet
            }
        }, {
            path: '/spreadsheetComp/:spreadsheetId/update',
            components: {
                modalView: updateSpreadsheet
            }
        }, {
            path: '/spreadsheetComp/:spreadsheetId/delete',
            components: {
                modalView: deleteSpreadsheet
            }
        }, {
            path: '/standardComp/create/:id',
            components: {
                modalView: createStandard
            },
            children: [{
                //Pick standard using API.
                path: 'select',
                alias: '',
                component: pickStandard,
                props: {
                    sheet: true
                }
            }, {
                //Write your own standard.
                path: 'manual',
                component: writeStandard,
                props: {
                    sheet: true
                }
            }, {
                //Pick standards based on what has been set by group.
                path: 'groupBased',
                component: groupBasedStandard
            }]
        }, {
            path: '/standardCompGroup/create/:id',
            components: {
                modalView: createStandardGroup
            },
            children: [{
                //Pick standard using API.
                path: 'select',
                alias: '',
                component: pickStandard,
                props: {
                    sheet: false
                }
            }, {
                //Write your own standard.
                path: 'manual',
                component: writeStandard,
                props: {
                    sheet: false
                }
            }]
        }, {
            path: '/slgComp/create/:id',
            components: {
                modalView: createSlg
            },
            children: [{
                //Pick standard using API.
                path: 'edit',
                alias: '',
                component: editSlg,
                props: {
                    sheet: true
                }
            }, {
                //Write your own standard.
                path: 'myPastSlgs',
                component: myPastSlgs
            }, {
                //Pick standards based on what has been set by group.
                path: 'groupBased',
                component: groupBasedSlgs
            }]
        }, {
            path: '/slgCompGroup/create/:id',
            components: {
                modalView: editSlg
            },
        }, {
            path: '/standardComp/delete/:id/:standardIndex/:sheet',
            components: {
                modalView: deleteStandard
            }
        }, {
            path: '/testComp/create/:sheetId',
            components: {
                modalView: createTest
            }
        }, {
            path: '/testComp/:testId/update',
            components: {
                modalView: updateTest
            }
        }, {
            path: '/testComp/:testId/delete',
            components: {
                modalView: deleteTest
            }
        }, {
            path: '/groupComp/create',
            components: {
                modalView: groupModal
            },
            children: [{
                path: 'join',
                alias: '',
                component: joinGroup
            }, {
                path: 'make',
                component: createGroup
            }]
        }, {
            path: '/groupComp/:id/update',
            components: {
                modalView: updateGroup
            }
        }, {
            path: '/sharedClassComp/share/:id',
            components: {
                modalView: shareClass
            }
        }, {
            //Unshare class with id "id" from group with id "groupId".
            path: '/sharedClassComp/:id/delete',
            components: {
                modalView: unshareClass
            }
        }, {
            path: '/leaveGroup/:id',
            components: {
                modalView: leaveGroup
            }
        }, {
            path: '/teacherComp/create',
            components: {
                modalView: createTeacher
            }
        }, {
            path: '/teacherComp/:id/update',
            components: {
                modalView: updateTeacher
            }
        }, {
            path: '/evaluationComp/create/:teacherId/:preObs',
            components: {
                modalView: createEvaluation
            }
        }
    ]
});
