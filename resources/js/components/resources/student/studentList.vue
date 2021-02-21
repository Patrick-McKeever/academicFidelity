<template ref = "studentList">
    <div v-if = "students.length">
        <table class = "resourceTab">
            <tbody>
                <tr v-for = "student in students">
                    <td>
                        <a class = "tableText"
                           :onclick = "'openModal(\'/studentComp/' + student.id + '/performance\', 1)'">
                            {{ student.name }}
                        </a>
                    </td>
                    <td>
                        <label v-if = "classInfo['ownerId'] == userId" class = "tableText"
                               :onclick = "'openModal(\'/studentComp/' + student.id + '/update\', 0)'">
                            <i class = "far fa-edit"></i>
                        </label>
                    </td>
                    <td>
                        <label v-if = "classInfo['ownerId'] == userId" class = "tableText"
                               :onclick = "'openModal(\'/studentComp/' + student.id + '/delete\', 0)'">
                            <i class = "far fa-window-close"></i>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <i class="fas fa-plus-circle addButton" v-if = "classInfo['ownerId'] == userId"
           :onclick = "'openModal(\'/studentComp/create/' + this.$route.params.id + '\', 0)'"></i>
    </div>

    <div v-else>
        <p class = "textLarge">You haven't added any students. Use the "plus" button in the bottom right to do so.</p>

        <i class="fas fa-plus-circle addButton" v-if = "classInfo['ownerId'] == userId"
           :onclick = "'openModal(\'/studentComp/create/' + this.$route.params.id + '\', 0)'"></i>
    </div>
</template>

<script>
export default {
    data() {
        return {
            classInfo: {},
            students: {},
            userId: null
        }
    },
    methods: {
        //Fetches list of students inside this class.
        getStudents() {
            var classId = this.$route.params.id;
            axios.get('/class/' + classId).then((response) => {
                this.classInfo = response.data
                this.students = response.data['students']
            }).catch((errors) => {
                console.log(errors)
            });

            //For perms.
            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getStudents()
    },
    name: "studentList"
}
</script>

<style scoped>

</style>
