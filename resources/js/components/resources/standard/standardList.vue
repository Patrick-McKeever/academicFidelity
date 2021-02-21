<template>
    <div>
        <div class = "container">
            <p class = "containerLabel">Aligned Standards:</p>
            <div  v-if = "JSON.parse(info['standards']).length">
                <ul class = "standardList">
                    <li v-for = "(standard, index) in JSON.parse(info['standards'])" class = "mainBoxText">
                        {{ standard }}
                        <i style="font-size: 15px; color: #000; display: inline" class="fa fa-window-close" aria-hidden="true"
                            v-if = "userId == info['ownerId']"
                            :onclick = "'openModal(\'/standardComp/delete/' + id + '/' + index + '/' + (sheet ? 1 : 0) + '\', 1)'"></i>
                    </li>
                </ul>
                <!-- All users can edit their own spreadsheets, but only group owners can edit group standards. -->
                <p class = "addSheetMetadata" style = "display: inline-block" v-if = "userId == info['ownerId']">
                    <label v-if = "sheet" :onclick = "'openModal(\'/standardComp/create/' + id + '\', 1)'">
                        <i class="fa fa-plus"></i>
                    </label>
                    <label v-else :onclick = "'openModal(\'/standardCompGroup/create/' + id + '\', 1)'">
                        <i class="fa fa-plus"></i>
                    </label>
                </p>
            </div>

            <div v-else>
                <ul>
                    <li class = "mainBoxText">You have not yet input any standards. Use the "plus" symbol to do so.</li>
                </ul>
                <p class = "addSheetMetadata" style = "display: inline-block" v-if = "userId == info['ownerId']">
                    <label v-if = "sheet" :onclick = "'openModal(\'/standardComp/create/' + id + '\', 1)'">
                        <i class="fa fa-plus"></i>
                    </label>
                    <label v-else :onclick = "'openModal(\'/standardCompGroup/create/' + id + '\', 1)'">
                        <i class="fa fa-plus"></i>
                    </label>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "standard-list",
    props: {
        //Are we retrieving SLGs of spreadsheet or group (bool)?
        sheet: {
            required: true
        },
        //Id of sheet/group
        id: {
            required: true
        }
    },
    data() {
        return {
            //Info for sheet/group
            info: {},
            //For perms.
            userId: null
        }
    },
    methods: {
        getInfo() {
            var url = this.sheet ? '/spreadsheet/' : '/group/';

            axios.get(url + this.id).then((response) => {
                this.info = response.data
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
        this.getInfo()
    }
}
</script>
