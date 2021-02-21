<template>
    <div class = "formCont">
        <div class="formLabel">
            <p class="labelClass">Share Class with Group</p>
        </div>

        <form id = "standardForm" @submit.prevent = "shareClass()">
            <div class = "form-group">
                <div class = "floating-label">
                    <select class = "floating-select" id = "classes"
                            v-model = "selectedClass">
                        <option disabled selected></option>
                        <option v-for = "userOwnedClass in classes" :value = "userOwnedClass['id']"> {{ userOwnedClass['name'] }} </option>
                    </select>
                    <label class = "form-control-placeholder" for = "classes">Class</label>
                </div>
            </div>

            <input type = "submit" value = "SHARE"/>
        </form>
    </div>
</template>

<script>
export default {
    name: "shareClass",
    data() {
        return {
            classes: {},
            selectedClass: null
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
        },
        //shares class with group.
        shareClass() {
            axios.post('/sharedClass', {
                classId: this.selectedClass,
                groupId: this.$route.params.id
            });

            //Update UI.
            var classList = window.app.$refs['navTab'].$refs['groupInteriorView'];
            classList.getSharedClasses();

            closeModal('/');
        }
    },
    mounted() {
        this.getClasses()
    }
}
</script>
