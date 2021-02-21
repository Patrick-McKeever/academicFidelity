<template>
    <ul id = "sheetList" v-if = "Object.keys(spreadsheets).length">
        <li v-for = "sheet in spreadsheets">
            <router-link :to = "'/sheetView/' + sheet.id">{{ sheet.name }}</router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "spreadsheetSidebar",
    data() {
        return {
            currentSheet: {},
            spreadsheets: {}
        }
    },
    methods: {
        //Get information about spreadsheet referenced in URL.
        getCurrentSheet() {
            axios.get('/spreadsheet/' + this.$route.params.id).then((response) => {
                this.currentSheet = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Fetches spreadsheets in same class as the current one.
        getSpreadsheets(currentSheet) {
            var classId = currentSheet['classId'];
            axios.get('/class/' + classId).then((response) => {
                this.spreadsheets = response.data['spreadsheets']
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getCurrentSheet();
        this.getSpreadsheets(this.currentSheet);
    }
}
</script>
