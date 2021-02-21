<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create (Pre)Observation</p>
        </div>
        <form id = "classForm" @submit.prevent = "createObs()">
            <div class = "form-group">
                <div class = "form-group" style = "text-align: center">
                    <input type = "date" v-model = "date" required="">
                    <br>
                </div>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "createEvaluation",
    data() {
        return {
            date: null
        }
    },
    methods: {
        //Create observation.
        createObs() {
            axios.post('/evaluation', {
                date: this.date,
                teacherId: this.$route.params.teacherId,
                preObs: this.$route.params.preObs
            })
            //Re-render spreadsheet table.
            var sheetTable = window.app.$refs['navTabView'].$refs['teacherView'];
            sheetTable.getTeacherInfo();
            closeModal('/');
        }
    }
}
</script>
