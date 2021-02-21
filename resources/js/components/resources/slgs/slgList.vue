<template ref = "slgList">
    <div>
        <div class = "container">
            <p class = "containerLabel">Student Learning Goals:</p>
            <div v-if = "Object.keys(info['slgs']).length">
                <table class = "slgTab">
                    <tbody>
                        <tr>
                            <th>Element</th>
                            <th>Description</th>
                        </tr>
                        <tr v-for = "(value, key) in info['slgs']">
                            <td><b> {{ keysToLabels[key] }} </b></td>
                            <td> {{ value }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class = "addSheetMetadata" style = "display: inline-block" v-if = "userId == info['ownerId']">
                    <label v-if = "this.sheet" :onclick = "'openModal(\'/slgComp/create/' + this.id + '\', 1)'">
                        <i class="fas fa-edit"></i>
                    </label>
                    <label v-else :onclick = "'openModal(\'/slgCompGroup/create/' + id + '\', 1)'">
                        <i class="fas fa-edit"></i>
                    </label>
                </p>
            </div>

            <div v-else>
                <ul>
                    <li class = "mainBoxText">You have not yet input any student learning goals. Use the "plus" symbol to do so.</li>
                </ul>
                <p class = "addSheetMetadata" style = "display: inline-block" v-if = "userId == info['ownerId']">
                    <label v-if = "this.sheet" :onclick = "'openModal(\'/slgComp/create/' + id + '\', 1)'">
                        <i class="fas fa-edit"></i>
                    </label>
                    <label v-else :onclick = "'openModal(\'/slgCompGroup/create/' + id + '\', 1)'">
                        <i class="fas fa-edit"></i>
                    </label>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "slg-list",
    props: {
        //Are we retrieving SLGs of spreadsheet or group (bool)?
        sheet: {
            required: true
        },
        //Id of sheet/group
        id: {
            required: true
        }
    },
    data() {
        return {
            //Info for sheet/group.
            info: {},
            //For perms.
            userId: null,
            //Translates SLG keys into labels for table.
            keysToLabels: {
                'needsAssessment' : 'Needs Assessment',
                'rationale' : 'Rationale',
                'baselineData' : 'Baseline Data or Information',
                'targets' : 'Target(s)',
                'targetRationale' : 'Rationale for Target(s)',
                'evidenceSources' : 'Evidence Source(s)',
                'goalStmt' : 'Goal Statement',
                'profPracGoal' : 'Professional Practice Goal Statement',
                'actionSteps' : 'Action Steps and Rationale',
                'timeline' : 'Timeline and Evidence of Progress'
            }
        }
    },
    methods: {
        getInfo() {
            var url = this.sheet ? '/spreadsheet/' : '/group/'
            var id = this.id;

            axios.get(url + id).then((response) => {
                this.info = response.data
                this.info['slgs'] = JSON.parse(this.info['slgs'])
            }).catch((errors) => {
                console.log(errors)
            });

            //For perms.
            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getInfo()
    }
}
</script>
