<template>
    <form id = "standardForm" @submit.prevent = "addStandard()">
        <div class = "form-group">
            <div class = "floating-label">
                <select class = "floating-select" id = "classes"
                        v-model = "selectedGroup" @change = "getGroupInfo()">
                    <option disabled selected></option>
                    <option v-for = "group in groups" :value = "group['id']"> {{ group['name'] }} </option>
                </select>
                <label class = "form-control-placeholder" for = "classes">Group</label>
            </div>
        </div>

        <div id = "insertStandardSel" style = "display: none">
            <p class = "standardSelLabel">[HOLD THE "CTRL" KEY TO SELECT MULTIPLE OPTIONS]</p>
            <select multiple = "multiple"  id = "standardSel" v-model = "selectedStandards">
                <option disabled selected></option>
                <option v-for = "standard in groupStandards" value = "standard">{{ standard }}</option>
            </select>
            <input type = "submit" value = "SUBMIT">
        </div>
    </form>
</template>

<script>
export default {
    name: "groupBasedStandard",
    data() {
        return {
            //Groups owned by user.
            groups: {},
            //Info of spreadsheet to which we are appending standards.
            sheetInfo: {},
            //Id of group selected by user.
            selectedGroup: null,
            //Group info of selected group.
            groupStandards: {},
            //standards selected by user.
            selectedStandards: []
        }
    },
    methods: {
        //Get list of non-archived groups owned by user, get info of spreadsheet.
        getInfo() {
            axios.get('/group/archived/0').then((response) => {
                this.groups = response.data
            }).catch((errors) => {
                console.log(errors)
            });

            var sheetId = this.$route.params.id;

            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Get group info, which contains standards for the given group
        getGroupInfo() {
            axios.get('/group/' + this.selectedGroup).then((response) => {
                this.groupStandards = JSON.parse(response.data['standards'])
            }).catch((errors) => {
                console.log(errors)
            });

            document.getElementById('insertStandardSel').style.display = 'block';
        },
        //Add selected standard(s) to sheet.
        addStandard() {
            var sheetId = this.$route.params.id;
            var oldStandards = JSON.parse(this.sheetInfo['standards']);
            var newStandards = oldStandards.concat(this.selectedStandards);

            axios.put('/spreadsheet/' + sheetId, {
                //Keep these the same.
                name: this.sheetInfo['name'],
                slgs: this.sheetInfo['slgs'],
                //change this one.
                standards: newStandards
            });

            //Update UI to reflect changes
            var component = window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['standardList'];
            component.getInfo();

            closeModal('/');
        }
    },
    mounted() {
        this.getInfo();
    }
}
</script>
