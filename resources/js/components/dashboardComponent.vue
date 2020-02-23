<template>
    <div>
        <p>
            <input type="text">
        </p>
        <p>
        Bonjour {{name}}
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
                   'name' : 'dashboard'
               }
        },
    }
</script>
