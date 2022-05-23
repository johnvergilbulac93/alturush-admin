export default class gate{

     constructor(user)
     {
         this.user = user;
     }
     isAdmin()
     {
         return this.user === 6;
     }
     isSuperAdmin()
     {
          return this.user === 12;
     }
   
     isGGM()
     {
        return this.user === 15;
     }
     isIAD()
     {
        return this.user === 17;
     }
     isPurchasing()
     {
        return this.user === 16;
     }
     isAccounting()
     {
        return this.user === 8;
     }
     isSupervisor()
     {
        return this.user === 14;
     }
 
 
 
 
 
 }