<template lang="">
    <div class="w-25">
        <input v-model="email" type="email" placeholder="email" class="form-control mb-3 mt-2">
        <input v-model="password" type="password" placeholder="password" class="form-control mb-3">
        <input @click.prevent="login()" type="submit" value="login" class="btn btn-primary">
    </div>
</template>
<script>
export default {
    name: "Login",
    data() {
        return {
            email: null,
            password: null,
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                // Login...
                axios.post('/login', { email: this.email, password: this.password })
                .then ( res => {
                    if(res) {
                    localStorage.setItem('authorized', true)
                    this.$router.push({name: 'user.personal'})
                    }
                }
                )
                .catch ( err => {
                    console.log(err)
                })
            });
        }
    }
}
</script>
<style lang="">

</style>