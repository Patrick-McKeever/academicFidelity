<template>
    <div v-if = "Object.keys(evaluations).length">
        <table class = "resourceTab">
            <tbody>
            <tr v-for = "evaluation in evaluations">
                <td style = "text-align: center">
                    <router-link v-if = "preObs"
                        :to = "'/evaluationComp/preObs/' + evaluation.id" class = "tableText">
                        {{ evaluation.date }}
                    </router-link>
                    <router-link v-else
                                 :to = "'/evaluationComp/obs/' + evaluation.id" class = "tableText">
                        {{ evaluation.date }}
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
        <i class="fas fa-plus-circle addButton"
           :onclick = "'openModal(\'/evaluationComp/create/' + this.$route.params.id + '/' + this.preObs + '\', 0)'"></i>
    </div>

    <div v-else>
        <p class = "textLarge">You have not made any (pre)observations for this teacher.</p>
        <i class="fas fa-plus-circle addButton"
           :onclick = "'openModal(\'/evaluationComp/create/' + this.$route.params.id + '/' + this.preObs + '\', 0)'"></i>
    </div>
</template>

<script>
export default {
    name: "teacherObsList",
    //Do we list pre-observations for this teacher or just observations?
    props: ['preObs'],
    data() {
        return {
            evaluations: []
        }
    },
    methods: {
        //Get current info about teacher.
        getTeacherInfo() {
            var teacherId = this.$route.params.id;
            axios.get('/teacher/' + teacherId).then((response) => {
                //Filter out observations or preobs depending on which type user is requesting to see list of.
                this.evaluations = response.data['evaluations']
                    .filter(obs => parseInt(obs['preObs']) == this.preObs)
            }).catch((errors) => {
                console.log(errors)
            });
        },
    },
    mounted() {
        this.getTeacherInfo()
    }
}
</script>
