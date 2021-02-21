<template>
    <div>
        <div class="formLabel">
            <p class="labelClass">Edit {{ evalInfo['date'] }} Pre-Observation for {{ evalInfo['teacher']['name'] }}</p>
        </div>

        <form @submit.prevent = "editEvaluation()">
            <div class="form-group">
                <input type = "text" id = "class" class = "form-control" style="margin-top: 20px"
                       v-model = "evalInfo['evaluation']['classToObs']">
                <label class="form-control-placeholder" for="class">Grade/Class/Subject to Be Observed</label>
            </div>

            <table style = "width: 90%; margin: 0 auto;">
                <tr>
                    <th style = "width: 50%"><b>QUESTIONS TO GUIDE DISCUSSION</b></th>
                    <th style = "width: 50%"><b>NOTES</b></th>
                </tr>

                <tr>
                    <td>
                        <p style = "text-align: center"><b>Instructional Practice Standards:</b></p>
                        <ul>
                            <li>What is/was the intended learning for the lesson? What content standard(s) does this align to?</li>
                            <li>How will/did learning tasks have high cognitive demand for the students in your classroom?</li>
                            <li>How will/did students engage in meaning-making through discourse and/or other strategies? (Which strategies will/did you use?)</li>
                            <li>How will/did students demonstrate their understanding of what they are learning and why they are learning it?</li>
                            <li>How will/did you integrate assessment into instruction?</li>
                        </ul>
                    </td>
                    <td style = "text-align: center">
                        <textarea v-model = "evalInfo['evaluation']['instPracStand']"
                                  style = "width: 90%; height: 200px">
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p style = "text-align: center"><b>Professional Responsibility Standards:</b></p>
                        <ul>
                            <li>How will/did you demonstrate your commitment to the school community? </li>
                            <li>How will/did you demonstrate reflection on professional growth and practice?</li>
                            <li>How will/did you model integrity in all interactions and advocate for fair, equitable, and appropriate treatment of all students and families?</li>
                            <li>How will/did you communicate with parents about your goals of instruction and student progress?</li>
                            <li>How will/did you determine student perceptions on their learning? How will/did you demonstrate that your students feel as if you help them learn?</li>
                        </ul>
                    </td>
                    <td style = "text-align: center">
                        <textarea v-model = "evalInfo['evaluation']['profRespStand']"
                                  style = "width: 90%; height: 200px;">
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p style = "text-align: center"><b>Progress toward Student Learning Goal & Professional Practice Goal:</b></p>
                        <ul>
                            <li>Evaluator may choose to discuss progress made toward the SLG or PPG as necessary and log evidence of discussion here.</li>
                        </ul>
                    </td>
                    <td style = "text-align: center">
                        <textarea v-model = "evalInfo['evaluation']['progress']"
                              style = "width: 90%; height: 200px">
                        </textarea>
                    </td>
                </tr>
            </table>

            <input type = "submit" value = "SUBMIT"/>
        </form>
    </div>
</template>

<script>
export default {
    name: "editPreObs",
    data() {
        return {
            evalInfo: {
                teacher: {},
                evaluation: {}
            },
            //Values in form user will fill out.
            //Since this is stored as stringified JSON inside a DB field, we have to establish structure beforehand.
            defaultEval: {
                instPracStand: '',
                classToObs: '',
                profRespStand: '',
                progress: ''
            }
        }
    },
    methods: {
        //Get info about evaluation as it currently exists.
        getEvalInfo() {
            var evalId = this.$route.params.id;
            axios.get('/evaluation/' + evalId).then((response) => {
                this.evalInfo = response.data
                var evaluation = JSON.parse(this.evalInfo['evaluation']);

                //If nothing has been filled out yet, just use default values.
                if(Object.keys(evaluation).length) {
                    this.evalInfo['evaluation'] = evaluation;
                } else {
                    this.evalInfo['evaluation'] = this.defaultEval;
                }
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Make updates to evaluation.
        editEvaluation() {
            var evalId = this.$route.params.id;

            axios.put('/evaluation/' + evalId, {
                //Keep these the same.
                date: this.evalInfo['date'],
                evaluation: this.evalInfo['evaluation']
            });

            Vue.prototype.$app.$router.replace('/evaluationComp/' + evalId + '/readPreObs');
        }
    },
    beforeMount() {
        this.getEvalInfo()
    }
}
</script>
