<template ref = "classPage">
    <div>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">{{ teacherInfo.name }}
                <i class="fas fa-edit" :onclick = "'openModal(\'/teacherComp/' + this.$route.params.id + '/update\', 1)'"></i>
            </p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/teacherComp/{id}'. -->
            <!-- That's necessary because that url is aliased to '/teacherComp/{id}/0'. -->
            <router-link :to = "'/teacherComp/' + this.$route.params.id + '/observations'" tag = "div"
                         v-bind:class = "['tab', this.$route.path.replace('/teacherComp/').indexOf('/') === -1 ? 'activeOn' : '']">
                OBSERVATIONS
            </router-link>
            <router-link :to = "'/teacherComp/' + this.$route.params.id + '/preObservations'" tag = "div" class = "tab">
                PRE-OBSERVATIONS
            </router-link>
        </div>

        <router-view ref = "teacherView"></router-view>
    </div>
</template>

<script>
export default {
    name: "readTeacher",
    data() {
        return {
            teacherInfo: {}
        }
    },
    methods: {
        //Get info about class from API.
        getTeacherInfo() {
            var teacherId = this.$route.params.id;
            axios.get('/teacher/' + teacherId).then((response) => {
                this.teacherInfo = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getTeacherInfo();
    }
}
</script>
