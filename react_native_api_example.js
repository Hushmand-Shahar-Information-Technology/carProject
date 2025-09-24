/**
 * React Native API Service Example
 * 
 * This is a simple example of how to connect a React Native application
 * to your Laravel API.
 */

class ApiService {
  constructor(baseURL) {
    this.baseURL = baseURL;
    this.token = null;
  }

  // Set the API token for authenticated requests
  setToken(token) {
    this.token = token;
  }

  // Remove the API token (for logout)
  removeToken() {
    this.token = null;
  }

  // Generic request method
  async request(endpoint, method = 'GET', data = null, authenticated = false) {
    const url = `${this.baseURL}${endpoint}`;
    const headers = {
      'Content-Type': 'application/json',
    };

    // Add authentication header if needed
    if (authenticated && this.token) {
      headers['Authorization'] = `Bearer ${this.token}`;
    }

    const config = {
      method,
      headers,
    };

    // Add body for POST/PUT requests
    if (data && (method === 'POST' || method === 'PUT')) {
      config.body = JSON.stringify(data);
    }

    try {
      const response = await fetch(url, config);
      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || 'API request failed');
      }

      return result;
    } catch (error) {
      console.error('API request error:', error);
      throw error;
    }
  }

  // Auth methods
  async register(userData) {
    const response = await this.request('/api/register', 'POST', userData);
    if (response.success && response.data.token) {
      this.setToken(response.data.token);
    }
    return response;
  }

  async login(credentials) {
    const response = await this.request('/api/login', 'POST', credentials);
    if (response.success && response.data.token) {
      this.setToken(response.data.token);
    }
    return response;
  }

  async logout() {
    const response = await this.request('/api/logout', 'POST', null, true);
    this.removeToken();
    return response;
  }

  async getUser() {
    return await this.request('/api/user', 'GET', null, true);
  }

  // Profile methods
  async getProfile() {
    return await this.request('/api/profile', 'GET', null, true);
  }

  async updateProfile(profileData) {
    return await this.request('/api/profile', 'PUT', profileData, true);
  }

  async changePassword(passwordData) {
    return await this.request('/api/profile/change-password', 'POST', passwordData, true);
  }

  // Bargain methods
  async getBargains(params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = `/api/bargains${queryString ? '?' + queryString : ''}`;
    return await this.request(endpoint, 'GET', null, true);
  }

  async getBargain(id) {
    return await this.request(`/api/bargains/${id}`, 'GET', null, true);
  }

  async createBargain(bargainData) {
    return await this.request('/api/bargains', 'POST', bargainData, true);
  }

  async updateBargain(id, bargainData) {
    return await this.request(`/api/bargains/${id}`, 'PUT', bargainData, true);
  }

  async deleteBargain(id) {
    return await this.request(`/api/bargains/${id}`, 'DELETE', null, true);
  }

  async toggleBargainStatus(id) {
    return await this.request(`/api/bargains/${id}/toggle-status`, 'POST', null, true);
  }

  async updateBargainStatus(id, statusData) {
    return await this.request(`/api/bargains/${id}/update-status`, 'POST', statusData, true);
  }

  async sendBargainWarning(id, warningData) {
    return await this.request(`/api/bargains/${id}/send-warning`, 'POST', warningData, true);
  }

  // Car methods
  async getCars(params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = `/api/cars${queryString ? '?' + queryString : ''}`;
    return await this.request(endpoint, 'GET', null, true);
  }

  async getCar(id) {
    return await this.request(`/api/cars/${id}`, 'GET', null, true);
  }

  async createCar(carData) {
    return await this.request('/api/cars', 'POST', carData, true);
  }

  async updateCar(id, carData) {
    return await this.request(`/api/cars/${id}`, 'PUT', carData, true);
  }

  async deleteCar(id) {
    return await this.request(`/api/cars/${id}`, 'DELETE', null, true);
  }

  async toggleCarPromoted(id) {
    return await this.request(`/api/cars/${id}/toggle-promoted`, 'POST', null, true);
  }

  async getCarOffers(id) {
    return await this.request(`/api/cars/${id}/offers`, 'GET', null, true);
  }

  // Dashboard methods
  async getDashboardStats() {
    return await this.request('/api/dashboard/stats', 'GET', null, true);
  }
}

// Usage example:
// const api = new ApiService('https://your-domain.com');

// api.register({
//   name: 'John Doe',
//   email: 'john@example.com',
//   password: 'password123',
//   password_confirmation: 'password123'
// }).then(response => {
//   console.log('Registration response:', response);
// }).catch(error => {
//   console.error('Registration error:', error);
// });

export default ApiService;