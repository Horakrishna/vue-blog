<template>
    <div>
        <h1 ref="myfer">This is Hooks page.</h1>
        <h1>My name is {{name}}.</h1>
    </div>
</template>
<script>
export default{
    data(){
        return{
            name:'hora krishna roy'
        }
    }, 
    beforeCreate(){
        console.log(this.name)
    },
    created(){
        //call initial data from it

        console.log('Data and other function is available but not html',this.name)
    },
    mounted(){
        console.log(this.$refs.myfer)
    }
}
</script>