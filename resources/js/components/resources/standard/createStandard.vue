<template>
    <div>
        <div class = "formLabel">
            <p class = "labelClass">Add Standard</p>
        </div>
        <div id = "tabsDiv">
            <!-- The ternary makes sure that the tab is highlighted if the url is just '/standardComp/create/{sheetId}'. -->
            <!-- That's necessary because that url is aliased to '/standardComp/create/{sheetId}/select'. -->
            <!-- It is therefore the default, so we need something other than router-link-active for the CSS. -->
            <router-link :to = "'/standardComp/create/' + this.$route.params.id + '/select'" tag = "div"
             v-bind:class = "['tab', this.$route.path.replace('/standardComp/create/').indexOf('/') === -1 ? 'activeOn' : '']">
                STANDARD SELECT
            </router-link>
            <router-link :to = "'/standardComp/create/' + this.$route.params.id + '/manual'"
                         class = "tab" tag = "div">
                MANUAL INPUT
            </router-link>
            <router-link :to = "'/standardComp/create/' + this.$route.params.id + '/groupBased'"
                         tag = "div" class = "tab">
                GROUP BASED STANDARDS
            </router-link>
        </div>
        <div class = "formCont" style = "margin-top: 0px">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "createStandard",
}
</script>
