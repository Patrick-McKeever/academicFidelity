<template>
    <form @submit.prevent = "editSlgs()">
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
                        <textarea v-model = "info['slgs']['needsAssessment']"></textarea>
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
                        <textarea v-model = "info['slgs']['rationale']"></textarea>
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
                        <textarea v-model = "info['slgs']['baselineData']"></textarea>
                    </td>
                    <td><ul>
                        <li>Data about current student performance is included (measurable)(includes trend data, if appropriate/available).</li>
                        <li>Summarizes the educator’s analysis of the baseline data by identifying student strengths and weaknesses (specific).</li>
                    </ul></td>
                </tr>

                <tr>
                    <td><b>Target(s)</b></td>
                    <td>
                        <textarea v-model = "info['slgs']['targets']"></textarea>
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
                        <textarea v-model = "info['slgs']['targetRationale']"></textarea>
                    </td>
                    <td><ul>
                        <li>Includes explanations for growth/proficiency targets that establish and differentiate expected performance for identified students (measurable, attainable, results focused).</li>
                        <li>Describes student population and considers any contextual factors that may impact student growth/proficiency, if subgroups are excluded, explain which students, why they are excluded.</li>
                    </ul></td>
                </tr>

                <tr>
                    <td><b>Evidence Source(s)</b></td>
                    <td>
                        <textarea v-model = "info['slgs']['evidenceSources']"></textarea>
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
                        <textarea v-model = "info['slgs']['goalStmt']"></textarea>
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
                        <textarea v-model = "info['slgs']['profPracGoal']"></textarea>
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
                        <textarea v-model = "info['slgs']['actionSteps']"></textarea>
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
                        <textarea v-model = "info['slgs']['timeline']"></textarea>
                    </td>
                    <td><ul>
                        <li>Goal clearly identifies the timeframe from start to finish with benchmarks identified throughout.</li>
                        <li>Identifies evidence that may be used to determine progress toward goal.</li>
                    </ul></td>
                </tr>
            </tbody>
        </table>
        <input type = "submit" value = "SUBMIT"/>
    </form>
</template>

<script>
export default {
    name: "addSlg",
    //Bool val of whether or not we're editing sheet (as opposed to group).
    props: ['sheet'],
    data() {
        return {
            info: {},
            //If user has yet to input anything to the SLG, just use these default values as text inside textareas.
            //If they have, we'll alter this data structure to align with whatever they've input.
            defaultSlgVals: {
                needsAssessment: 'What is the biggest learning challenge(s)?',
                rationale: 'Why is this topic/focus important/priority? How is it essential to present and future content learning?',
                baselineData: 'What information is being used to inform the creation of the SLG and establish the amount of growth/achievement that should take place within the time period?',
                targets: 'Considering all available data and content requirements, what target(s) can students be expected to reach and which students will be included in the SLG? Include course, grade level, and number of students.',
                targetRationale: 'What is the rationale for setting the target(s) for student growth/proficiency within the interval of instruction?',
                evidenceSources: 'What assessment(s) will be used to measure student progress toward the goal?',
                goalStmt: 'E.g.: “Based on the data that _______________(x%) of my students currently have mastered ________________________(Standard(s)) as measured by ____________________________(assessments), my goal is that by the end of the interval of instruction, _________(x%) of my students will have achieved mastery/growth as measured by ____________(assessments)”.',
                profPracGoal: '“In order to help the students achieve the learning goal, I will improve my practice on _______________(NEPF Standard (s)) and measure my progress toward this goal by __________________.',
                actionSteps: 'What actions will you integrate into your daily/weekly routines? If you achieve this professional practice goal, is it highly likely to impact student performance on the SLG?',
                timeline: 'What evidence will be generated by taking the actions described above? How and when will you show evidence of progress?'
            }
        }
    },
    methods: {
        //Get SLGs associated with given spreadsheet from DB.
        getSlgs() {
            var id = this.$route.params.id;
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.get(url + id).then((response) => {
                this.info = response.data
                var slgs = JSON.parse(this.info['slgs']);

                //If SLGs aren't set, then replace the given slgVals with the defaults.
                if(Object.keys(slgs).length) {
                    this.info['slgs'] = slgs;
                } else {
                    this.info['slgs'] = this.defaultSlgVals;
                }
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Since SLGs are stored as a field of spreadsheet in DB, we just call sheet update method via site API.
        editSlgs() {
            var id = this.$route.params.id;
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.put(url + id, {
                //Keep these the same.
                name: this.info['name'],
                standards: this.info['standards'],
                slgs: this.info['slgs']
            });

            //SLG list.
            var slgList = this.sheet ?
                window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['slgList'] :
                window.app.$refs['navTab'].$refs['groupInteriorView'].$refs['slgList'];
            slgList.getInfo();

            closeModal('/');
        }
    },
    beforeMount() {
        this.getSlgs()
    }
}
</script>
