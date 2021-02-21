<template>
    <ul id = "teacherList" v-if = "Object.keys(teachers).length">
        <li>
            <router-link to = "/teacherList/archived"><b>ARCHIVED</b></router-link>
        </li>
        <li v-for = "teacher in teachers">
            <router-link :to = "'/teacherComp/' + teacher.id">{{ teacher.name }}</router-link>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/teacherComp/create', 1)">+</label>
        </div>
    </ul>

    <ul id = "teacherList" v-else>
        <li>
            <a>You have not yet created any teachers.</a>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/teacherComp/create', 1)">+</label>
        </div>
    </ul>
</template>

<script>
export default {
    data() {
        return {
            teachers: {}
        }
    },
    methods: {
        //Fetches list of teachers owned by user with archived = 0 in JSON format.
        getTeachers() {
            axios.get('/teacher/archived/0').then((response) => {
                this.teachers = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getTeachers()
    },
    name: "teacherList"
}
</script>
