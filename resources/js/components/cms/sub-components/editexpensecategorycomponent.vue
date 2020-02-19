<template>
  <div>
       <form  @submit.prevent="EditCategory">
             <div class="form-group">
                  <label for="">Category Name </label>
                  <input type="text" v-model="categoryName"  class="form-control" required>
                  <span style="color:red">{{ CategoryNameValidation }}</span>
             </div>
             <div class="form-group">
                  <label for="">Description</label>
                  <input type="text" v-model="categoryDiscription"  class="form-control" required>
                  <span style="color:red">{{ CategoryDescValidation }}</span>
             </div>
              <button class="btn btn-primary" type="submit">Submit</button>
       </form>
  </div>
</template>

<script>
export default {
     props:{
          categoryID : { type: Number },
          allCategory: { type: Function }
     },
    data: function(){
        return {
            'categoryName' : null,
            'categoryDiscription': null,
            'hasError': false,
        }
    },
    methods:{
        EditCategory:function(){
          
          if(this.hasError == false){
               let data = {
                    'name':this.categoryName,
                    'description':this.categoryDiscription
               }
               let url = '/webapi/expense-categories/'+this.categoryID;
               axios.put(url,data).then(resp => {
                    if(resp.data.status == true){
                         this.categoryName = resp.data.name;
                         this.categoryDiscription = resp.data.description;
                         this.allCategory();
                          Swal.fire({
                              icon: 'success',
                              title: 'Success',
                              html: 'New Category Successfully Created!',
                              footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                          });
                    }else{
                         let errorm = '';
                         Object.keys(response.data.message).forEach(function(key) {
                              var value = response.data.message[key];
                              
                              value.forEach( element => {
                                   errorm = errorm + "<br>"+element;
                              });
                          });
                          Swal.fire({
                              icon: 'error',
                              title: 'Account Creation failed!',
                              html: errorm,
                              footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                          })
                    }
               });
          }
        },
   
    },
     watch:{
        categoryID: function(newVal, oldVal){
            let url = '/webapi/expense-categories/'+this.categoryID+'/edit';
             axios.get(url).then( resp =>{
                    this.categoryName = resp.data.name;
                    this.categoryDiscription =resp.data.description;
                    this.allCategory();

             });
        }
    },
    computed:{
        CategoryNameValidation: function(){
              if (this.categoryName == ''){
                   this.hasError = true;
                   console.log(this.categoryName);
                   return "Category name is required!"
              }else{
                    this.hasError = false;
                   return '';
              }
        },
        CategoryDescValidation:  function(){
             if(this.categoryDiscription == ''){
                this.hasError = true;
                 return "Category description is required!"
             }else{
                   this.hasError = false;
                  return '';
             }
        }
    }
}
</script>

<style>

</style>