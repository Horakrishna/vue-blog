<template>
    <div>
        <h2>The Number is :{{view}}</h2>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">decrease</button>
        <br><br>
        <div v-for="(blog,i) in blogs" :key="i">
            <h2>{{blog.title}}</h2>
            <p>{{blog.post}}</p>
        </div>
     <br><br>
        <div>
            <h2 v-if="showItem">Show this item if "showItem" is true</h2>
            <h2 v-if="!showItem">Show this item if "showItem" is false</h2>
         </div> 
         <button @click="showItem =!showItem">Change</button>  
    </div>
</template>
<script>
export default {
    data(){
        return{
        view: 0,
        blogs:[],
        showItem:false
        }
    },
    methods: {
        updateCounter(number){
            this.view +=number
        },
        // chaneshowItem(){
        //     this.showItem =!this.showItem
        // }
    },
    created(){
        //Call the server to get the view of this blog
        this.view= 100
        //get the blog post
        let posts =[
            {title: 'This is blog title1', 'post':'this is blog post1', id:1},
            {title: 'This is blog title2', 'post':'this is blog post2', id:2},
            {title: 'This is blog title3', 'post':'this is blog post3', id:3},
            {title: 'This is blog title4', 'post':'this is blog post4', id:4},
            {title: 'This is blog title5', 'post':'this is blog post5', id:5},
        
        ]
        this.blogs =posts
    }
}
</script>