<template>
    <div v-if = "Object.keys(classes).length">
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Classes</p>
        </div>

        <table class = "resourceTab">
            <tbody>
                <tr v-for = "userOwnedClass in classes">
                        <td style = "text-align: center">
                            <router-link :to = "'/classComp/' + userOwnedClass.id" class = "tableText">
                                {{ userOwnedClass.name }}
                            </router-link>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-else>
        <div class = "formLabel" style = "border: none">
            <p id = "classLabel">Archived Classes</p>
        </div>
        <p class = "textLarge">You have not yet archived any classes.</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            classes: {}
        }
    },
    methods: {
        //Fetches list of classes owned by user with archived = 1 in JSON format.
        getClasses() {
            axios.get('/class/archived/1').then((response) => {
                this.classes = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getClasses()
    },
    name: "classArchived"
}
</script>
