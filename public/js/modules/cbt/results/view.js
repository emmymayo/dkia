export default{
    props:['results'],
    created(){
        console.log(this.results);
    },
    template:`
        <div class="my-2 pl-4">
            <div v-for="(result,index) in results" :key="result.id" class="shadow-sm p-2">
                <p></p>
                <p class="font-weight-bold" v-if="result.cbt_question">{{index+1}} Instruction:{{result.cbt_question.instruction}} </p>
                <p class="font-weight-bold" v-if="result.cbt_question">Question - {{result.cbt_question.question}} 
                    (<span class="small">
                    {{result.cbt_question.marks}} mark<span v-if="result.cbt_question.marks>1">s</span>
                    </span>)
                </p>
                <div v-if="result.cbt_question" class="pl-4">
                    <p v-for="option in result.cbt_question.answers" :key="option.id" class=" hover"> 
                        <span class="py-1 px-2 rounded-lg" :class="{'bg-info':option.id ==result.answer}" >
                            {{option.value}} 
                        </span> 
                        <i v-show="option.correct==true" class="text-success fa fa-check"></i>
                        <span v-show="option.id ==result.answer && option.correct==false " 
                              class="text-danger font-weight-bold fa fa-2x  "> &times;</span>
                    </p>
                </div>
                <hr class="">
            </div>
        </div>
        <div v-if="results.length==0" class="text-center">
            No result available.
        </div>
    
    `
}