<template>
    <div>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">{{ sheetInfo.name }}</p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/sheetView/{id}'. -->
            <!-- That's necessary because that url is aliased to '/sheetView/{id}/view'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link :to = "'/sheetView/' + this.$route.params.id + '/view'" tag = "div"
             v-bind:class = "['tab', this.$route.path.replace('/sheetView/').indexOf('/') === -1 ? 'activeOn' : '']">
                VIEW
            </router-link>
            <router-link
                :to = "'/sheetView/' + this.$route.params.id + '/edit'"
                         tag = "div" class = "tab">
                EDIT
            </router-link>
            <router-link :to = "'/sheetView/' + this.$route.params.id + '/stats'" tag = "div" class = "tab">
                STATS
            </router-link>
        </div>
        <router-view ref = "sheetInterior"></router-view>
    </div>
</template>

<script>
export default {
    name: "readSpreadsheet",
    data() {
        return {
            //Will contain tests for this spreadsheet.
            sheetInfo: {}
        }
    },
    methods: {
        getSheetInfo() {
            var sheetId = this.$route.params.id;
            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
    },

    mounted() {
        this.getSheetInfo();
    }
}
</script>
