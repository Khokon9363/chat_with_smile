<template>
<div class="container">
   <div class="row mt-4">
      <div class="col-12">
         <h2 class="text-center text-white">Edward Anthony Jenner</h2>
      </div>
   </div>
   <div class="row mt-3">
     <div class="col-3 col-sm-3-border" style="background-color: white;">
           <ul>
              <li class="active" v-for="user in users" :key="user.id" @click="userSelected(user.id,user.name)">{{ user.name }}</li>
           </ul>
     </div>
     <div class="col-9 col-sm-9-border" style="background-color: white;">
        <h3 class="text-center mt-2">Chat with- "{{ selectedName }}"</h3><hr>
        <div class="height-col-9" v-chat-scroll="{smooth: true}">
           <ul>
              <div v-for="chat in chats" :key="chat.id">
                <li v-if="chat.sender == sessionId" class="text-right"><small>{{ chat.created_at }} - </small>{{ chat.chat }}</li>
                <li v-else class="text-left">{{ chat.chat }} <small> - {{ chat.created_at }}</small></li>
              </div>
           </ul>
        </div>
        <form @submit.prevent="send()" method="POST">
         <div class="form-row">
            <div class="col-10">
               <input type="hidden" v-model="selectedId">
               <textarea @keypress.enter="send()" v-model="chat" class="form-control" placeholder="Write here..." rows="3"></textarea>
            </div>
            <div class="col">
               <button type="submit" class="btn btn-success btn-block h-100"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
         </div>
        </form>
     </div>
   </div>
</div>
</template>
<script>
export default {
    data(){
       return{
          users : [],
          chats : [],
          selectedName : null,
          selectedId : null,
          chat : null,
          sessionId : Number(document.getElementById('sessionId').value),
       }
    },
    mounted(){
      //   Echo.join('chat')
      //       .here((users) => {
      //          console.log(users);
      //       })
      //       .joining((user) => {
      //          console.log(user.name);
      //       })
      //       .leaving((user) => {
      //          console.log(user.name);
      //       });

       this.getUsers()
    },
    methods:{
       getUsers(){
          axios.get('/get_users')
          .then(response =>{
             this.users = response.data
          })
          .catch(error =>{
             console.log(error);
          })
       },
       userSelected(userId,userName){
          this.selectedName = userName
          this.selectedId = userId
          axios.get('/get_chats/'+userId)
          .then(response =>{
             this.chats = response.data
          })
          .catch(error =>{
             console.log(error);
          })
       },
       send(){
          axios.post('send',{
             receiver : this.selectedId,
             chat : this.chat
          })
          .then(response =>{
             this.userSelected(this.selectedId,this.selectedName)
             this.chat = null
             Vue.$toast.open('Message send successfully to '+this.selectedName+' !');
          })
          .catch(error =>{
             console.log(error);
          })
       }
    }
}
</script>
<style scoped>
    .col-sm-3-border{
       border-radius: 10px 0px 0px 10px;
       height: 661px;
       overflow: scroll;
    }
    .col-sm-9-border{
       border-radius: 0px 10px 10px 0px;
    }
    .height-col-9{
       height: 501px;
       overflow: scroll;
    }
    ul li{
       list-style-type: none;
       border: 1px solid lightgray;
       padding: 10px;
       text-align: center;
    }
    ul{
       margin: 0;
       padding: 0;
    }
    ul .active{
       background-color: gainsboro;
    }
    ul .text-left,.text-right{
       border: none;
    }
    .text-right{
       color: hotpink;
    }
    .text-left{
       color: red;
    }
    small{
       color: green;
    }
    @media only screen and (max-width: 400px) {
       ul li {
          font-size: 12px;
       }
    }
    @media only screen and (max-width: 550px) {
       .height-col-9 {
          height: 397px;
       }
       textarea{
          width: 120%;
       }
    }
</style>