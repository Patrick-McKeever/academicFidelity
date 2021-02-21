<template>
    <ul id = "obsList" v-if = "Object.keys(evaluations).length">
        <li v-for = "evaluation in evaluations">
            <router-link v-if = "pre"
                :to = "'/evaluationComp/' + evaluation.id + '/readPreObs'">{{ evaluation.date }}</router-link>
            <router-link v-else
                 :to = "'/evaluationComp/' + evaluation.id + '/readObs'">{{ evaluation.date }}</router-link>
        </li>
    </ul>

    <ul id = "obsList" v-else>
        <li>
            <a>You have not yet been evaluated.</a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "myObsList",
    //Are we grabbing user's pre-observations or regular observations?
    props: ['pre'],
    data() {
        return {
            evaluations: {}
        }
    },
    methods: {
        getMyObs() {
            axios.get('/evaluation/preObs/' + Number(this.pre)).then((response) => {
                this.evaluations = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getMyObs()
    }
}
</script>
