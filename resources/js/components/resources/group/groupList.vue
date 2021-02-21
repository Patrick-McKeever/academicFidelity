<template>
    <ul id = "groupList" v-if = "Object.keys(groups).length">
        <li>
            <router-link to = "/groupList/archived"><b>ARCHIVED</b></router-link>
        </li>
        <li v-for = "group in groups">
            <router-link :to = "'/groupComp/' + group.id">{{ group.name }}</router-link>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/groupComp/create', 0)">+</label>
        </div>
    </ul>

    <ul id = "groupList" v-else>
        <li>
            <a>You have not yet created/joined any groups.</a>
        </li>
        <div class = "addSidebar">
            <label class = "btn" onclick = "openModal('/groupComp/create', 0)">+</label>
        </div>
    </ul>
</template>

<script>
export default {
    name: "groupList",
    data() {
        return {
            groups: {}
        }
    },
    methods: {
        //Get non-archived groups.
        getGroups() {
            axios.get('/group/archived/0').then((response) => {
                this.groups = response.data
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getGroups()
    }
}
</script>
