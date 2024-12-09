<template lang="">
    <div>
        <div v-if="hasAccess">
        <router-link :to="{ name: 'index.post'}">Posts </router-link>
        <router-link :to="{ name: 'create.post'}">Create </router-link>
        <router-link :to="{ name: 'user.personal'}">Personal </router-link>
        <a @click.prevent="logout()" href="#">Logout</a>
        </div><div v-if="!hasAccess">
        <router-link :to="{ name: 'user.login'}">Login </router-link>
        <router-link :to="{ name: 'user.registration'}">Registration </router-link>
        </div>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    name: "Index",
    data() {
        return {
            hasAccess: false,
            title:'',
        }
    },
    watch: {
        $route(to, from) {
            this.hasAccess = localStorage.getItem('authorized')
        }
    },
    methods: {
        logout() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/logout')
                    .then(res => {
                        localStorage.removeItem('authorized')
                        this.$router.push({ name: 'user.login' })
                    })
            })
        }
    },
}
</script>
<style lang="">

</style>