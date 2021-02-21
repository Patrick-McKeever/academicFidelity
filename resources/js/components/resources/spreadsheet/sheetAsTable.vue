<template>
    <div id = "spreadsheetCon">
        <table class = "sheet" id = "spreadSheet" v-if = "sheetInfo['tests'].length">
            <tr class = "sheet">
                <th class = "sheet"></th>
                <th class = "sheet" v-for = "test in sheetInfo['tests']">
                    {{ test['name'] }} ({{ test['date'] }})
                    <table v-if = "userId == sheetInfo['ownerId']">
                        <tr>
                            <td :onclick = "'openModal(\'/testComp/' + test['id'] + '/update\', 1)'">
                                <i class="far fa-edit"></i>
                            </td>
                            <td :onclick = "'openModal(\'/testComp/' + test['id'] + '/delete\', 1)'">
                                <i class="fa fa-window-close" aria-hidden="true"></i>
                            </td>
                        </tr>
                    </table>
                </th>

            </tr>
            <tr class = "sheet" v-for = "student in students">
                <td class = "sheet">{{ student['name'] }}</td>
                <td class = "sheet" v-for = "test in sheetInfo['tests']">
                    <div v-if = "typeof sheetVals[test['id']] !== 'undefined'">
                        {{ sheetVals[test['id']][student['id']] }}
                    </div>
                </td>
            </tr>
        </table>

        <div class = "container" v-else>
            <p class = "containerLabel">Adding Content:</p>
            <ul>
                <li class = "mainBoxText">You have not yet added any tests to this spreadsheet. Use the blue "plus" button in the bottom right to do so.</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "sheetAsTable",
    props: ['sheetId'],
    data() {
        return {
            sheetInfo: {},
            students: {},
            sheetVals: {},
            //For perms.
            userId: null
        }
    },
    methods: {
        //get sheetInfo and sheetVals.
        getAttrs() {
            var sheetId = this.sheetId;

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
                }).catch((errors) => {
                    console.log(errors)
                });
            }).catch((errors) => {
                console.log(errors)
            });

            //Restructure data into format of json[testId][studentId]
            axios.get('/spreadsheetValue/' + sheetId).then((response) => {
                let rawData = response.data

                //Gotta define outer index as object to avoid undefined in secondary loop.
                for(var i = 0; i < rawData.length; i++) {
                    this.sheetVals[rawData[i]['testId']] = {}
                }

                for(var i = 0; i < rawData.length; i ++) {
                    this.sheetVals[rawData[i]['testId']][rawData[i]['studentId']] = rawData[i]['value']
                }
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getAttrs()
    }
}
</script>
