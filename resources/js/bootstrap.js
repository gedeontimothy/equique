import axios from 'axios';
window.axios = axios;

globalThis.cdn = (link) => 'http://cdn.net' + link ?? '';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
