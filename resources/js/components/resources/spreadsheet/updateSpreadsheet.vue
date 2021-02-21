<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update Spreadsheet</p>
        </div>
        <form @submit.prevent = "updateSpreadsheet()">
            <div class = "form-group">
                <input type = "text" id = "ssName" v-model = "spreadsheetInfo.name" class = "form-control">
                <label class = "form-control-placeholder" for = "ssName">Spreadsheet's Name</label>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "updateSpreadsheet",
    data() {
        return {
            spreadsheetInfo: {}
        }
    },
    methods: {
        //Get current spreadsheet info.
        getSpreadsheetInfo() {
            var spreadsheetId = this.$route.params.spreadsheetId;
            axios.get('/spreadsheet/' + spreadsheetId).then((response) => {
              this.spreadsheetInfo = response.data
            }).catch((errors) => {
              console.log(errors)
            });
        },
        //Send request to update name.
        updateSpreadsheet() {
            var spreadsheetId = this.$route.params.spreadsheetId;
            axios.put('/spreadsheet/' + spreadsheetId, {
                name: this.spreadsheetInfo.name,
                standards: this.spreadsheetInfo.standards,
                slgs: this.spreadsheetInfo.slgs
            });
            //Update UI to reflect updates.
            var component = window.app.$refs['navTab'].$refs['classInteriorView'];
            component.getSpreadsheets();
            closeModal('/');
        }
    },
    mounted() {
        this.getSpreadsheetInfo()
    }
}
</script>
