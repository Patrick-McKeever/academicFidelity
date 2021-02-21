<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Delete {{ studInfo.name }}</p>
        </div>
        <form @submit.prevent = "deleteStudent()" class = "deleteForm">
            <input type = "submit"value = "DELETE">
        </form>
    </div>
</template>

<script>
export default {
    name: "deleteStudent",
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
        //Send delete req to server.
        deleteStudent() {
            var studId = this.$route.params.studentId;
            axios.delete('/classMember/' + studId);
            //Update UI to reflect deletion.
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
