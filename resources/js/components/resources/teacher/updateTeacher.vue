<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Update Teacher</p>
        </div>
        <form id = "classForm" @submit.prevent = "udpateTeacher()">
            <div class = "form-group">
                <input type = "text" id = "teacherName" v-model = "teacherInfo.name" class = "form-control">
                <label class = "form-control-placeholder" for = "teacherName">Teacher's Name</label>
            </div>

            <div class = "form-group">
                <input type = "text" id = "email" v-model = "teacherInfo.email" class = "form-control">
                <label class = "form-control-placeholder" for = "email">Teacher's Email</label>
            </div>

            <div class = "form-group">
                <input type = "text" id = "school" v-model = "teacherInfo.school" class = "form-control">
                <label class = "form-control-placeholder" for = "school">Teacher's School</label>
            </div>


            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "archived" v-model = "teacherInfo.archived">
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
    name: "updateTeacher",
    data() {
        return {
            teacherInfo: {}
        }
    },
    methods: {
        //Get current info about teacher.
        getTeacherInfo() {
            var teacherId = this.$route.params.id;
            axios.get('/teacher/' + teacherId).then((response) => {
                this.teacherInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Update teacher.
        udpateTeacher() {
            var teacherId = this.$route.params.id;
            axios.put('/teacher/' + teacherId, {
                name: this.teacherInfo['name'],
                email: this.teacherInfo['email'],
                school: this.teacherInfo['school'],
                archived: this.teacherInfo['archived']
            });

            //Update UI to reflect changes.
            window.app.$refs['teacherList'].getTeachers();
            window.app.$refs['navTabView'].getTeacherInfo();
            closeModal('/');
        }
    },
    mounted() {
        this.getTeacherInfo()
    }
}
</script>
