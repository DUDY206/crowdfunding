<template>
    <b-tab v-bind:title="title" >
        <b-tabs>
            <b-tab title="vi">
                <b-form-group >
                    <p class="font-weight-bold mt-lg-3">Title (vi) <span class="text-danger font-italic"></span></p>
                    <b-form-input
                        v-model="datafield.title_vi"
                        type="text"
                        required
                    ></b-form-input>
                </b-form-group>

                <p class="font-weight-bold mt-lg-3 ">Nội dung (vi)<span class="text-danger font-italic"></span></p>
                <ckeditor
                    v-model="datafield.content_vi"
                    :config="config"
                ></ckeditor>
            </b-tab>
            <b-tab title="en">
                <b-form-group >
                    <p class="font-weight-bold mt-lg-3">Title (en) <span class="text-danger font-italic"></span></p>
                    <b-form-input
                        v-model="datafield.title_en"
                        type="text"
                        required
                    ></b-form-input>
                </b-form-group>

                <p class="font-weight-bold mt-lg-3 ">Nội dung (en)<span class="text-danger font-italic"></span></p>
                <ckeditor
                    v-model="datafield.content_en"
                    :config="config"
                ></ckeditor>
            </b-tab>
        </b-tabs>

        <b-form-group >
            <p class="font-weight-bold mt-lg-3">Thứ tự <span class="text-danger font-italic"></span></p>
            <b-form-input
                v-model="datafield.position"
                type="text"
                required
            ></b-form-input>
        </b-form-group>

        <slot></slot>
    </b-tab>
</template>

<script>
    import globalCKeditorConfig from "../../../globalCKeditorConfig";
    export default {
        name: "MutableField",
        props:{
            title:String,
            datafield: {
                type:Object,
                required:true,
            }
        },
        data(){
            return {
                config:globalCKeditorConfig,
                title_vi:"",
                content_vi:"",
                title_en:"",
                content_en:"",
                position:"",
            }
        },
        watch:{
            datafield(){
                this.$emit("mutabletab", this.datafield);
            },
        },

    }
</script>

<style scoped>

</style>
