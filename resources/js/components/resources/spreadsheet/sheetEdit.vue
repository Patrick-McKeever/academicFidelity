<template>
    <div v-if = "userId == sheetInfo['ownerId']">
        <div id = "handsOnTableContainer"></div>
        <i class="fas fa-save saveButton" v-on:click = "saveSheet()"></i>
    </div>
    <div v-else>
        <p class = "mainBoxText">Only the owner can edit.</p>
    </div>
</template>

<script>
import '@handsontable/vue';
import Handsontable from "handsontable";
//Allow user to edit spreadsheet.
export default {
    name: "sheetEdit",
    data() {
        return {
            //Will contain tests for this spreadsheet.
            sheetInfo: {},
            //Students in this class who are given scores on tests.
            students: {},
            //Will be filled with results of axios req.
            //Will be of form json[testId][studentId] = value.
            sheetVals: {},
            //Widget for spreadsheet
            handsOnTableInst: null,
            //Settings for sheet.
            hotSettings: {
                //sheetData[rowId][columnId] = value;
                data: null,
                colHeaders: [],
                rowHeaders: [],
                rowHeaderWidth: 180,
            },
            hotInst: null,
            userId: null
        }
    },
    methods: {
        //Put data into the hands on table widget.
        mountHOT() {
            //Make data multidim arr to pass to widget such that data[rowInd][columnInd] = value.
            var data = [];

            //Conserves resources to do this only once as opposed to inside inner loop.
            for(var k = 0; k < this.sheetInfo['tests'].length; k++) {
                this.hotSettings['colHeaders'].push(this.sheetInfo['tests'][k]['name']);
            }

            for(var i = 0; i < this.students.length; i++) {
                //This is the array that will contain each test score for the given student.
                this.hotSettings['rowHeaders'].push(this.students[i]['name']);
                var testScores = []

                for(var j = 0; j < this.sheetInfo['tests'].length; j++) {
                    var studentId = this.students[i]['id']
                    var testId = this.sheetInfo['tests'][j]['id']

                    try {
                        var testScore = this.sheetVals[studentId][testId]
                        testScores.push(testScore);
                    }
                    //If score is not defined at this point.
                    catch(err) {
                        testScores.push('');
                    }
                }
                data.push(testScores);
            }

            this.hotSettings['data'] = data;

            var cont = document.getElementById('handsOnTableContainer');
            this.hotInst = new Handsontable(cont, this.hotSettings)
        },

        //get sheetInfo and sheetVals.
        getAttrs() {
            var sheetId = this.$route.params.id;

            //For perms.
            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });

            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data

                //This has to be done inside the promise, because otherwise it would fire before we know classId.
                axios.get('/class/' + response.data['classId']).then((response) => {
                    this.students = response.data['students']

                    //Get spreadsheet vals, restructure to form of json[testId][studentId]
                    axios.get('/spreadsheetValue/' + sheetId).then((response) => {
                        let rawData = response.data

                        //Gotta define outer index as object to avoid undefined in secondary loop.
                        for(var i = 0; i < rawData.length; i++) {
                            this.sheetVals[rawData[i]['studentId']] = {}
                        }

                        for(var i = 0; i < rawData.length; i ++) {
                            this.sheetVals[rawData[i]['studentId']][rawData[i]['testId']] = rawData[i]['value']
                        }

                        //Since mounting the HOT requires various attrs to be set, we call it inside getAttrs().
                        this.mountHOT()
                    }).catch((errors) => {
                        console.log(errors)
                    });
                }).catch((errors) => {
                    console.log(errors)
                });
            }).catch((errors) => {
                console.log(errors)
            });
        },
        saveSheet() {
            var sheetData = this.hotInst.getData();
            axios.post('/spreadsheetValue', {
                data: sheetData,
                sheetId: this.$route.params.id
            });
        }
    },
    mounted() {
        this.getAttrs()
    }
}
</script>
