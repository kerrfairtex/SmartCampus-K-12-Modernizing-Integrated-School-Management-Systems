import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Bootstrap JS (required for dropdowns, collapse, alerts, etc.)
import 'bootstrap';
