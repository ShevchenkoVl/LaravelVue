<template lang="">
    <div class="w-75 text-center">
        <div v-if="posts" class="row row-cols-5 pt-5">
            <div v-for="post in posts.data" class="col" >
                <div class="row d-block" >
                    <div @click.prevent="show(post.id)" class="row btn" >
                        <img v-if="post.images != 0" :src="post.images[0].preview_url" class="mb-1">
                        <img v-else alt="preview_Image" class="mb-5">
                        <h4>{{ post.title }}</h4>
                    </div>
                    <div class="" ><input @click.prevent="update(post.id)" type="submit" class="btn btn-primary mt-3" value="update"></div>
                </div>
            </div>
        </div>
        <div class="">
            <a href="#" v-if="is_visible" @click.prevent="getPost()" class="btn btn-dark">More</a>
        </div>
    </div>
</template>
<script>
export default {
    name: "Index",

    data() {
        return {
            page: 0,
            posts: null,
            is_visible: false,
        }
    },

    mounted() {
        this.getPost()
    },
    methods: {
        getPost() {
            axios.get('/api/posts', {
                params: {
                    page: ++this.page
                }
            })
                .then(res => {
                    //initialization to show first posts if they are
                    if (this.posts !== null) {
                        this.posts.data = [...this.posts.data, ...res.data.data]
                        this.posts.meta.to = res.data.meta.to
                    }
                    else
                        this.posts = res.data
                    //this.post = res.data.data

                    //set is_visible = true when we have more posts
                    this.is_visible = this.posts.meta.to < this.posts.meta.total
                })
                .catch(err => {
                    console.log(err.responce)
                })
        },
        show(id) {
            //go to page of chosen post
            this.$router.push({ name: 'show.post', params: { id: id } })
        },
        update(id) {
            //update one chosen post
            this.$router.push({ name: 'update.post', params: { id: id } })
        },
    }
}
</script>
<style lang="">

</style>