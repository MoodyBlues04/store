<template>
    <div>
        <button class="btn btn-primary" @click="rateUser(1)">1</button>
        <button class="btn btn-primary" @click="rateUser(2)">2</button>
        <button class="btn btn-primary" @click="rateUser(3)">3</button>
        <button class="btn btn-primary" @click="rateUser(4)">4</button>
        <button class="btn btn-primary" @click="rateUser(5)">5</button>
    </div>
</template>

<script>
import { enableTracking } from '@vue/reactivity';

import axios from 'axios';
    export default {
        props: [
            'userId'
        ],

        mounted() {
            console.log('Component mounted.')
        },
        
        methods: {
            rateUser(num) {
                axios.post('/rate', {  
                    user: this.userId,
                    value: num
                })
                .then(response => {
                    alert(response.data);
                });
            }
        }
    }    
</script>
