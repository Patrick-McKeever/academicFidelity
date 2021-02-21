<template>
    <div class = "formCont">
        <div class = "formLabel">
            <p class = "labelClass">Create Student(s)</p>
        </div>
        <form @submit.prevent = "createStudent()">
            <table class = "textAreaTab">
                <tr>
                    <th>Names</th>
                    <th>Emails</th>
                </tr>
                <tr>
                    <td>
                        <textarea id = "students" name = "students" v-model = "students">
                            Input student names. Separate by newlines.
                        </textarea>
                    </td>
                    <td>
                        <textarea id = "emails" name = "emails" v-model = "emails">
                            Input student emails. Leave empty if none.
                        </textarea>
                    </td>
                </tr>
            </table>
            <input type = "submit" value = "SUBMIT">
        </form>
    </div>
</template>

<script>
export default {
    name: "createStudent",
    data() {
        return {
            students : '',
            emails: ''
        }
    },
    methods: {
        createStudent() {
            var studentArr = this.students.split('\n');
            var emailArr = this.emails.split('\n');

            //If there are more students than emails, pad emails, and vice versa.
            if(studentArr.length > emailArr.length)  {
                var lengthDiff = studentArr.length - emailArr.length;
                var newArr = new Array(lengthDiff).fill('');
                emailArr = emailArr.concat(newArr);
            } else if(emailArr.length > studentArr.length) {
                var lengthDiff = emailArr.length - studentArr.length;
                var newArr = new Array(lengthDiff).fill('');
                studentArr = studentArr.concat(newArr);
            }

            axios.post('/classMember', {
                students: studentArr,
                emails: emailArr,
                classId: this.$route.params.classId
            });
            //Re-render student list, close modal.
            var component = window.app.$refs['navTab'].$refs['classInteriorView'];
            component.getStudents();
            closeModal('/');
        }
    }
}
</script>
