<template>
    <div v-if = "Object.keys(groups).length">
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Groups</p>
        </div>

        <table class = "resourceTab">
            <tbody>
            <tr v-for = "group in groups">
                <td style = "text-align: center">
                    <router-link :to = "'/groupComp/' + group.id" class = "tableText">
                        {{ group.name }}
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div v-else>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Groups</p>
        </div>
        <p class = "textLarge">You have not yet archived any groups.</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            groups: {}
        }
    },
    methods: {
        //Fetches list of groups owned/joined by user with archived = 1 in JSON format.
        getGroups() {
            axios.get('/group/archived/1').then((response) => {
                this.groups = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getGroups()
    },
    name: "groupArchived"
}
</script>
