<template>
    <div class="d-flex flex-column align-items-center">
        <div>
            <button class="btn btn-primary" @click="rateUser(1)" v-text="buttonText(1)"></button>
            <button class="btn btn-primary" @click="rateUser(2)" v-text="buttonText(2)"></button>
            <button class="btn btn-primary" @click="rateUser(3)" v-text="buttonText(3)"></button>
            <button class="btn btn-primary" @click="rateUser(4)" v-text="buttonText(4)"></button>
            <button class="btn btn-primary" @click="rateUser(5)" v-text="buttonText(5)"></button>
            <button class="btn btn-secondary" @click="rateUser(-1)">X</button>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-2" style="width: 70px">
            <div>stars</div>
            <div class="text-center" v-text="avgFunc"></div>
        </div>
    </div>
</template>

<script>
import { enableTracking } from '@vue/reactivity';

import axios from 'axios';
    export default {
        props: [
            'userId',
            'value',
            'avgValue'
        ],

        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                status: this.value,
                avg: this.avgValue
            }
        },
        
        methods: {
            rateUser(num) {
                axios.post('/rate', {  
                    user: this.userId,
                    value: num
                })
                .then(response => {
                    this.status = response.data[0];
                    this.avg = response.data[1];

                    // console.log(response.data);
                })
                .catch(errors => {
                    if (errors.data.status == 401) {
                        window.location = '/login';
                    }
                });
            }
        },

        computed: {
            avgFunc() {
                return this.avg;
            },

            buttonText(num) {
                if (!this.status || this.status < num) {
                    return '0';
                }
                return '1';
            }
        }
    }    
</script>
