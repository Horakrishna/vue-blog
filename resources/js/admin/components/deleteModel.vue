<template>
    <div>
        <!--Delete Model -->
		    <Modal 
			:mask-closable="false" :closable="false"
			:value="getDeleteModalObj.showDeleteModel" width="360">
		    <p slot="header" style="color:#f60;text-align:center">
			    <Icon type="ios-information-circle"></Icon>
			    <span>Delete confirmation</span>
		    </p>
		    <div style="text-align:center">		
			    <p>Are you sure to delete tag?</p>
		    </div>
		    <div slot="footer">
			    <Button type="primary" size="large"  @click="closeModal">Close</Button>
			    <Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
		    </div>
	    </Modal>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'
export default {
    data(){
        return{
        isDeleting: false,
        }
    },
    methods :{
        async deleteTag(){
           		//this.$store.commit('setDeleteModal')
				this.isDeleting =true
				const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
				
				if(res.status === 200){
					this.s('Tag has been deleted successfully!')
					this.$store.commit('setDeleteModal', true)
				}else{
					this.swr()
					this.$store.commit('setDeleteModal',false)
				}
				  
				
		},
		closeModal(){
			this.$store.commit('setDeleteModal',false)
		}
    },
    computed:{
        ...mapGetters(['getDeleteModalObj'])
    },
}
</script>