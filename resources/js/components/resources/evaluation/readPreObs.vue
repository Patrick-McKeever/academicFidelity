<template>
    <div>
        <div class="formLabel">
            <p class="labelClass">Edit {{ evalInfo['date'] }} Pre-Observation for {{ evalInfo['teacher']['name'] }}</p>
        </div>

        <div class="form-group">
            <p class = "mainBoxText"><b>Grade/Class/Subject To Be Observed:</b> {{ evalInfo['evaluation']['classToObs'] }}</p>
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
                    <p>{{ evalInfo['evaluation']['instPracStand'] }}</p>
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
                    <p>{{ evalInfo['evaluation']['profRespStand'] }}</p>
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
                    <p>{{ evalInfo['evaluation']['progress'] }}</p>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: "readPreObs",
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
                if (Object.keys(evaluation).length) {
                    this.evalInfo['evaluation'] = evaluation;
                } else {
                    this.evalInfo['evaluation'] = this.defaultEval;
                }
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    beforeMount() {
        this.getEvalInfo()
    }
}
</script>
