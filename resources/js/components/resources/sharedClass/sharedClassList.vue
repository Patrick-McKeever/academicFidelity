<template>
    <div v-if = "sharedClasses.length">
        <table class = "resourceTab">
            <tbody>
            <tr v-for = "sharedClass in sharedClasses">
                <td>
                    <router-link class = "tableText" :to = "'/classComp/' + sharedClass.id">{{ sharedClass.name }}</router-link>
                </td>
                <td v-if = "sharedClass.ownerId == userId">
                    <label class = "tableText"
                       :onclick = "'openModal(\'/sharedClassComp/' + sharedClass.id + '/delete\', 1)'">
                        <i class = "far fa-window-close"></i>
                    </label>
                </td>
                <!-- This is purely for formatting reasons -->
                <td v-else></td>
            </tr>
            </tbody>
        </table>
        <i class="fas fa-share addButton" :onclick = "'openModal(\'/sharedClassComp/share/' + this.$route.params.id + '\', 1)'"></i>
    </div>

    <div v-else>
        <p class = "textLarge">No one has shared any classes as of yet. Use the "share" button in the bottom right to do so.</p>
        <i class="fas fa-share addButton" :onclick = "'openModal(\'/sharedClassComp/share/' + this.$route.params.id + '\', 1)'"></i>
    </div>
</template>

<script>
export default {
    name: "sharedClassList",
    data() {
        return {
            userId: null,
            sharedClasses: {}
        }
    },
    methods: {
        //Get shared classes, get user id.
        getSharedClasses() {
            var groupId = this.$route.params.id;

            axios.get('/sharedClass/' + groupId).then((response) => {
                this.sharedClasses = response.data
            }).catch((errors) => {
                console.log(errors)
            });

            axios.get('/userId').then((response) => {
                this.userId = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getSharedClasses();
    }
}
</script>
