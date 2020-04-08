export default class  Gate{
    constructor(user){
        this.user=user
    }
    isAdmin(){
        return this.user.type === 'admin';
    }
    isUser(){
        return this.user.type === 'user';
    }
    isBailleur(){
        return this.user.type === 'bailleurs';
    }
    isAdminOrBailleurs(){
        if(this.user.type === 'admin'|| this.user.type === 'bailleurs'){
            return true;
        }
    }
}