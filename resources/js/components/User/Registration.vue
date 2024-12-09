<template lang="">
    <div>
        <div class="w-25">
        <input v-model="name" type="text" placeholder="Name" class="form-control mb-3 mt-2">
        <input v-model="email" type="email" placeholder="email" class="form-control mb-3">
        <input v-model="password" type="password" placeholder="password" class="form-control mb-3">
        <input v-model="password_confirm" type="password" placeholder="password confirmation" class="form-control mb-3">
        <input :disabled="IsFulfilled() ? false : true"  @click.prevent="registration()" type="submit" value="register" class="btn btn-primary">
        </div>
    </div>
</template>
<script>
export default {
    name: "Registration",
    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirm: "",
        }
    },
    methods: {
        IsFulfilled() {
            return !!this.name & !!this.email & !!(this.password === this.password_confirm)
        },
        registration() {
            axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post( '/register', {name: this.name, email: this.email, password: this.password, password_confirmation: this.password_confirm})
            .then ( res => {
                localStorage.setItem('authorized', true)
                this.$router.push({name: 'user.personal'})
            })
            .catch ( err => {
                    console.log(err)
                })
            })
        }

    },
}
</script>
<style lang="">

</style>