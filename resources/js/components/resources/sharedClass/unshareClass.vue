<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Unshare Class</p>
        </div>
        <form @submit.prevent = "unshareClass()" class = "deleteForm">
            <input type = "submit"value = "UNSHARE">
        </form>
    </div>
</template>

<script>
export default {
    name: "unshareClass",
    methods: {
        //Unshare the class from the group.
        unshareClass() {
            axios.delete('/sharedClass/' + this.$route.params.id);

            //Update UI.
            var classList = window.app.$refs['navTab'].$refs['groupInteriorView'];
            classList.getSharedClasses();

            closeModal('/');
        }
    }
}
</script>
