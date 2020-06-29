<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                <h1>This is Use All Component.</h1>
                <h2>This is Master  counter is :{{  counter }}</h2>
                <div class="space"></div>

                <div>
                    <ComA></ComA>
                </div>
                <div>
                   <ComB></ComB> 
                </div>
                <div>
                   <ComC></ComC> 
                </div>
                
                <Button type="info" @click="changeValue">Change The State Counter</Button>
			</div>
           
        </div>
    </div>
</template>

<script>
import ComA from './coma' 
import ComB from './comB'
import ComC from './comC'
import {mapGetters, mapActions} from 'vuex'
export default {
    data() {
        return{

        }
    },
    methods:{
        ...mapActions([
            'changeCounterAction'
        ])
    },
    computed:{
        ...mapGetters({
            'counter' :'getCounter'
        })
    },
    methods: {
        changeValue(){
            this.$store.dispatch('changeCounterAction',1)
            //this.$store.commit('changeTheValue',1)
        }
    },
    created(){
        console.log(this.$store.state.counter)
    },
    components :{
        ComA,
        ComB,
        ComC
    },
    watch : {
        counter(value){
            console.log('counter is Changing', value)
        }
    }
}
</script>