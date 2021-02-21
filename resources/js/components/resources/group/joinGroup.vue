<template>
    <form id = "groupJoin" @submit.prevent = "joinGroup()">
        <div class = "form-group">
            <input type = "text" id = "joinCode" v-model = "joinCode" class = "form-control">
            <label class = "form-control-placeholder" for = "joinCode">Group's Join Code</label>
        </div>
        <input type = "submit" value = "SUBMIT">
    </form>
</template>

<script>
export default {
    name: "joinGroup",
    data() {
        return {
            joinCode: ''
        }
    },
    methods: {
        joinGroup() {
            axios.post('/groupMember', {
                joinCode: this.joinCode
            }).catch(err => {
                alert(err.response.data)
            });
            //Re-render class list in sidebar.
            window.app.$refs['groupList'].getGroups();
            closeModal('/');
        }
    }
}
</script>
