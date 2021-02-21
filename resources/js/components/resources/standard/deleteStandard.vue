<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Delete Standard</p>
        </div>
        <form @submit.prevent = "deleteStandard()" class = "deleteForm">
            <input type = "submit" value = "DELETE">
        </form>
    </div>
</template>

<script>
export default {
    name: 'delete-standard',
    //Boolean value of whether this is spreadsheet, as opposed to group.
    props: ['sheet'],
    data() {
        return {
            info: {}
        }
    },
    methods: {
        //Get current spreadsheet info.
        getInfo() {
            var id = this.$route.params.id;
            var url = parseInt(this.$route.params.sheet) ? '/spreadsheet/' : '/group/';

            axios.get(url + id).then((response) => {
                this.info = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Update spreadsheet object via API with standard deleted.
        deleteStandard() {
            var id = this.$route.params.id;
            var standards = JSON.parse(this.info['standards']);
            var url = parseInt(this.$route.params.sheet) ? '/spreadsheet/' : '/group/';

            //remove
            standards.splice(this.$route.params.standardIndex, 1)

            axios.put(url + id, {
                name: this.info.name,
                standards: standards,
                slgs: this.info.slgs
            });
            //Update UI to reflect updates.
            var component = parseInt(this.$route.params.sheet) ?
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

