<template>
       <div class="chat-conversation p-3 feed" >

                                             <ul v-if="contact" class="list-unstyled" style="max-height: 370px;">
            <li v-for="message in messages" :class="`message${message.to == contact.id ? ' right' : ' '}`" :key="message.id">
  
                 <div class="conversation-list">
                                    
                                                        <div class="ctext-wrap">
                                                            
                                                            <p>
                                                                 {{ message.text }}
                                                            </p>
    
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i>{{message.created_at}}</p>
                                                        </div>
                                                    </div>
            </li>
        </ul>
                                        </div>
</template>

<script>
    export default {
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>

.feed {
   
    height: 100%;
    max-height: 370px;
    overflow: scroll;

    ul {
        list-style-type: none;
        padding: 5px;

        li {
            &.message {
                margin: 10px 0;
                width: 100%;

                .text {
                    max-width: 200px;
                    border-radius: 5px;
                    padding: 12px;
                    display: inline-block;
                }

                &.received {
                    text-align: right;

                    .text {
                        background: #b2b2b2;
                    }
                }

                &.sent {
                    text-align: left;

                    .text {
                        background: #81c4f9;
                    }
                }
            }
        }
    }
}
</style>

