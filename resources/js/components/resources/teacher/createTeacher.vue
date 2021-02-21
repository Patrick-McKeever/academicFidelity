<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create Teacher</p>
        </div>
        <form id = "classForm" @submit.prevent = "createTeacher()">
            <div class = "form-group">
                <input type = "text" id = "teacherName" v-model = "name" class = "form-control">
                <label class = "form-control-placeholder" for = "teacherName">Teacher's Name</label>
            </div>

            <div class = "form-group">
                <input type = "text" id = "teacherEmail" v-model = "email" class = "form-control">
                <label class = "form-control-placeholder" for = "teacherEmail">Teacher's Email</label>
            </div>

            <div class = "form-group">
                <input type = "text" id = "teacherSchool" v-model = "school" class = "form-control">
                <label class = "form-control-placeholder" for = "teacherSchool">School Name</label>
            </div>

            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "createTeacher",
    data() {
        return {
            name: '',
            email: '',
            school: ''
        }
    },
    methods: {
        //Create teacher in database.
        createTeacher() {
            axios.post('/teacher', {
                name: this.name,
                email: this.email,
                school: this.school
            });

            //Re-render class list in sidebar.
            window.app.$refs['teacherList'].getTeachers();
            closeModal('/');
        }
    }
}
</script>
