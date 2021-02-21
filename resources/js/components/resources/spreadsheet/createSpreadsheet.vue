<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create Spreadsheet</p>
        </div>
        <form @submit.prevent = "createSpreadsheet()">
            <div class = "form-group">
                <input type = "text" id = "ssName" v-model = "name" class = "form-control">
                <label class = "form-control-placeholder" for = "ssName">Spreadsheet's Name</label>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "createSpreadsheet",
    data() {
        return {
            name: ''
        }
    },
    methods: {
        createSpreadsheet() {
            axios.post('/spreadsheet', {
                name: this.name,
                classId: this.$route.params.classId
            });
            var component = window.app.$refs['navTab'].$refs['classInteriorView'];
            component.getSpreadsheets();
            closeModal('/');
        }
    }
}
</script>

<style scoped>

</style>
