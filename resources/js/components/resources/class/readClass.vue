<template ref = "classPage">
    <div>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">{{ classInfo.name }}
                <i class="fas fa-edit" v-if = "classInfo['ownerId'] == userId"
                   :onclick = "'openModal(\'/classComp/' + this.$route.params.id + '/update\', 1)'"></i>
            </p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/classComp/{id}'. -->
            <!-- That's necessary because that url is aliased to '/classComp/{id}/students'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link :to = "'/classComp/' + this.$route.params.id + '/students'" tag = "div"
             v-bind:class = "['tab', this.$route.path.replace('/classComp/').indexOf('/') === -1 ? 'activeOn' : '']">
                    STUDENTS
            </router-link>
            <router-link :to = "'/classComp/' + this.$route.params.id + '/spreadsheets'" tag = "div" class = "tab">
                SPREADSHEETS
            </router-link>
            <router-link :to = "'/classComp/' + this.$route.params.id + '/query'" tag = "div" class = "tab">
                STANDARD PROGRESS
            </router-link>
        </div>

        <router-view ref = "classInteriorView"></router-view>
    </div>
</template>

<script>
export default {
    name: "readClass",
    data() {
      return {
          classInfo: {},
          //For perms.
          userId: null
      }
    },
    methods: {
        //Get info about class from API.
        getClassInfo() {
            var classId = this.$route.params.id;
            axios.get('/class/' + classId).then((response) => {
                this.classInfo = response.data
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
        this.getClassInfo();
    }
}
</script>
