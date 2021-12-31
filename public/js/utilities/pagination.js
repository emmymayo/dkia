/* Bootstrap Pagination componenet
    props: resource,
    emits: getPage--- event parameter is the page number
*/


export default{
    
    props:['resource'],
    emits:['getPage'],
    template: `
    <div>
    <p v-if="resource.data.length==0" class="my-2">No record available.</p>
    <p v-if="resource.data.length>0" class="">
             Showing {{resource.from+' - '+resource.to+ ' of '+resource.total}}
     </p>
     <div v-if="resource.data.length>0" class="pagination d-inline-block">

             <button class="btn btn-default" @click="$emit('getPage',1)">First</button>
             <button class="btn btn-default" v-if="(resource.current_page-2)>1" @click="">...</button>
             
             <button class="btn btn-default" v-if="resource.current_page>2" @click="$emit('getPage',resource.current_page-1)">{{resource.current_page-1}}</button>
             <button class="btn btn-primary" @click="$emit('getPage',resource.current_page)">{{resource.current_page}}</button>
             <button class="btn btn-default" v-if="(resource.current_page+1)<resource.last_page" @click="$emit('getPage',resource.current_page+1)">{{resource.current_page+1}}</button>
             
             
             <button class="btn btn-default" v-if="(resource.current_page+2)<resource.last_page" @click="">...</button>
             <button class="btn btn-default" @click="$emit('getPage',resource.last_page)">Last</button>
     </div>
     </div>
    `
}