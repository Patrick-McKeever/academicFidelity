<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update Class</p>
        </div>
        <form id = "classForm" @submit.prevent = "updateClass()">
            <div class = "form-group">
                <input type = "text" id = "className" v-model = "classInfo.name" class = "form-control">
                <label class = "form-control-placeholder" for = "className">Class' Name</label>
            </div>
            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "archived" v-model = "classInfo.archived">
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
    name: "updateClass",
    data() {
        return {
            classInfo: {}
        }
    },
    methods: {
        //Get current classInfo
        getClassInfo() {
            var classId = this.$route.params.classId;
            axios.get('/class/' + classId).then((response) => {
                this.classInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Send update req to server.
        updateClass() {
            var classId = this.$route.params.classId;
            axios.put('/class/' + classId, {
                id: this.$route.params.classId,
                name: this.classInfo.name,
                archived: this.classInfo.archived
            })
            //Update UI to reflect changes.
            window.app.$refs['classList'].getClasses();
            window.app.$refs['navTab'].getClassInfo();
            closeModal('/');
        }
    },
    mounted() {
        this.getClassInfo();
    }
}
</script>
