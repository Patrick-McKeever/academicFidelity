<template>
    <div>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">{{ groupInfo.name }}
                <i class = "fas fa-edit" v-if = "userId == groupInfo.ownerId"
                   :onclick = "'openModal(\'/groupComp/' + this.$route.params.id + '/update\', 1)'"></i>
                <!-- Owner cannot leave group. -->
                <i class = "fas fa-sign-out-alt" v-else
                   :onclick = "'openModal(\'/leaveGroup/' + this.$route.params.id + '\', 1)'"></i>
            </p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/classComp/{id}'. -->
            <!-- That's necessary because that url is aliased to '/classComp/{id}/students'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link :to = "'/groupComp/' + this.$route.params.id + '/sharedClasses'" tag = "div"
                         v-bind:class = "['tab', this.$route.path.replace('/groupComp/').indexOf('/') === -1 ? 'activeOn' : '']">
                CLASSES
            </router-link>
            <router-link :to = "'/groupComp/' + this.$route.params.id + '/members'" tag = "div" class = "tab">
                MEMBERS
            </router-link>
            <router-link :to = "'/groupComp/' + this.$route.params.id + '/query'" tag = "div" class = "tab">
                DATA QUERY
            </router-link>
            <router-link :to = "'/groupComp/' + this.$route.params.id + '/info'" tag = "div" class = "tab">
                GROUP INFO
            </router-link>
        </div>

        <router-view ref = "groupInteriorView"></router-view>
    </div>
</template>

<script>
export default {
    name: "readGroup",
    data() {
        return {
            groupInfo: {},
            userId: null
        }
    },
    methods: {
        //Get group info and user id.
        getGroupInfo() {
            var groupId = this.$route.params.id;
            axios.get('/group/' + groupId).then((response) => {
                this.groupInfo = response.data
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
        this.getGroupInfo()
    }
}
</script>
