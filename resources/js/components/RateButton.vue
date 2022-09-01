<template>
    <div>
        <button class="btn btn-primary" @click="rateUser(1)" v-text="buttonText1"></button>
        <button class="btn btn-primary" @click="rateUser(2)" v-text="buttonText2"></button>
        <button class="btn btn-primary" @click="rateUser(3)" v-text="buttonText3"></button>
        <button class="btn btn-primary" @click="rateUser(4)" v-text="buttonText4"></button>
        <button class="btn btn-primary" @click="rateUser(5)" v-text="buttonText5"></button>
    </div>
</template>

<script>
import { enableTracking } from '@vue/reactivity';

import axios from 'axios';
    export default {
        props: [
            'userId',
            'value'
        ],

        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                status: this.value,
            }
        },
        
        methods: {
            rateUser(num) {
                axios.post('/rate', {  
                    user: this.userId,
                    value: num
                })
                .then(response => {
                    this.status = response.data;

                    // alert(response.data);
                });
            }
        },

        // very bad in JS :(
        computed: {
            buttonText1() {
                if (!this.status || this.status < 1) {
                    return '0';
                }
                return '1';
            },

            buttonText2() {
                if (!this.status || this.status < 2) {
                    return '0';
                }
                return '1';
            },

            buttonText3() {
                if (!this.status || this.status < 3) {
                    return '0';
                }
                return '1';
            },

            buttonText4() {
                if (!this.status || this.status < 4) {
                    return '0';
                }
                return '1';
            },

            buttonText5() {
                if (!this.status || this.status < 5) {
                    return '0';
                }
                return '1';
            }
        }
    }    
</script>
