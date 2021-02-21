<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update Student</p>
        </div>
        <form @submit.prevent = "updateStudent()">
            <div class = "form-group">
                <input type = "text" id = "studName" v-model = "studInfo.name" class = "form-control">
                <label class = "form-control-placeholder" for = "studName">Student's Name</label>
            </div>
            <div class = "form-group">
                <input type = "text" id = "studEmail" v-model = "studInfo.email" class = "form-control">
                <label class = "form-control-placeholder" for = "studEmail">Student's Email</label>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "updateStudent",
    data() {
        return {
            studInfo: {}
        }
    },
    methods: {
        //Get current student info.
        getStudInfo() {
            var studId = this.$route.params.studentId;
            axios.get('/classMember/' + studId).then((response) => {
                this.studInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Send update req to server.
        updateStudent() {
            var studId = this.$route.params.studentId;
            axios.put('/classMember/' + studId, {
                name: this.studInfo.name,
                email: this.studInfo.email
            })
            //Update UI to reflect changes.
            var component = window.app.$refs['navTab'].$refs['classInteriorView'];
            component.getStudents();
            closeModal('/');
        }
    },
    mounted() {
        this.getStudInfo();
    }
}
</script>
