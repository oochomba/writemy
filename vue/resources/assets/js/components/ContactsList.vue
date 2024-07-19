<template>

                          <div class="chat-leftsidebar mr-lg-4">
                                <div class="card">
                                  

                                    <div class="chat-leftsidebar-nav">
                                       
                                        <div class="tab-content py-4">
                                            <div class="tab-pane show active" id="chat">
                                                <div class="contacts-list">
                                                   
                                                    <ul class="list-unstyled chat-list" style="max-height: 450px;" >
                                                        
                                                         <li   v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }"> 
                                                            <a href="javascript::void(0)">
                                                                <div class="media">
                                                                    <div class="align-self-center mr-3">
                                                                        <i class="mdi mdi-circle text-success font-size-10"></i>
                                                                    </div>
                                                                   <div class="align-self-center mr-3">
                                                <img :src="`http://127.0.0.1:8000/assets/images/avatars/${contact.avatar}`" :alt="contact.name" class="avatar-xs rounded-circle"/>
                                            </div>
                                                                    <div class="media-body overflow-hidden">
                                                                        <h5 class="text-truncate font-size-14 mb-1">{{ contact.name }}</h5>
                                                                       
                                                                    </div>
                                                                  <div class="font-size-11 badge badge-pill badge-danger float-right" v-if="contact.unread">{{ contact.unread }}</div>
                                                                </div>
                                                                
                                                             
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                          
                                       
                                        </div>
                                    </div>


                                </div>
                            </div>
                     

                      
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;

                this.$emit('selected', contact);
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }

                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>

<style lang="scss" scoped>
.unread{
    color:red;

}
.contacts-list {

    overflow: scroll;
  
 ul {
       

        li {
           
            cursor: pointer;

            &.selected {
                background: #bce5be;
            }
            }
            }

      
}
.list-cursor{
    cursor: pointer;
}
</style>
