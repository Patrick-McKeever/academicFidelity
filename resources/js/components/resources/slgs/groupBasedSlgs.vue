<template>
    <form id = "slgForm" @submit.prevent = "editSlgs()">
        <div class = "form-group">
            <div class = "floating-label">
                <select class = "floating-select" id = "classes"
                        v-model = "selectedGroup" @change = "getGroupSlg()">
                    <option disabled selected></option>
                    <option v-for = "group in groups" :value = "group['id']"> {{ group['name'] }} </option>
                </select>
                <label class = "form-control-placeholder" for = "classes">Group</label>
            </div>
        </div>

        <div id = "slgDiv" style = "display: none">
            <div v-if = "Object.keys(slg).length">
                <table id = "slgForm">
                    <tbody>
                    <tr>
                        <th>ELEMENT</th>
                        <th>DESCRIPTION</th>
                        <th>CRITERIA</th>
                    </tr>

                    <tr>
                        <td><b>Determining Needs</b></td>
                        <td><b>What is the priority content and learning that is expected/needed?</b></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Needs Assessment</b></td>
                        <td>
                            <textarea v-model = "slg['needsAssessment']"></textarea>
                        </td>
                        <td><ul>
                            <li>Identifies priority content and learning based on current students' abilities and/or trend data (strategic).</li>
                            <li>Focuses on appropriate knowledge/skill for the course, grade level, and student population.</li>
                            <li>Uses data to identify student needs and identifies sources of information about students (e.g. test scores/performances from prior years etc.).</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Rationale</b></td>
                        <td>
                            <textarea v-model = "slg['rationale']"></textarea>
                        </td>
                        <td><ul>
                            <li>Provides a clear explanation for why the content is an appropriate focus and/or area of need (relevant).</li>
                            <li>Explains how identified priorities align with school/district goals.</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Goal Setting and Development of S.M.A.R.T Goal</b></td>
                        <td><b>Where are the students at the beginning of instruction in respect to the goal?</b></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Baseline Data or Information</b></td>
                        <td>
                            <textarea v-model = "slg['baselineData']"></textarea>
                        </td>
                        <td><ul>
                            <li>Data about current student performance is included (measurable)(includes trend data, if appropriate/available).</li>
                            <li>Summarizes the educator’s analysis of the baseline data by identifying student strengths and weaknesses (specific).</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Target(s)</b></td>
                        <td>
                            <textarea v-model = "slg['targets']"></textarea>
                        </td>
                        <td><ul>
                            <li>Identifies the expected outcomes for either the whole class or tiered targets as appropriate (this is the group on which the score on the SLG will be based).</li>
                            <li>Uses baseline or pretest data to determine appropriate growth/proficiency target with clear explanation of how targets are determined.</li>
                            <li>Sets rigorous yet attainable/realistic targets that are developmentally appropriate and measurable.</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Rationale for Target</b></td>
                        <td>
                            <textarea v-model = "slg['targetRationale']"></textarea>
                        </td>
                        <td><ul>
                            <li>Includes explanations for growth/proficiency targets that establish and differentiate expected performance for identified students (measurable, attainable, results focused).</li>
                            <li>Describes student population and considers any contextual factors that may impact student growth/proficiency, if subgroups are excluded, explain which students, why they are excluded.</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Evidence Source(s)</b></td>
                        <td>
                            <textarea v-model = "slg['evidenceSources']"></textarea>
                        </td>
                        <td><ul>
                            <li>Identifies data sources used to meet the assessment criteria outlined in NEPF Protocols.</li>
                            <li>Provides a plan for combining assessments if multiple summative assessments are used.</li>
                            <li>Uses appropriate measures for baseline, midcourse, and end of interval data collection (timed/tracked).</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Goal Statement</b></td>
                        <td><b>What is the most important knowledge/skill(s) the students should attain by the end of the interval of instruction?</b></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Goal Statement</b></td>
                        <td>
                            <textarea v-model = "slg['goalStmt']"></textarea>
                        </td>
                        <td><ul>
                            <li>Identifies specific knowledge/skills students should attain and/or specific student outcome/performance that will be affected</li>
                            <li>Focuses on standards based enduring skill which students are expected to master for the course, grade level and student population (relevant and realistic)</li>
                            <li>Includes multiple sources of data to demonstrate growth and impact on all students identified in SLG.</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Professional Practice Goal</b></td>
                        <td><b>The educator uses the Self-Assessment Tool and/or previous evaluation to identify and set a professional practice goal (PPG). This goal should clearly identify an Instructional Practice Standard(s)(teachers)/ Instructional Leadership Standard(s)(administrators) or Professional Responsibilities Standard(s) that aligns and provides support for achieving the SLG.</b></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Professional Practice Goal Statement</b></td>
                        <td>
                            <textarea v-model = "slg['profPracGoal']"></textarea>
                        </td>
                        <td><ul>
                            <li>Based on NEPF self-assessment and/or prior year evaluation.</li>
                            <li>Identifies specific NEPF standard(s) (either Instructional/Instructional Leadership (admin) or a Professional Responsibilities standards that supports the SLG).</li>
                            <li>Measureable and identifies specific measures/assessments that will be used to determine progress toward goal.</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Action Steps and Rationale</b></td>
                        <td>
                            <textarea v-model = "slg['actionSteps']"></textarea>
                        </td>
                        <td><ul>
                            <li>Action steps are clearly described and necessary to attain the goal.</li>
                            <li>Goal is realistically achievable given the timeframe and identified target.</li>
                            <li>Goal is relevant to expected outcomes and if reached should have the effect expected</li>
                        </ul></td>
                    </tr>

                    <tr>
                        <td><b>Timeline and Evidence of Progress</b></td>
                        <td>
                            <textarea v-model = "slg['timeline']"></textarea>
                        </td>
                        <td><ul>
                            <li>Goal clearly identifies the timeframe from start to finish with benchmarks identified throughout.</li>
                            <li>Identifies evidence that may be used to determine progress toward goal.</li>
                        </ul></td>
                    </tr>
                    </tbody>
                </table>

                <input type = "submit" value = "SUBMIT"/>
            </div>

            <div v-else>
                <p class = "mainBoxText">No SLGs input for this group.</p>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "groupBasedSlgs",
    data() {
        return {
            //Groups owned by user.
            groups: {},
            //Info of spreadsheet to which we are appending standards.
            sheetInfo: {},
            //Id of group selected by user.
            selectedGroup: null,
            //Group info of selected group.
            slg: {}
        }
    },
    methods: {
        //Get list of non-archived groups owned by user, get info of spreadsheet.
        getInfo() {
            axios.get('/group/archived/0').then((response) => {
                this.groups = response.data
            }).catch((errors) => {
                console.log(errors)
            });

            var sheetId = this.$route.params.id;

            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Get group info, which contains standards for the given group
        getGroupSlg() {
            axios.get('/group/' + this.selectedGroup).then((response) => {
                this.slg = JSON.parse(response.data['slgs'])
            }).catch((errors) => {
                console.log(errors)
            });

            document.getElementById('slgDiv').style.display = 'block';
        },
        //Since SLGs are stored as a field of spreadsheet in DB, we just call sheet update method via site API.
        editSlgs() {
            var id = this.$route.params.id;

            axios.put('/spreadsheet/' + id, {
                //Keep these the same.
                name: this.sheetInfo['name'],
                standards: this.sheetInfo['standards'],
                slgs: this.slg
            });

            //SLG list.
            var slgList = window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['slgList'];
            slgList.getInfo();

            closeModal('/');
        }
    },
    mounted() {
        this.getInfo();
    }
}
</script>

<style scoped>

</style>
