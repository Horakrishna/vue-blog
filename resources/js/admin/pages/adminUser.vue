<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"> User<Button @click="addModal=true"><Icon type="ios-add-circle-outline" />Add User</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>User Name</th>
								<th>User Email</th>
								<th>User Type</th>
								<th>Creation Date</th>
								<th>Action</th>
							
							</tr>
								
							<tr v-for="(user, i) in users" :key="i">
								<td class="table_name">{{user.fullName}}</td>
								<td class="table_email">{{user.email}}</td>
								<td class="table_name">{{user.userType}}</td>
								<td format="yyyy/MM/dd">{{user.created_at | timeformat }}</td>
								<td>
									<Button type="info" size="small" @click="showeditModal(user, i)">Edit</Button>
									<Button type="error" size="small" @click="showdeletingModal(user, i)"  :loading="user.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Add Model -->
				<Modal v-model="addModal" title="Add Category" :mask-closable="false" :closable="false" >
                    
                        <div class="space">
                            <Input v-model="data.fullName" placeholder="Enter Your Full Name" />
                        </div>
                        <div class="space">
                            <Input v-model="data.email" placeholder="Enter Your Email" />
                        </div>
                        <div class="space">
                            <Input type="password" v-model="data.password" placeholder="Enter Your Password" />
                        </div>
                        <div class="space">
                            <Select v-model="data.userType"  placeholder="Select admin type">
                                <Option value="Admin" >Admin</Option>
                                <Option value="Editor" >Editor</Option>
                            </Select>
                        </div>
                        
						<div slot="footer">
							<Button type="success" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Admin' }}</Button>
							<Button type="primary" @click="addModal=false">Close</Button>
						</div>

				</Modal>

				<!--Edit Model -->
				<Modal v-model="editModal" title="Edit Admin" :mask-closable="false" :closable="false" >
						
						  <div class="space">
                            <Input v-model="editData.fullName" placeholder="Edit Your Full Name" />
                        </div>
                        <div class="space">
                            <Input v-model="editData.email" placeholder="Edit Your Email" />
                        </div>
                        <div class="space">
                            <Input type="password" v-model="editData.password" placeholder="Enter Your Password" />
                        </div>
                        <div class="space">
                            <Select v-model="editData.userType"  placeholder="Edit admin type">
                                <Option value="Admin" >Admin</Option>
                                <Option value="Editor" >Editor</Option>
                            </Select>
                        </div>
						<div slot="footer">
							<Button type="success"  @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'editing...' : 'Update Admin' }}</Button>
							<Button type="primary"  @click="closeEditModel">Close</Button>

						</div>
				</Modal>
				<!--Delete Modal -->
				<deleteModal></deleteModal>
			</div>
		</div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModel'
import { mapGetters } from 'vuex'
export default {
	 data(){
		 return {
			 data :{
				fullName   : '',
				email      : '',
				password   : '',
				userType   : 'Admin'
			 },
			 addModal   : false,
			 editModal  : false,
			 isAdding   : false,
			 users      :[],
			 editData   :{
				fullName   : '',
				email      : '',
				password   : '',
				userType   : 'Admin'
			 },
			 index : -1,
			 isDeleting: false,
			 showDeleteModel: false,
			 deleteItem: {},
             deletingIndex: -1,
			 token  : '',
			 iconImageName: false,
			 isEditingItem:false
		 	}
		},

		methods : {
			async addAdmin(){
				 if(this.data.fullName.trim()=='')return this.e('User name is required')
				 if(this.data.email.trim()=='')return this.e('User Email  required')
				 if(this.data.password.trim()=='')return this.e('User Password required')
				 if(this.data.userType.trim()=='')return this.e('User Type  required')
				 const res =await this.callApi('post','app/create_user', this.data)
				 if(res.status===201){
					 this.users.unshift(res.data)
					 this.s('Admin User has been added successfully')
						this.addModal= false,
						this.data.fullName    =''
						this.data.email       =''
						this.data.password    =''
						this.data.userType    =''
				 }else{
					 if(res.status===422){
						 if(res.data.errors.fullName){
							 this.i(res.data.errors.fullName[0])
						 }
						 if(res.data.errors.email){
							 this.i(res.data.errors.email[0])
						 }
						 if(res.data.errors.password){
							 this.i(res.data.errors.password[0])
						 }
						 if(res.data.errors.userType){
							 this.i(res.data.errors.userType[0])
						 }
					 }else{
 							this.swr()
					 }
					
				 }
			 },
			async editAdmin(){
				 if(this.editData.fullName.trim()=='') return this.e('User name is required')
				 if(this.editData.email.trim()=='') return this.e('Email Icon is required')
				 if(this.editData.userType.trim()=='') return this.e('User Type is required')
				 const res = await this.callApi('post','app/edit_user', this.editData)
				 if(res.status===200){
					 this.users[this.index] = this.editData
					 this.s('User has been Edited successfully')
						this.editModal= false
				 }else{
					 if(res.status === 422){
						 
						for(let i in res.data.errors){

                        this.e(res.data.errors[i][0])
                   		}
					 }else{
 							this.swr()
					}
					
				}
			},
			showeditModal(user,index){
				let obj={
					id          : user.id,
					fullName    : user.fullName, 
					email       : user.email, 
					userType    : user.userType, 
				}
				this.editData = obj
				this.editModal= true
				this.index    = index
			},
			
			showdeletingModal(category, i){
				const deleteModalObj = {
						showDeleteModel :true,
						deleteUrl       :'app/detete_category',
						data            :category,
						deletingIndex   : i,
						isDeleted       :false
				}
				this.$store.commit('setDeletingModalObj', deleteModalObj)
				console.log('delete method called')


				// this.deleteItem = tag
				// this.deletingIndex = i
				// this.showDeleteModel = true
			},
			handleSuccess (res, file) {
				res = `/uploads/${res}`
				if(this.isEditingItem){
					return this.editData.iconImage = res
				}
               this.data.iconImage = res
            },
			handleError (res, file) {
			    this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong !'}`
                });
			},
			
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
			},
			
            handleMaxSize (file) {

                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
			async deleteImage(isAdd = true ){
				let image
				if(!isAdd){
					this.iconImageName = true
					image = this.editData.iconImage
					this.editData.iconImage = ''
					this.$refs.editUploads.clearFiles()
				}else{
					image = this.data.iconImage
					this.data.iconImage = ''
					this.$refs.uploads.clearFiles()
				}
				
				const res =await this.callApi('post','app/delete_image',{ imageName :image})
				if(res.status != 200){
					this.data.iconImage = image
					this.swr()
				}
			},
			closeEditModel(){
				this.isEditingItem  = false
				this.editModal      = false
			}
			
		},
		async created(){
            this.token =window.Laravel.csrfToken
				const res = await this.callApi('get','app/get_users')
				if(res.status == 200){
					this.users = res.data
				}else{
					this.swr()
				}
		},
		
		components : {
			deleteModal
		},
		computed : {
			...mapGetters(['getDeleteModalObj'])
		},
		watch : {
		getDeleteModalObj( obj ){
	       if(obj.isDeleted){
			   	this.categories.splice(obj.deletingIndex, 1)
		   }
			
		}
	}
		
}
</script>