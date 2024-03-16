import { useState, useEffect } from 'react';
import useAuth from './hooks/useAuth';

function App() {
  const { login, fetchUser, user } = useAuth();
  const [email, setEmail] = useState('john@gmail.com');
  const [password, setPassword] = useState('john123');

  const handleSubmit = (e) => {
    e.preventDefault();
    login(email, password);
  };

  useEffect(() => {
    fetchUser();
  }, []);

  return (
    <>
      {user ? user : ''}
      <form onSubmit={handleSubmit}>
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <button type="submit">Submit</button>
      </form>
    </>
  );
}

export default App;
