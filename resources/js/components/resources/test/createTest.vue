<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create Test</p>
        </div>
        <form id = "classForm" @submit.prevent = "createTest()">
            <div class = "form-group">
                <input type = "text" id = "className" name = "className" v-model = "name" class = "form-control">
                <label class = "form-control-placeholder" for = "className">Test's Name</label>
            </div>

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
    name: "createTest",
    data() {
        return {
            name: '',
            date: ''
        }
    },
    methods: {
        createTest() {
            axios.post('/test', {
                name: this.name,
                date: this.date,
                spreadsheetId: this.$route.params.sheetId
            });
            //Re-render spreadsheet table.
            var sheetTable = window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['sheetAsTable'];
            sheetTable.getAttrs();
            closeModal('/');
        }
    }
}
</script>
