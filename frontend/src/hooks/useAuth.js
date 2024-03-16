import { useState } from 'react';
import axios from '../axios';

const useAuth = () => {
  const [token,setToken] = useState('')
  const [user,setUser] = useState([])

  const login = async (email,password) => {
      try {
          const response = await axios.post('/api/login', { 
              email, 
              password,
            });
          setToken(response.data.access_token)
      } catch (error) {
          console.log(error)
      }
  }

  const refreshToken = async () => {
      try {
          const response = await axios.get('/api/refresh-token', { 
              headers:{
                  Authorization: `Bearer ${token}`
              }
            });
          setToken(response.data.access_token)
      } catch (error) {
          console.log(error)
      }
  }

  
  const fetchUser = async () => {
      try {
          await refreshToken()
          const response = await axios.get('/api/user', { 
              headers:{
                  Authorization: `Bearer ${token}`
              }
            });
          setUser(response.data)
      } catch (error) {
          console.log(error)
      }
  }

  return {token,user,login,fetchUser,refreshToken}
  };
  
  export default useAuth;



