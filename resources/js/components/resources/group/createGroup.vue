<template>
    <form id = "groupCreate" @submit.prevent = "createGroup()">
        <div class = "form-group">
            <input type = "text" id = "groupName" v-model = "groupName" class = "form-control">
            <label class = "form-control-placeholder" for = "groupName">Group's Name</label>
        </div>
        <input type = "submit" value = "SUBMIT">
    </form>
</template>

<script>
export default {
    name: "createClass",
    data() {
        return {
            groupName : ''
        }
    },
    methods: {
        //Trigger store method in controller
        createGroup() {
            //Create group and register user as member of group.
            axios.post('/group', {
                name: this.groupName
            });
            //Re-render class list in sidebar.
            window.app.$refs['groupList'].getGroups();
            closeModal('/');
        }
    }
}
</script>
