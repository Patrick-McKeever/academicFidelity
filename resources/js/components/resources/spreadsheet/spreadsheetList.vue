<template ref = "spreadsheetList">
    <div v-if = "spreadsheets.length">
        <table class = "resourceTab">
            <tbody>
            <tr v-for = "spreadsheet in spreadsheets">
                <td>
                    <a class = "tableText" :href = "'/sheetView/' + spreadsheet.id" target = "_blank">{{ spreadsheet.name }}</a>
                </td>
                <td>
                    <label class = "tableText" v-if = "classInfo['ownerId'] == userId"
                           :onclick = "'openModal(\'/spreadsheetComp/' + spreadsheet.id + '/update\', 0)'">
                        <i class = "far fa-edit"></i>
                    </label>
                </td>
                <td>
                    <label class = "tableText" v-if = "classInfo['ownerId'] == userId"
                           :onclick = "'openModal(\'/spreadsheetComp/' + spreadsheet.id + '/delete\', 0)'">
                        <i class = "far fa-window-close"></i>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
            <i class="fas fa-plus-circle addButton" v-if = "classInfo['ownerId'] == userId"
               :onclick = "'openModal(\'/spreadsheetComp/create/' + this.$route.params.id + '\', 1)'"></i>
    </div>

    <div v-else>
        <p class = "textLarge">You haven't added any spreadsheets. Use the "plus" button in the bottom right to do so.</p>

        <i class="fas fa-plus-circle addButton" v-if = "classInfo['ownerId'] == userId"
           :onclick = "'openModal(\'/spreadsheetComp/create/' + this.$route.params.id + '\', 1)'"></i>
    </div>
</template>

<script>
export default {
    name: "spreadsheetList",
    data() {
        return {
            classInfo: {},
            spreadsheets: {},
            userId: null
        }
    },
    methods: {
        getSpreadsheets() {
            var classId = this.$route.params.id;
            axios.get('/class/' + classId).then((response) => {
                this.classInfo = response.data
                this.spreadsheets = response.data['spreadsheets']
            }).catch((errors) => {
                console.log(errors)
            });

            //For perms.
            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getSpreadsheets()
    }
}
</script>
