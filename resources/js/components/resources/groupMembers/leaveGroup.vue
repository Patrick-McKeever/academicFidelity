<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Leave Group</p>
        </div>
        <form @submit.prevent = "leaveGroup()" class = "deleteForm">
            <input type = "submit"value = "LEAVE">
        </form>
    </div>
</template>

<script>
export default {
    name: "leaveGroup",
    methods: {
        //Have user leave group.
        leaveGroup() {
            var groupId = this.$route.params.id;
            axios.delete('/groupMember/' + groupId);

            //Update UI to reflect changes.
            window.app.$refs['groupList'].getGroups();
            closeModal('/');
        }
    }
}
</script>

<style scoped>

</style>
