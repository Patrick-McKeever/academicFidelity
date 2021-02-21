<template>
    <div>
        <table class = "resourceTab">
            <tr>
                <td><b>Join Code:</b> {{ groupInfo['joinCode'] }}</td>
            </tr>
        </table>

        <slg-list ref = "slgList" :sheet = "false" :id = "this.$route.params.id"></slg-list>

        <standard-list ref = "standardList" :sheet = "false" :id = "this.$route.params.id"></standard-list>
    </div>
</template>

<script>
import StandardList from "../standard/standardList";
export default {
    name: "groupInfo",
    components: {StandardList},
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
