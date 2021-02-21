<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update {{ testInfo.name }}</p>
        </div>
        <form id = "classForm" @submit.prevent = "updateTest()">
            <div class = "form-group">
                <input type = "text" id = "className" name = "className" v-model = "testInfo['name']" class = "form-control">
                <label class = "form-control-placeholder" for = "className">Test's Name</label>
            </div>

            <div class = "form-group">
                <div class = "form-group" style = "text-align: center">
                    <input type = "date" v-model = "testInfo['date']" required="">
                    <br>
                </div>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "updateTest",
    data() {
        return {
            testInfo: {}
        }
    },
    methods: {
        //Get existing test values from API.
        getTestInfo() {
            var testId = this.$route.params.testId;
            axios.get('/test/' + testId).then((response) => {
                this.testInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Update test based on user input.
        updateTest() {
            var testId = this.$route.params.testId;
            axios.put('/test/' + testId, {
                name: this.testInfo.name,
                date: this.testInfo.date
            });

            //update UI to reflect changes.
            var sheetTable = window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['sheetAsTable'];
            sheetTable.getAttrs();
            closeModal('/');
        }
    },
    mounted() {
        this.getTestInfo();
    }
}
</script>
