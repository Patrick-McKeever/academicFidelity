<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Delete {{ testInfo.name }}</p>
        </div>
        <form @submit.prevent = "deleteTest()" class = "deleteForm">
            <input type = "submit"value = "DELETE">
        </form>
    </div>
</template>

<script>
export default {
    name: "deleteTest",
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
        deleteTest() {
            var testId = this.$route.params.testId;
            axios.delete('/test/' + testId);

            //Update UI to reflect changes.
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
