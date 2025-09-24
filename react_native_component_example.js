/**
 * React Native Component Example
 * 
 * This is a simple example of how to use the API service in a React Native component.
 */

import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, Button, FlatList, StyleSheet, Alert } from 'react-native';
import ApiService from './react_native_api_example';

// Initialize the API service
const api = new ApiService('https://your-domain.com'); // Replace with your actual domain

const App = () => {
  const [user, setUser] = useState(null);
  const [bargains, setBargains] = useState([]);
  const [loading, setLoading] = useState(false);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  // Check if user is already logged in
  useEffect(() => {
    // In a real app, you would check AsyncStorage for a saved token
    // const token = await AsyncStorage.getItem('api_token');
    // if (token) {
    //   api.setToken(token);
    //   fetchUser();
    // }
  }, []);

  const fetchUser = async () => {
    try {
      setLoading(true);
      const response = await api.getUser();
      setUser(response.data);
    } catch (error) {
      console.error('Failed to fetch user:', error);
      Alert.alert('Error', 'Failed to fetch user data');
    } finally {
      setLoading(false);
    }
  };

  const fetchBargains = async () => {
    try {
      setLoading(true);
      const response = await api.getBargains();
      setBargains(response.data.data); // Assuming paginated data
    } catch (error) {
      console.error('Failed to fetch bargains:', error);
      Alert.alert('Error', 'Failed to fetch bargains');
    } finally {
      setLoading(false);
    }
  };

  const handleLogin = async () => {
    try {
      setLoading(true);
      const response = await api.login({ email, password });
      
      if (response.success) {
        setUser(response.data.user);
        // In a real app, you would save the token to AsyncStorage
        // await AsyncStorage.setItem('api_token', response.data.token);
        Alert.alert('Success', 'Logged in successfully');
      } else {
        Alert.alert('Error', response.message);
      }
    } catch (error) {
      console.error('Login failed:', error);
      Alert.alert('Error', 'Login failed');
    } finally {
      setLoading(false);
    }
  };

  const handleLogout = async () => {
    try {
      await api.logout();
      setUser(null);
      setBargains([]);
      // In a real app, you would remove the token from AsyncStorage
      // await AsyncStorage.removeItem('api_token');
      Alert.alert('Success', 'Logged out successfully');
    } catch (error) {
      console.error('Logout failed:', error);
      Alert.alert('Error', 'Logout failed');
    }
  };

  const renderBargain = ({ item }) => (
    <View style={styles.bargainItem}>
      <Text style={styles.bargainName}>{item.name}</Text>
      <Text>Status: {item.registration_status}</Text>
      <Text>Registration #: {item.registration_number}</Text>
    </View>
  );

  if (!user) {
    return (
      <View style={styles.container}>
        <Text style={styles.title}>Car Project Login</Text>
        <TextInput
          style={styles.input}
          placeholder="Email"
          value={email}
          onChangeText={setEmail}
          keyboardType="email-address"
          autoCapitalize="none"
        />
        <TextInput
          style={styles.input}
          placeholder="Password"
          value={password}
          onChangeText={setPassword}
          secureTextEntry
        />
        <Button title={loading ? "Logging in..." : "Login"} onPress={handleLogin} disabled={loading} />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Welcome, {user.name}!</Text>
      <View style={styles.buttonRow}>
        <Button title="Fetch Profile" onPress={fetchUser} disabled={loading} />
        <Button title="Fetch Bargains" onPress={fetchBargains} disabled={loading} />
        <Button title="Logout" onPress={handleLogout} disabled={loading} />
      </View>
      
      {loading && <Text>Loading...</Text>}
      
      <FlatList
        data={bargains}
        keyExtractor={(item) => item.id.toString()}
        renderItem={renderBargain}
        ListEmptyComponent={<Text>No bargains found</Text>}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#fff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginBottom: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 20,
  },
  bargainItem: {
    padding: 15,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
  bargainName: {
    fontSize: 18,
    fontWeight: 'bold',
  },
});

export default App;