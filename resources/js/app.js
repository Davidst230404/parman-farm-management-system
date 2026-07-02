import '../css/auth/login.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './auth/login';

const images = import.meta.glob('../images/**/*', { eager: true });