<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create Class</p>
        </div>
        <form id = "classForm" @submit.prevent = "createClass()">
            <div class = "form-group">
                <input type = "text" id = "className" name = "className" v-model = "className" class = "form-control">
                <label class = "form-control-placeholder" for = "className">Class' Name</label>
            </div>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "createClass",
    data() {
        return {
            className : ''
        }
    },
    methods: {
        //Trigger store method in controller
        createClass() {
            axios.post('/class', {
                className: this.className
            });
            //Re-render class list in sidebar.
            window.app.$refs['classList'].getClasses();
            closeModal('/');
        }
    }
}
</script>
