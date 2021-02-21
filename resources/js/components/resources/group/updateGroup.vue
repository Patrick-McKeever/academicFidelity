<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update Group</p>
        </div>
        <form id = "classForm" @submit.prevent = "updateGroup()">
            <div class = "form-group">
                <input type = "text" id = "className" v-model = "groupInfo.name" class = "form-control">
                <label class = "form-control-placeholder" for = "className">Groups' Name</label>
            </div>
            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "archived" v-model = "groupInfo.archived">
                        <option value = 0>Not archived</option>
                        <option value = 1>Archived</option>
                    </select>
                    <label class = "form-control-placeholder" for = "archived">Archived</label>
                </div>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "updateGroup",
    data() {
        return {
            groupInfo: {}
        }
    },
    methods: {
        //Get current info about group.
        getGroupInfo() {
            var groupId = this.$route.params.id;
            axios.get('/group/' + groupId).then((response) => {
                this.groupInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Update group.
        updateGroup() {
            var groupId = this.$route.params.id;
            axios.put('/group/' + groupId, {
                name: this.groupInfo['name'],
                archived: this.groupInfo['archived']
            });

            //Update UI to reflect changes.
            window.app.$refs['groupList'].getGroups();
            window.app.$refs['navTab'].getGroupInfo();
            closeModal('/');
        }
    },
    mounted() {
        this.getGroupInfo()
    }
}
</script>
