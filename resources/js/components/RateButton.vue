<template>
    <div>
        <button class="btn btn-primary" @click="rateUser(1, $user->profile->id)">1</button>
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
        mounted() {
            console.log('Component mounted.')
        },
        
        methods: {
            rateUser(num) {
                // alert(num);
                axios.post('/rate', {  
                    user: 1,  
                    value: num
                })
                .then(response => {
                    alert(response.data);
                });
            }
        }
    }    
</script>
