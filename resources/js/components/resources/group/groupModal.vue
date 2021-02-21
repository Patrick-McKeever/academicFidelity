<template>
    <div>
        <div class = "formLabel">
            <p class = "labelClass">Create/Join Group</p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/groupComp/create/'. -->
            <!-- That's necessary because that url is aliased to '/standardComp/create/join'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link to = "/groupComp/create/join" tag = "div"
             v-bind:class = "['tab', this.$route.path.replace('/groupComp/create').indexOf('/') === -1 ? 'activeOn' : '']">
                JOIN
            </router-link>
            <router-link to = "/groupComp/create/make"
                         class = "tab" tag = "div">
                CREATE
            </router-link>
        </div>
        <div class = "formCont" style = "margin-top: 0px">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "groupModal"
}
</script>
