<template>
    <table class = "resourceTab">
        <tbody>
            <tr v-for = "member in groupMembers">
                <td style = "text-align: center">
                    {{ member['user']['name'] }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "groupMemberList",
    data() {
        return {
            //Group members. Self-exp.
            groupMembers: {}
        }
    },
    methods: {
        //Get group info and user id.
        getGroupInfo() {
            var groupId = this.$route.params.id;
            axios.get('/group/' + groupId).then((response) => {
                this.groupMembers = response.data['members']
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
