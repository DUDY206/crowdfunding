<template>
    <card class="card-user">
        <img slot="image"
             src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
             alt="..."/>
        <div class="author">
            <a>
                <img class="avatar border-gray" @click="openModalCreateImage" v-bind:src="auth.user.avatar_path" alt="..."/>
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
        <div class="modal-create-image" v-if="isModalCreateImage">
            <div class="wrapper-modal">
                <div class="selection">
                    <input type="file" :v-model="avatar" id="avatar" ref="avatar" @change="previewimage">
                </div>
                <div class="filter-image" v-if="review_img != ''">
                    <img :src="review_img">
                </div>
                <div class="actions">
                    <button class="danger" @click="closeModalCreateImage">Quay lại</button>
                    <button class="primary" v-if="review_img != ''" @click="updateImage">Cập nhật</button>
                </div>
            </div>
        </div>
    </card>
</template>
<script>
    import {mapGetters} from "vuex";
    import Card from '../../components/Cards/Card.vue';
    import DotSpaceProgress from '../../../commons/DotSpaceProgress.vue';

    export default {
        components: {
            Card,
            DotSpaceProgress
        },
        props: {
            onLoading: Function,
            offLoading: Function,
        },
        computed:{
            ...mapGetters([
                'auth'
            ])
        },
        data() {
            return {
                avatar: null,
                review_img: '',
                isModalCreateImage: false,
            }
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
            },
            openModalCreateImage() {
                var self = this;

                self.isModalCreateImage = true;
            },
            closeModalCreateImage() {
                var self = this;

                self.isModalCreateImage = false;
                self.review_img = '';
            },
            previewimage(e) {
                var self = this;

                const reader = new FileReader();
                reader.onload = (load) => {
                    self.review_img = load.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
                self.avatar = e.target.files[0];
            },
            archiveForm() {
                var self = this;
                let formData = new FormData();

                formData.append('avatar', self.avatar);
                formData.append('name', 'admin');

                return formData;
            },
            updateImage() {
                var self = this;
                self.onLoading();

                let data = {
                    id: self.auth.user.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('editImageAdmin', data)
                .then((res) => {
                    self.$store.dispatch('getCurrentAdmin', self.auth.user.id)
                    .then(() => {
                        self.offLoading();
                        self.closeModalCreateImage();
                    })
                })
                .catch((err) => {
                    self.offLoading();
                    self.$toast.error(err[0].validator.customMessages.avatar);
                });
            }
        }
    }
</script>
<style lang="scss">
    .card-user .avatar {
        object-fit: cover;
        cursor: pointer;
    }

    .modal-create-image {
        position: fixed;
        top: 0;
        left: 260px;
        bottom: 0;
        right: 0;
        background: hsla(0,0%,8%,0.25);

        .wrapper-modal {
            display: flex;
            align-items: center;
            flex-direction: column;
            background: white;
            width: 300px;
            height: 320px;
            margin: 150px auto;
            padding: 10px;
            border-radius: 5px;

            .selection {
                font-size: 13px;
                padding-top: 10px;
            }

            .filter-image {
                margin-top: 20px;
                width: 190px;
                object-fit: cover;

                img {
                    width: 100%;
                }
            }

            .actions {
                margin-top: 15px;

                button {
                    background: none;
                    border-radius: 5px;
                    padding: 5px;
                    border: 1px solid #8a88ff66;
                }
            }
        }
    }

    .danger:hover {
        background: #e4303099 !important;
        color: white;
    }

    .primary:hover {
        background: #2654e2bd !important;
        color: white;
    }
</style>
