<template>
    <div>
        <p>
            <input type="text">
        </p>
        <p>
        Bonjour {{items}}
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
             console.log('Component mounted.')
        },

           data() {
               return  {
                   Selected :null,
                   items: ['Debian','Ubuntu','Linux Mint','Redhat','Fedora','Centos','openSuse','Arch Linux','Manjaro','FreeBSD']
               }
        },
    }
</script>
