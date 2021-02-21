<template>
    <ul id = "classList" v-if = "Object.keys(classes).length">
        <li>
            <router-link to = "/classList/archived"><b>ARCHIVED</b></router-link>
        </li>
        <li v-for = "userOwnedClass in classes">
            <router-link :to = "'/classComp/' + userOwnedClass.id">{{ userOwnedClass.name }}</router-link>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/classComp/create', 0)">+</label>
        </div>
    </ul>

    <ul id = "classList" v-else>
        <li>
            <a>You have not yet created any classes.</a>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/classComp/create', 0)">+</label>
        </div>
    </ul>
</template>

<script>
export default {
    data() {
        return {
            classes: {}
        }
    },
    methods: {
        //Fetches list of classes owned by user with archived = 0 in JSON format.
        getClasses() {
            axios.get('/class/archived/0').then((response) => {
              this.classes = response.data
            }).catch((errors) => {
              console.log(errors)
            });
        }
    },
    mounted() {
        this.getClasses()
    },
    name: "classList"
}
</script>
