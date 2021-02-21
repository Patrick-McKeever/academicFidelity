<template>
    <div>
        <form id = "standardForm" @submit.prevent = "createStandard()">
            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "jurisdiction"
                            v-model = "selectedJuridiction" @change = "getStandardSet()">
                        <option disabled selected></option>
                        <option v-for = "jurisdiction in jurisdictions" :value = "jurisdiction['id']"> {{ jurisdiction['title'] }} </option>
                    </select>
                    <label class = "form-control-placeholder" for = "jurisdiction">Jurisdiction</label>
                </div>
            </div>

            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "standardSet"
                            v-model = "selectedSet" @change = "getStandards()">
                        <option disabled selected></option>
                        <option v-for = "standardSet in standardSets" :value = "standardSet['id']"
                        > {{ standardSet['subject'] }}: {{ standardSet['title'] }} </option>
                    </select>
                    <label class = "form-control-placeholder" for = "standardSet">Standard Set</label>
                </div>
            </div>

            <div id = "insertStandardSel" style = "display: none">
                <p class = "standardSelLabel">[HOLD THE "CTRL" KEY TO SELECT MULTIPLE OPTIONS]</p>
                <select multiple = "multiple" id = "standardSel" v-model = "selectedStandards"></select>
                <input type = "submit" value = "SUBMIT">
            </div>
        </form>
    </div>
</template>

<script>
export default {
    //Use v-models such that standardsSet is filled in as soon as jurisdiction is set.
    //Then, the empty select element will be filled up by a v-for statement.
    name: "pickStandard",
    //Prop gives bool val of whether we are editing standards of sheet or group.
    props: ['sheet'],
    data() {
        return {
            info: {},
            jurisdictions: {},
            selectedJuridiction: 0,
            standardSets: {},
            selectedSet: 0,
            standards: {},
            selectedStandards: []
        }
    },
    methods: {
        //Get info of spreadsheet/group to which we wish to add standards.
        getInfo() {
            var id = this.$route.params.id;
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.get(url + id).then((response) => {
                this.info = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Loads first part of form (jurisdiction selection) using data from API.
        getJurisdictions() {
            axios.get('/standardsGrabber/jurisdictions').then((response) => {
                this.jurisdictions = response.data['data']
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Loads second part of form.
        //Using API, grab standard sets from input jurisdiction and load into select.
        getStandardSet() {
            var reqUrl = '/standardsGrabber/standardSets/';
            axios.get(reqUrl + this.selectedJuridiction).then((response) => {
                this.standardSets = response.data['data']['standardSets']
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Because vue can't do the recursive stuff I want to do, I generate html in the back end.
        //Then copy-paste it into the relevant element.
        getStandards() {
            var reqUrl = '/standardsGrabber/standards/';
            axios.get(reqUrl + this.selectedSet).then((response) => {
                document.getElementById('standardSel').innerHTML = response.data
                document.getElementById('insertStandardSel').style.display = "block"
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Since standards are held as a field in the spreadsheets/groups table,
        //we can just update spreadsheets/groups using the API to change the standard.
        createStandard() {
            var id = this.$route.params.id;
            var oldStandards = JSON.parse(this.info['standards']);

            var newStandards = oldStandards.concat(this.selectedStandards);

            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.put(url + id, {
                //Keep these the same.
                name: this.info.name,
                slgs: this.info.slgs,
                //change this one.
                standards: newStandards
            });
            //Update UI to reflect updates.
            var component = this.sheet ?
                window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['standardList'] :
                window.app.$refs['navTab'].$refs['groupInteriorView'].$refs['standardList'];
            component.getInfo();
            closeModal('/');
        }
    },
    beforeMount() {
        this.getInfo();
        this.getJurisdictions();
    }
}
</script>
