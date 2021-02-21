<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Delete {{ spreadsheetInfo.name }}</p>
        </div>
        <form @submit.prevent = "deleteSheet()" class = "deleteForm">
            <input type = "submit" value = "DELETE">
        </form>
    </div>
</template>

<script>
export default {
    name: "deleteSpreadsheet",
    data() {
        return {
            spreadsheetInfo: {}
        }
    },
    methods: {
        //Get name and info about spreadsheet.
        getSpreadsheetInfo() {
            var spreadsheetId = this.$route.params.spreadsheetId;
            axios.get('/spreadsheet/' + spreadsheetId).then((response) => {
                this.spreadsheetInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Send delete req to server.
        deleteSheet() {
            var sheetId = this.$route.params.spreadsheetId;
            axios.delete('/spreadsheet/' + sheetId);
            //Update UI to reflect deletion.
            var component = window.app.$refs['navTab'].$refs['classInteriorView'];
            component.getSpreadsheets();
            closeModal('/');
        }
    },
    mounted() {
        this.getSpreadsheetInfo();
    }
}
</script>
