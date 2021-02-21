<template>
    <div>
        <div class = "formLabel">
            <p class = "labelClass">Edit SLG</p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/slgComp/create/{id}'. -->
            <!-- That's necessary because that url is aliased to 'slgComp/create/{id}/edit'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link :to = "'/slgComp/create/' + this.$route.params.id + '/edit'" tag = "div"
             v-bind:class = "['tab', this.$route.path.replace('/slgComp/create/').indexOf('/') === -1 ? 'activeOn' : '']">
                CREATE/EDIT SLG
            </router-link>
            <router-link :to = "'/slgComp/create/' + this.$route.params.id + '/myPastSlgs'"
                         class = "tab" tag = "div">
                MY PAST SLGs
            </router-link>
            <router-link :to = "'/slgComp/create/' + this.$route.params.id + '/groupBased'"
                         tag = "div" class = "tab">
                GROUP BASED SLGs
            </router-link>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "createSlg"
}
</script>
