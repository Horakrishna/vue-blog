
<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blog Tag<Button @click="addModal=true"><Icon type="ios-add-circle-outline" />Add tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								
							<tr v-for="(tag, i) in tags" :key="i">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td format="yyyy/MM/dd" >{{tag.created_at | timeformat }}</td>
								<td>
									<Button type="info" size="small" @click="showeditModal(tag, i)">Edit</Button>
									<Button type="error" size="small" @click="showdeletingModal(tag, i)"  :loading="tag.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Add Model -->
				<Modal v-model="addModal" title="Add tag" :mask-closable="false" :closable="false" >
						<Input v-model="data.tagName" placeholder="Enter Your Tag Name" />
						<div slot="footer">
							<Button type="default" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Tag' }}</Button>
							<Button type="primary" @click="addModal=false">Close</Button>

						</div>
				</Modal>

				<!--Edit Model -->
				<Modal v-model="editModal" title="Edit tag" :mask-closable="false" :closable="false" >
						<Input v-model="editData.tagName" placeholder="Edit Your Tag Name" />
						<div slot="footer">
							<Button type="success" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'editing...' : 'Edit Tag' }}</Button>
							<Button type="primary" @click="editModal=false">Close</Button>

						</div>
				</Modal>

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
				tagName : ''
			 },
			 addModal   : false,
			 editModal  : false,
			 isAdding   : false,
			 tags       :[],
			 editData   :{
				 tagName : ''
			 },
			 index : -1,
			 isDeleting: false,
			 showDeleteModel: false,
			 deleteItem: {},
			 deletingIndex: -1
		 	}
		},

		methods : {
			async addTag(){
				 if(this.data.tagName.trim()=='')return this.e('Tag name is required')
				 const res =await this.callApi('post','app/create_tag', this.data)
				 if(res.status===201){
					 this.tags.unshift(res.data)
					 this.s('Tag has been added successfully')
						this.addModal= false,
						this.data.tagName =''
				 }else{
					 if(res.status===422){
						 if(res.data.errors.tagName){
							 this.i(res.data.errors.tagName[0])
						 }
					 }else{
 							this.swr()
					 }
					
				 }
			 },
			async editTag(){
				 if(this.editData.tagName.trim()=='') return this.e('Tag name is required')
				 const res = await this.callApi('post','app/edit_tag', this.editData)
				 if(res.status===200){
					 this.tags[this.index].tagName = this.editData.tagName
					 this.s('Tag has been Edited successfully')
						this.editModal= false
				 }else{
					 if(res.status===422){
						 if(res.data.errors.tagName){
							 this.i(res.data.errors.tagName[0])
						 }
					 }else{
 							this.swr()
					}
					
				}
			},
			showeditModal(tag,index){
				let obj={
					id     :tag.id,
					tagName:tag.tagName
				}
				this.editData = obj
				this.editModal= true
				this.index    = index
			},
			async deleteTag(){
				this.isDeleting =true
				const res = await this.callApi('post','app/detete_tag', this.deleteItem)
				if(res.status ===200){
					//this.tags.splice(this.deletingIndex, 1)
					this.s('Tag has been deleted successfully')
				}else{
					this.swr()
				}
				this.isDeleting =false
				this.showDeleteModel =false
			},
			showdeletingModal(tag, i){
					const deleteModalObj = {
						showDeleteModel : true,
						deleteUrl       :'app/detete_tag',
						data            :tag,
						deletingIndex   : i,
						isDeleted       :false
				}
				this.$store.commit('setDeletingModalObj', deleteModalObj)
				//console.log('delete method called')
				// this.deleteItem = tag
				// this.deletingIndex = i
				// this.showDeleteModel = true
			}

			
		},
		async created(){
				const res = await this.callApi('get','app/get_tags')
				if(res.status == 200){
					this.tags = res.data
				}else{
					this.swr()
				}
		},
		components:{
			deleteModal
		},
		computed : {
			...mapGetters(['getDeleteModalObj'])
		},
		watch : {
		getDeleteModalObj( obj ){
	       if(obj.isDeleted){
			   	this.tags.splice(obj.deletingIndex, 1)
		   }
			
		}
	}
		
}
</script>