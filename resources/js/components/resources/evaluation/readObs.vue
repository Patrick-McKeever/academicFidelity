<template>
    <div>
        <div class="formLabel">
            <p class="labelClass">Edit {{ evalInfo['date'] }} Evaluation for {{ evalInfo['teacher']['name'] }}</p>
        </div>

        <div class = "form-group" style = "text-align: center">
            <input onclick = "return false" type = "date" v-model = "evalInfo['date']">
            <br>
        </div>

        <div class = "form-group">
            <p class = "mainBoxText" style = "text-align: center"><b>DURATION: </b>{{ evalInfo['evaluation']['duration'] }}</p>
        </div>

        <p class = "textLarge"><b>OBSERVATION EVIDENCE</b></p>

        <div class = "form-group" style = "text-align: center">
            <p class = "mainBoxText" style = "text-align: center">>{{ evalInfo['evaluation']['observationEvidence'] }}</p>
        </div>

        <p class = "textLarge"><b>FEEDBACK TO THE TEACHER</b></p>

        <div class = "form-group" style = "text-align: center">
            <p class = "mainBoxText" style = "text-align: center">{{ evalInfo['evaluation']['feedback'] }}</p>
        </div>

        <p class = "textLarge"><b>TEACHER HIGH LEVEL INSTRUCTIONAL STANDARDS AND INDICATORS</b></p>

        <label style = "text-align: center"><b>Standard 1: New Learning is Connected to Past Learning and Experience.</b></label>

        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['1.1']" type = "checkbox" class = "checkBox">
            <b>Indicator 1:</b> Teacher activates all students' initial understandings of new concepts and skills.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['1.2']" type = "checkbox" class = "checkBox">
            <b>Indicator 2:</b> Teacher makes connections explicit between previous learning and new concepts/skills for all students.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['1.3']" type = "checkbox" class = "checkBox">
            <b>Indicator 3:</b> Teacher makes clear the purpose of new learning for all students.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['1.4']" type = "checkbox" class = "checkBox">
            <b>Indicator 4:</b> Teacher activates all students' initial understandings of new concepts and skills.
        </label>

        <label style = "text-align: center"><b>Standard 2: Learning Tasks have High Cognitive Demand for Diverse Learners.</b></label>

        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['2.1']" type = "checkbox" class = "checkBox">
            <b>Indicator 1:</b> Tasks purposefully employ all students' cognitive abilities and skills.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['2.2']" type = "checkbox" class = "checkBox">
            <b>Indicator 2:</b> Tasks place appropriate demands on each student.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['2.3']" type = "checkbox" class = "checkBox">
            <b>Indicator 3:</b> Tasks progressively develop all students' cognitive abilities and skills.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['2.4']" type = "checkbox" class = "checkBox">
            <b>Indicator 4:</b> Teacher operates with a deep belief that all children achieve regardless of race, perceived ability, and socioeconomic status.
        </label>

        <label style = "text-align: center"><b>Standard 3:</b> Students Engage in Meaning-Making through Discourse and Other Strategies.</b></label>

        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['3.1']" type = "checkbox" class = "checkBox">
            <b>Indicator 1:</b> Teacher provides opportunities for extended, productive discourse between the teacher and among the student(s).
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['3.2']" type = "checkbox" class = "checkBox">
            <b>Indicator 2:</b> Teacher assists all students to create and interpret multiple relationships.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['3.3']" type = "checkbox" class = "checkBox">
            <b>Indicator 3:</b> Teacher provides opportunities for all students to use existing knowledge and prior experience to make connections and recognize relationships.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['3.4']" type = "checkbox" class = "checkBox">
            <b>Indicator 4:</b> Teacher structures the classroom environment to enable cooperation, participation, and a positive affective experience for all students.
        </label>

        <label style = "text-align: center"><b>Standard 4: Students Engage in Metacognitive Activity to Increase Understanding and Responsibility for Their own Learning.</b></label>

        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['4.1']" type = "checkbox" class = "checkBox">
            <b>Indicator 1:</b> Teacher and all students understand what students are learning, why they are learning it, and how they will know if they have learned it.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['4.2']" type = "checkbox" class = "checkBox">
            <b>Indicator 2:</b> Teacher structures opportunities and self-monitored learning for all students.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['4.3']" type = "checkbox" class = "checkBox">
            <b>Indicator 3:</b> Teacher supports all students to take actions based on the students' self-monitoring processes.
        </label>

        <label style = "text-align: center"><b>Standard 5: Assessment is Integrated into Instruction</b></label>

        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['5.1']" type = "checkbox" class = "checkBox">
            <b>Indicator 1:</b> Teacher plans ongoing learning opportunities based on evidence of all students' current learning status.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['5.2']" type = "checkbox" class = "checkBox">
            <b>Indicator 2:</b> Teacher aligns assessment opportunities with learning goals and performance criteria.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['5.3']" type = "checkbox" class = "checkBox">
            <b>Indicator 3:</b> Teacher structures opportunities to generate evidence of learning during the lesson of all students.
        </label>
        <label class = "cb">
            <input onclick = "return false" v-model = "evalInfo['evaluation']['standards']['5.4']" type = "checkbox" class = "checkBox">
            <b>Indicator 4:</b> Teacher adapts actions based on evidence generated in the lesson for all students.
        </label>
    </div>
</template>

<script>
export default {
    name: "readObs",
    data() {
        return {
            evalInfo: {
                teacher: {},
                evaluation: {
                    standards: {}
                }
            },
            //Values in form user will fill out.
            //Since this is stored as stringified JSON inside a DB field, we have to establish structure beforehand.
            defaultEval: {
                duration: '',
                observationEvidence: '',
                feedback: '',
                standards: {
                    '1.1': '', '1.2': '', '1.3': '', '1.4': '',
                    '2.1': '', '2.2': '', '2.3': '', '2.4': '',
                    '3.1': '', '3.2': '', '3.3': '', '3.4': '',
                    '4.1': '', '4.2': '', '4.3': '',
                    '5.1': '', '5.2': '', '5.3': '', '5.4': ''
                }
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
        }
    },
    beforeMount() {
        this.getEvalInfo()
    }
}
</script>
