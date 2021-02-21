<template>
    <form @submit.prevent = "createStandard()" class = "centralText">
        <p class = "containerLabel">Input Custom Standard:</p>
        <textarea v-model = "customStandard" class = "customStandard"></textarea>
        <input type = "submit" value = "SUBMIT">
    </form>
</template>

<script>
export default {
    name: "writeStandard",
    //Prop gives bool val of whether we are editing standards of sheet or group.
    props: ['sheet'],
    data() {
        return {
            info: {},
            customStandard: ''
        }
    },
    methods: {
        //Get info of spreadsheet to which we wish to add standards.
        getInfo() {
            var id = this.$route.params.id;
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.get(url + id).then((response) => {
                this.info = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Since standards are held as a field in the spreadsheets table,
        //we can just update spreadsheets using the API to change the standard.
        createStandard() {
            var id = this.$route.params.id;
            var standards = JSON.parse(this.info['standards']);
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            standards.push(this.customStandard);

            axios.put(url + id, {
                //Keep these the same.
                name: this.info.name,
                slgs: this.info.slgs,
                standards: standards
            });
            //Update UI to reflect updates.
            var component = this.sheet ?
                window.app.$refs['navTabView'].$refs['sheetInterior'].$refs['standardList'] :
                window.app.$refs['navTab'].$refs['groupInteriorView'].$refs['standardList'];
            component.getInfo();
            closeModal('/');
        }
    },
    mounted() {
        this.getInfo()
    }
}
</script>
