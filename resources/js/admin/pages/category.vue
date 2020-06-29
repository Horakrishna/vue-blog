
<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blog Category<Button @click="addModal=true"><Icon type="ios-add-circle-outline" />Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>ID</th>
								<th>Category Name</th>
								<th>Icon image</th>
								<th>Action</th>
							</tr>
								
							<tr v-for="(category, i) in categories" :key="i">
								<td>{{category.id}}</td>
								<td class="_table_name">{{category.categoryName}}</td>
								<td class="table_image">
									<img :src="category.iconImage" />
								</td>
								<td>
									<Button type="info" size="small" @click="showeditModal(category, i)">Edit</Button>
									<Button type="error" size="small" @click="showdeletingModal(category, i)"  :loading="category.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Add Model -->
				<Modal v-model="addModal" title="Add Category" :mask-closable="false" :closable="false" >
						<Input v-model="data.categoryName" placeholder="Enter Your Category Name" />
                        <div class="space"></div>
                         <Upload
                            ref="uploads"
                            type="drag"
                            :headers="{'x-csrf-token': token, 'X-Requested-With' : 'XMLHttpRequest'}"
							:on-success="handleSuccess"
							:on-error="handleError"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
                            action="/app/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
						<div class="demo-upload-list" v-if="data.iconImage">
							<img :src="`${data.iconImage}`"/>
							 <div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
							</div>
						</div>
						<div slot="footer">
							<Button type="success" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Category' }}</Button>
							<Button type="primary" @click="addModal=false">Close</Button>
						</div>

				</Modal>

				<!--Edit Model -->
				<Modal v-model="editModal" title="Edit Category" :mask-closable="false" :closable="false" >
						<Input v-model="editData.categoryName" placeholder="Edit Your Category Name" />
                        <div class="space"></div>
                         <Upload v-show="iconImageName"
                            ref="editUploads"
                            type="drag"
                            :headers="{'x-csrf-token': token, 'X-Requested-With' : 'XMLHttpRequest'}"
							:on-success="handleSuccess"
							:on-error="handleError"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
                            action="/app/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
						<div class="demo-upload-list" v-if="editData.iconImage">
							<img :src="`${editData.iconImage}`"/>
							 <div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
							</div>
						</div>
						<div slot="footer">
							<Button type="success" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'editing...' : 'Update Category' }}</Button>
							<Button type="primary" @click="closeEditModel">Close</Button>

						</div>
				</Modal>
				<!--Delete Modal -->
				
			</div>
		</div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModel'

export default {
	 data(){
		 return {
			 data :{
				categoryName: '',
				iconImage   : ''
			 },
			 addModal   : false,
			 editModal  : false,
			 isAdding   : false,
			 categories :[],
			 editData   :{
				categoryName: '',
				iconImage   : ''
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
			async addCategory(){
				 if(this.data.categoryName.trim()=='')return this.e('Category name is required')
				 if(this.data.iconImage.trim()=='')return this.e('Image icon required')
				 this.data.iconImage =`${this.data.iconImage}`
				 const res =await this.callApi('post','app/create_category', this.data)
				 if(res.status===201){
					 this.categories.unshift(res.data)
					 this.s('Category has been added successfully')
						this.addModal= false,
						this.data.categoryName =''
						this.data.iconImage    =''
				 }else{
					 if(res.status===422){
						 if(res.data.errors.categoryName){
							 this.i(res.data.errors.categoryName[0])
						 }
						 if(res.data.errors.iconImage){
							 this.i(res.data.errors.iconImage[0])
						 }
					 }else{
 							this.swr()
					 }
					
				 }
			 },
			async editCategory(){
				 if(this.editData.categoryName.trim()=='') return this.e('Category name is required')
				 if(this.editData.iconImage.trim()=='') return this.e('Image Icon is required')
				 const res = await this.callApi('post','app/edit_category', this.editData)
				 if(res.status===200){
					 this.categories[this.index].categoryName = this.editData.categoryName
					 this.categories[this.index].iconImage    = this.editData.iconImage
					 this.s('Category has been Edited successfully')
						this.editModal= false
				 }else{
					 if(res.status===422){
						 if(res.data.errors.categoryName){
							 this.i(res.data.errors.categoryName[0])
						 }
						 if(res.data.errors.iconImage){
							 this.i(res.data.errors.iconImage[0])
						 }
					 }else{
 							this.swr()
					}
					
				}
			},
			showeditModal(category,index){
				// let obj={
				// 	id          :category.id,
				// 	categoryName:category.categoryName,
				// 	iconImage   :category.iconImage
				// }
				// this.editData = obj

				console.log(category)
				this.editData =category
				this.editModal= true
				this.index    = index
				this.isEditingItem=true
			},
			
			showdeletingModal(category, i){
				const deleteModalObj = {
						showDeleteModal :true,
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
				const res = await this.callApi('get','app/get_category')
				if(res.status == 200){
					this.categories = res.data
				}else{
					this.swr()
				}
		},
		
		components : {
			deleteModal
		}
		
}
</script>