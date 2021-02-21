<template>
    <div>
        <slg-list ref = "slgList" :id = "this.$route.params.id" :sheet = "true"></slg-list>
        <standard-list ref = "standardList" :id = "this.$route.params.id" :sheet = "true"></standard-list>

        <sheet-table ref = "sheetAsTable" :sheet-id = "this.$route.params.id"></sheet-table>

        <label class = "btn" v-if = "sheetInfo['ownerId'] == userId">
            <i class = "fas fa-plus-circle addButton"
               :onclick = "'openModal(\'/testComp/create/' + this.$route.params.id + '\', 1)'">
            </i>
        </label>
    </div>
</template>

<script>
import SlgList from '../slgs/slgList';
import StandardList from "../standard/standardList";
import sheetAsTable from "./sheetAsTable";

export default {
    name: "sheetView",
    components: {StandardList, SlgList, sheetAsTable},
    data() {
        return {
            sheetInfo: {},
            userId: null
        }
    },
    methods: {
        getAttrs() {
            var sheetId = this.$route.params.id;

            //For perms.
            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });

            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data
            }).catch((error) => {
                console.log(error)
            });
        }
    },
    mounted() {
        this.getAttrs()
    }
}
</script>
