import { defineStore } from 'pinia'
import ApiService from '@/services/axios'
export const useAuthStore = defineStore('auth', {
  state: () => ({ user: {} }),
  actions: {
    setAuth(user){
      this.setUser(user.data.user)
      this.setIsAdmin(user.data.user)
    },
    setUser(user){
      this.user = user;
    },
    setIsAdmin(user){
      storage.setItem("is_admin",  user.rol_id !== '3' ? true : false);
      storage.setItem("user_unique_id",user.id);
    },
    setRememberAccount({user, password, remember}){
      storage.setItem("rememberUser", user);
      storage.setItem("rememberPassword", password);
      storage.setItem("isRemember", remember);
    },
    clearRememberAccount(){
      storage.deleteItem("rememberUser");
      storage.deleteItem("rememberPassword");
      storage.deleteItem("isRemember");
    },
    preLogin(credentials){
      this.clearRememberAccount()
      if(credentials.remember == true) this.setRememberAccount(credentials)
    },
    async login(credentials) {
      return await new Promise((resolve, reject) => {
        ApiService.setHeader()
        ApiService.get('/sanctum/csrf-cookie')
        .then((response) => {
          console.log(response)
          ApiService.post('api/login', credentials)
          .then((response) => {
            console.log(response)
            // if(!data.data.access_token){
            //   throw data;
            // }
            // JwtService.saveToken(data.data.access_token);
            // if (JwtService.getToken()) {
            //   ApiService.setHeader();
            //   ApiService.get("api/user")
            //   .then( ( dataUser ) => {
            //     this.setAuth(dataUser.data)
            //     resolve(dataUser.data);
            //   })
            // }
          }).catch((response) =>{
            reject(response)
          })
        })
      }) 
      .catch((response) => {
        console.log(response)
        return 'Algo ha salido mal'
      })
    },
    async currentUser() {
      return await new Promise((resolve) => {

        ApiService.setHeader();
        ApiService.get("/api/user")
          .then(({ data }) => {
            if(data.code !== 200){
              throw data;
            }
            this.setUser(data.data)
            resolve(data)
          }).catch(( response ) => {
            console.log(response)
            resolve('Error al obtener');
          });
        
      })
      .catch(( response ) => {
        console.log(response)
        return 'Error al obtener';
      });
    },
    async logout(){
      return await new Promise((resolve) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("api/auth/logout")
            .then(({ data }) => {
              if(data.code !== 200){
                throw data;
              }
              this.logoutAction()
              resolve(data)
            })
        }
      })
      .catch(( response ) => {
        console.log(response)
        resolve('Error al cerrar sesión');
      });
    },
  },
})