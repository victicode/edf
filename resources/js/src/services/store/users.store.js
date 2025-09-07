import { defineStore } from 'pinia'
import ApiService from '@/services/axios'

export const useUserStore = defineStore('User', {
  actions: {
    async createUser(data) {
      return await new Promise((resolve, reject) => {
        if (!ApiService.getToken()) {
          throw '';
        }
        ApiService.setHeader();
        ApiService.post('/api/users', data)
        .then(({data}) => {
          if(data.code !=200) throw data;
          
          resolve(data);
        }).catch(( {response}) => {
          console.log(response)
          if(response.data.code == 403){
            reject(response.data);
          }
          reject(response.data.error);
        });
        
      })

    },
    async assingApartment(data){
      return await new Promise((resolve, reject) => {
        if (!ApiService.getToken()) {
          throw '';
        }
        ApiService.setHeader();
        ApiService.post('/api/users/assing_apartmet', data)
        .then(({data}) => {
          if(data.code !=200) throw data;
          
          resolve(data);
        }).catch(( {response}) => {
          console.log(response)
          if(response.data.code == 403){
            reject(response.data);
          }
          reject(response.data.error);
        });
        
      })
    },
    
    async getUserById(id) {
      return await new Promise((resolve, reject) => {
        if (!ApiService.getToken()) {
          throw '';
        }
        ApiService.get('/api/users/byId/'+id)
        .then(({data}) => {
          if(data.code !=200) throw data;
  
          resolve(data);
        }).catch(( {response}) => {
          console.log(response)
          reject(response.data.error);
        });
        
      })

    },
    async getUsers(data) {
      return await new Promise((resolve, reject) => {
        if (!ApiService.getToken()) {
          throw '';
        }
        ApiService.setHeader();
        ApiService.get('/api/users?page='+data.page+'&'+'search='+data.search+'&'+'rol='+data.rol+'&')
        .then(({data}) => {
          if(data.code !=200) throw data;
          
          resolve(data);
        }).catch(( {response}) => {
          console.log(response)
          reject(response.data.error);
        });
        
      })
    },
    async deleteUser(id) {
      return await new Promise((resolve, reject) => {
        if (!ApiService.getToken()) {
          throw '';
        }
        ApiService.setHeader();
        ApiService.post('/api/users/d/'+id)
        .then(({data}) => {
          if(data.code !=200) throw data;
          
          resolve(data);
        }).catch(( {response}) => {
          console.log(response)
          reject(response.data.error);
        });
        
      })

    },
    
  },
})