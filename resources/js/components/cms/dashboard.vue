<template>
        <div>
             <div class="card  ">
                <div class="card-body">
                        <h1>My Expenses</h1>
                        <div class="row"  style="height:80vh">
                                <div class="col-md-5">
                                        <table class="table shadow " style="margin-top:200px;">
                                                <thead class="thead-dark">
                                                        <th>Category</th>
                                                        <th>Total Amount</th>
                                                </thead>
                                                <tbody>
                                                        <tr v-for="categ in categories" :key="categ.id">
                                                        <td>{{ categ.name}}</td>
                                                        <td>${{ categ.total}}</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                </div>
                                <div class="col-md-7">
                                        <canvas id="expense_categories" class="m-auto" height="250"></canvas>
                                </div>
                        </div>
                </div>
              </div>
        </div>
</template>

<script>
export default {
        data: function(){
                return {
                        'categories': [],
                        'labels' : [],
                        'data' : [],
                }       
        },
        methods:{
                getChartData: function(){
                        let url = '/webapi/chart';
                        axios(url).then(resp =>{
                                console.log(resp.data.categories)
                                this.categories = resp.data.categories;
                        });
                },
                renderChart:function(){
                   let categories = document.getElementById('expense_categories');
                   let bgcolors = [];
                   /* Thanks to stack overflow :D */
                    var dynamicColors = function() {
                        var r = Math.floor(Math.random() * 255);
                        var g = Math.floor(Math.random() * 255);
                        var b = Math.floor(Math.random() * 255);
                        return "rgb(" + r + "," + g + "," + b + ")";
                     };
                   /* */
                        for (let ctr = 1 ; ctr<=this.data.length; ctr++) { //to make the background colors = to count of data
                                  bgcolors.push(dynamicColors()); 
                        }
                    console.log(bgcolors);

                     new Chart(categories,{
                           type:'pie',
                           data:{
                                  labels:this.labels,
                                 datasets:[{
                                        label: 'Total Amount Expense per Category',
                                        data: this.data,
                                        backgroundColor: bgcolors,
                                        
                                 }]
                           },
                            options: {
                                responsive: true
                            }
                   });
                }
        },
        watch:{
                categories: function(){
                        this.label = [],
                        this.data =  [],

                        this.categories.forEach( cat =>{
                             this.labels.push(cat.name);
                             this.data.push(cat.total);
                        });
                        this.renderChart();

                }
        },
        mounted: function(){
                this.getChartData();
        }

}
</script>


<style>

</style>