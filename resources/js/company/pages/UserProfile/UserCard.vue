<template>
    <card class="card-user">
        <img slot="image"
             src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
             alt="..."/>
        <div class="author">
            <a href="#">
                <img class="avatar border-gray" v-bind:src="auth.user.avatar_path" alt="..."/>
                <h4 class="title">{{auth.user.full_name}}<br/>
                    <small>{{auth.user.user_name}}</small>
                </h4>
            </a>
        </div>

        <div slot="footer" class="text-center d-flex justify-content-center">
            <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
            <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
            <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>
        </div>
    </card>
</template>
<script>
    import Card from '../../components/Cards/Card.vue'
    import {mapGetters} from "vuex";

    export default {
        components: {
            Card
        },
        computed:{
            ...mapGetters([
                'auth'
            ])
        },
        methods: {
            getClasses(index) {
                var remainder = index % 3
                if (remainder === 0) {
                    return 'col-md-3 col-md-offset-1'
                } else if (remainder === 2) {
                    return 'col-md-4'
                } else {
                    return 'col-md-3'
                }
            }
        }
    }

</script>
<style>

</style>
