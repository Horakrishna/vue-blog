<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30  _p20 col-md-4">
                        <div slot="login-header" class="text-center">
							<h2>Login to Dashboard</h2>
						</div>
                        <div class="space">
                            <Input  type="email" v-model="data.email" placeholder="Enter Your Email" />
                        </div>
                        <div class="space">
                            <Input type="password" v-model="data.password" placeholder="Enter Your Password" />
                        </div>
                        <div slot="login-footer" class="text-center ">
							<Button type="primary" @click="login" :disabled="isLoging" :loading="isLoging">{{ isLoging ? 'Loging..': 'Login'}}</Button>
						</div>
				</div>
			</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            data:{
                email    :'',
                password :''
            },
            isLoging :false
        }
    },
    methods :{
        async login(){
            if(this.data.email.trim()==''   ) return this.e('Email number is required')
            if(this.data.password.trim()=='') return this.e('Password  is required')
            if(this.data.password.length < 6) return this.e('Incorrect Login Details')
            this.isLoging =true

           const res =await this.callApi('post','app/admin-login',this.data)
            if(res.status === 200){
                this.s(res.data.msg)
            }else{ 
                
                if(res.status === 401){
                    this.i(res.data.msg)
                }else if(res.status ==422)
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                        
                    }else{
                    this.swr()
                }
            }
            this.isLoging =false
         }
         
    }
}
</script>

<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 120px;
    }
</style>