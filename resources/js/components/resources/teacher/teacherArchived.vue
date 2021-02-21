<template>
    <div v-if = "Object.keys(teachers).length">
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Teachers</p>
        </div>

        <table class = "resourceTab">
            <tbody>
            <tr v-for = "teacher in teachers">
                <td style = "text-align: center">
                    <router-link :to = "'/teacherComp/' + teacher.id" class = "tableText">
                        {{ teacher.name }}
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div v-else>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Teachers</p>
        </div>
        <p class = "textLarge">You have not yet archived any teachers.</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teachers: {}
        }
    },
    methods: {
        //Fetches list of classes owned by user with archived = 1 in JSON format.
        getTeachers() {
            axios.get('/teacher/archived/1').then((response) => {
                this.teachers = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getTeachers()
    },
    name: "teachersArchived"
}
</script>
